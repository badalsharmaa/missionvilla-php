<?php

namespace Tests\Feature;

use App\Content\InvalidSectionData;
use App\Content\Sections\AboutCoreValuesSection;
use App\Content\Sections\AboutGeographySection;
use App\Content\Sections\AboutHeroSection;
use App\Content\Sections\AboutPhilosophySection;
use App\Content\Sections\AboutTeamCommitmentSection;
use Tests\TestCase;

class AboutPageTest extends TestCase
{
    private function aboutPageData(): array
    {
        return require base_path('content/pages/about.php');
    }

    public function test_about_route_returns_200_and_renders_all_sections_in_order(): void
    {
        $response = $this->get('/about');
        $response->assertOk();
        $html = $response->getContent();

        // SEO meta
        $this->assertStringContainsString('<title>About Us: Compassionate Memory Care in Daly City | Mission Villa</title>', $html);
        $this->assertStringContainsString('Discover Mission Villa Senior Living at 995 East Market Street in Daly City', $html);

        // Sections presence in order
        $heroPos = strpos($html, 'data-about-hero');
        $philPos = strpos($html, 'id="care-philosophy-narrative"');
        $geoPos = strpos($html, 'id="daly-city-geography"');
        $valsPos = strpos($html, 'id="values-and-activities"');
        $teamPos = strpos($html, 'id="team-and-policies"');
        $visitPos = strpos($html, 'id="visit"');

        $this->assertNotFalse($heroPos, 'Hero section missing');
        $this->assertNotFalse($philPos, 'Care Philosophy section missing');
        $this->assertNotFalse($geoPos, 'Daly City Geography section missing');
        $this->assertNotFalse($valsPos, 'Values and Activities section missing');
        $this->assertNotFalse($teamPos, 'Team and Policies section missing');
        $this->assertNotFalse($visitPos, 'Closing visit CTA section missing');

        $this->assertTrue($heroPos < $philPos, 'Hero must precede Philosophy');
        $this->assertTrue($philPos < $geoPos, 'Philosophy must precede Geography');
        $this->assertTrue($geoPos < $valsPos, 'Geography must precede Values');
        $this->assertTrue($valsPos < $teamPos, 'Values must precede Team');
        $this->assertTrue($teamPos < $visitPos, 'Team must precede Visit CTA');

        // Global footer & inquiry dialogs present
        $this->assertStringContainsString('<footer class="site-footer"', $html);
        $this->assertStringContainsString('data-inquiry-dialog', $html);
    }

    public function test_all_form_ctas_use_tel_fallback_or_data_inquiry(): void
    {
        $html = $this->get('/about')->assertOk()->getContent();

        preg_match_all('/<a[^>]+data-inquiry="([^"]+)"[^>]*>/', $html, $matches);
        foreach ($matches[0] as $tag) {
            $this->assertStringContainsString('href="tel:16507561995"', $tag, "Form CTA must fall back to tel: — got: $tag");
            $this->assertStringNotContainsString('href="#contact"', $tag);
            $this->assertStringNotContainsString('href="#visit"', $tag);
            $this->assertStringNotContainsString('href="#schedule-visit"', $tag);
        }

        // Form buttons must use data-inquiry
        $this->assertStringContainsString('data-inquiry="schedule_visit"', $html);
    }

    public function test_closing_section_contains_inline_inquiry_form(): void
    {
        $html = $this->get('/about')->assertOk()->getContent();

        $this->assertStringContainsString('id="visit-form"', $html);
        $this->assertStringContainsString('name="care_interest" value="exploring"', $html);
        $this->assertStringContainsString('About Mission Villa Inquiry', $html);
        $this->assertStringContainsString('Submissions save locally while we finalize direct staff notifications', $html);
        $this->assertStringNotContainsString('Our community director will reach out promptly', $html);
    }

    public function test_hero_section_renders_trust_ledger_and_arched_study(): void
    {
        $html = $this->get('/about')->assertOk()->getContent();

        $this->assertStringContainsString('CA License #415601046', $html);
        $this->assertStringContainsString('01 · Our Focus', $html);
        $this->assertStringContainsString('02 · Our Setting', $html);
        $this->assertStringContainsString('03 · Licensed Stewardship', $html);
        $this->assertStringContainsString('Person-Centered Philosophy', $html);
        $this->assertStringContainsString('Known by Name, Life Story &amp; Everyday Comforts', $html);
        $this->assertStringContainsString('Near San Bruno Mountain', $html);
        $this->assertStringContainsString('Family Partnership', $html);
    }

    public function test_philosophy_section_renders_four_chapters_and_in_everyday_life_points(): void
    {
        $html = $this->get('/about')->assertOk()->getContent();

        $this->assertStringContainsString('Chapter I', $html);
        $this->assertStringContainsString('Honoring the Individual Behind Every Life Story', $html);
        $this->assertStringContainsString('Chapter II', $html);
        $this->assertStringContainsString('The Legacies™ Philosophy of Familiar Connection', $html);
        $this->assertStringContainsString('Chapter III', $html);
        $this->assertStringContainsString('Lifting the Caregiving Burden So Families Can Reconnect', $html);
        $this->assertStringContainsString('Chapter IV', $html);
        $this->assertStringContainsString('A Homelike Community Rather Than an Institution', $html);

        $this->assertStringContainsString('How Families See This in Daily Life at Mission Villa:', $html);
        $this->assertStringContainsString('Our Commitment to Your Family', $html);
        $this->assertStringNotContainsString('APPROVED FOR PROTOTYPE', $html);
        $this->assertStringContainsString('about-phil__prov-pill', $html);
    }

    public function test_geography_section_renders_landmarks_and_san_bruno_mountain_context(): void
    {
        $html = $this->get('/about')->assertOk()->getContent();

        $this->assertStringContainsString('LOC 01', $html);
        $this->assertStringContainsString('Nestled Near San Bruno Mountain in Daly City', $html);
        $this->assertStringContainsString('LOC 02', $html);
        $this->assertStringContainsString('Effortless Visits for San Francisco &amp; Peninsula Families', $html);
        $this->assertStringContainsString('LOC 03', $html);
        $this->assertStringContainsString('Connected to Surrounding Peninsula Amenities', $html);
        $this->assertStringContainsString('LOC 04', $html);
        $this->assertStringContainsString('Scenic Drives &amp; Coastal Peninsula Vistas', $html);

        $this->assertStringContainsString('Why This Location Matters for Residents &amp; Families:', $html);
        $this->assertStringContainsString('995 East Market Street, Daly City, CA 94014', $html);
        $this->assertStringContainsString('about-geo__prov-pill', $html);
    }

    public function test_core_values_section_renders_four_values_with_activities(): void
    {
        $html = $this->get('/about')->assertOk()->getContent();

        $this->assertStringContainsString('Core Value 01', $html);
        $this->assertStringContainsString('Unconditional Dignity &amp; Respect', $html);
        $this->assertStringContainsString('Core Value 02', $html);
        $this->assertStringContainsString('Engaging Daily Community Activities', $html);
        $this->assertStringContainsString('Core Value 03', $html);
        $this->assertStringContainsString('Warm Hospitality &amp; Shared Table', $html);
        $this->assertStringContainsString('Core Value 04', $html);
        $this->assertStringContainsString('Transparent Family Partnership', $html);

        $this->assertStringContainsString('Connected Community Activities &amp; Experiences:', $html);
    }

    public function test_team_stewardship_renders_without_invented_portraits(): void
    {
        $html = $this->get('/about')->assertOk()->getContent();

        $this->assertStringContainsString('Awaiting Official Team Bios &amp; Portraits', $html);
        $this->assertStringContainsString('Meet Our Team in Person at 995 East Market Street.', $html);
        $this->assertStringContainsString('24-Hour Dedicated Care Staff', $html);
        $this->assertStringContainsString('Activity Director &amp; Life Enrichment', $html);
        $this->assertStringContainsString('Culinary &amp; Full-Table Dining Team', $html);
        $this->assertStringContainsString('Community Leadership, Concierge &amp; Housekeeping', $html);
        $this->assertStringContainsString('Suggested Question for Your Tour:', $html);
    }

    public function test_pet_policy_disclosure_renders_with_conditional_badge(): void
    {
        $html = $this->get('/about')->assertOk()->getContent();

        $this->assertStringContainsString('Conditional Community Policy · Confirm Details on Tour', $html);
        $this->assertStringContainsString('Pet-Friendly Community Policy (With Applicable Restrictions)', $html);
        $this->assertStringContainsString('Status: CLIENT CONFIRMATION REQUIRED', $html);
        $this->assertStringContainsString('Direct Team Conversation', $html);
    }

    public function test_about_hero_schema_validation(): void
    {
        $page = $this->aboutPageData();
        $section = collect($page['sections'])->firstWhere('type', 'about.hero');
        $schema = new AboutHeroSection;

        $normalized = $schema->normalize($section['data']);
        $this->assertSame('about.hero', AboutHeroSection::type());
        $this->assertCount(3, $normalized['trust_ledger']);
        $this->assertCount(4, $normalized['jump_links']);

        $this->expectException(InvalidSectionData::class);
        $invalidData = $section['data'];
        unset($invalidData['eyebrow']);
        $schema->normalize($invalidData);
    }

    public function test_about_philosophy_schema_validation(): void
    {
        $page = $this->aboutPageData();
        $section = collect($page['sections'])->firstWhere('type', 'about.philosophy');
        $schema = new AboutPhilosophySection;

        $normalized = $schema->normalize($section['data']);
        $this->assertSame('about.philosophy', AboutPhilosophySection::type());
        $this->assertCount(4, $normalized['chapters']);

        $this->expectException(InvalidSectionData::class);
        $invalidData = $section['data'];
        $invalidData['chapters'] = [];
        $schema->normalize($invalidData);
    }

    public function test_about_geography_schema_validation(): void
    {
        $page = $this->aboutPageData();
        $section = collect($page['sections'])->firstWhere('type', 'about.geography');
        $schema = new AboutGeographySection;

        $normalized = $schema->normalize($section['data']);
        $this->assertSame('about.geography', AboutGeographySection::type());
        $this->assertCount(4, $normalized['landmarks']);

        $this->expectException(InvalidSectionData::class);
        $invalidData = $section['data'];
        unset($invalidData['address']);
        $schema->normalize($invalidData);
    }

    public function test_about_core_values_schema_validation(): void
    {
        $page = $this->aboutPageData();
        $section = collect($page['sections'])->firstWhere('type', 'about.core-values');
        $schema = new AboutCoreValuesSection;

        $normalized = $schema->normalize($section['data']);
        $this->assertSame('about.core-values', AboutCoreValuesSection::type());
        $this->assertCount(4, $normalized['values']);

        $this->expectException(InvalidSectionData::class);
        $invalidData = $section['data'];
        unset($invalidData['values']);
        $schema->normalize($invalidData);
    }

    public function test_about_team_commitment_schema_validation(): void
    {
        $page = $this->aboutPageData();
        $section = collect($page['sections'])->firstWhere('type', 'about.team-commitment');
        $schema = new AboutTeamCommitmentSection;

        $normalized = $schema->normalize($section['data']);
        $this->assertSame('about.team-commitment', AboutTeamCommitmentSection::type());
        $this->assertCount(4, $normalized['roles']);

        $this->expectException(InvalidSectionData::class);
        $invalidData = $section['data'];
        unset($invalidData['pet_policy']);
        $schema->normalize($invalidData);
    }
}
