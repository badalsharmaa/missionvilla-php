<?php

namespace Tests\Feature;

use App\Content\InvalidSectionData;
use App\Content\Sections\RespiteCareCaregiverSection;
use App\Content\Sections\RespiteCareFaqSection;
use App\Content\Sections\RespiteCareHeroSection;
use App\Content\Sections\RespiteCareInclusionsSection;
use App\Content\Sections\RespiteCareScenariosSection;
use App\Content\Sections\RespiteCareStorySection;
use App\Content\Sections\RespiteCareTimelineSection;
use Tests\TestCase;

class RespiteCarePageTest extends TestCase
{
    private function respiteCarePageData(): array
    {
        return require base_path('content/pages/respite-care.php');
    }

    public function test_respite_care_route_returns_200_and_renders_all_sections_in_order(): void
    {
        $response = $this->get('/respite-care');
        $response->assertOk();
        $html = $response->getContent();

        // SEO meta
        $this->assertStringContainsString('<title>Short-Term Respite Care in Daly City | Mission Villa Senior Living</title>', $html);
        $this->assertStringContainsString('Flexible short-term respite care stays in Daly City', $html);

        // Header active state for Respite Care
        $this->assertStringContainsString('class="site-nav__link is-active"  aria-current="page" >Respite Care</a>', $html);

        // All 8 sections present in order
        $heroPos = strpos($html, 'id="rc-hero"');
        $scenariosPos = strpos($html, 'id="respite-scenarios"');
        $inclusionsPos = strpos($html, 'id="respite-inclusions"');
        $storyPos = strpos($html, 'id="respite-story"');
        $caregiverPos = strpos($html, 'id="respite-caregiver"');
        $timelinePos = strpos($html, 'id="respite-planning"');
        $faqPos = strpos($html, 'id="respite-faq"');
        $visitPos = strpos($html, 'id="visit"');

        $this->assertNotFalse($heroPos, 'Hero section missing');
        $this->assertNotFalse($scenariosPos, 'Scenarios section missing');
        $this->assertNotFalse($inclusionsPos, 'Inclusions section missing');
        $this->assertNotFalse($storyPos, 'Story section missing');
        $this->assertNotFalse($caregiverPos, 'Caregiver section missing');
        $this->assertNotFalse($timelinePos, 'Timeline section missing');
        $this->assertNotFalse($faqPos, 'FAQ section missing');
        $this->assertNotFalse($visitPos, 'Closing visit CTA section missing');

        $this->assertTrue($heroPos < $scenariosPos, 'Hero must precede Scenarios');
        $this->assertTrue($scenariosPos < $inclusionsPos, 'Scenarios must precede Inclusions');
        $this->assertTrue($inclusionsPos < $storyPos, 'Inclusions must precede Story');
        $this->assertTrue($storyPos < $caregiverPos, 'Story must precede Caregiver');
        $this->assertTrue($caregiverPos < $timelinePos, 'Caregiver must precede Timeline');
        $this->assertTrue($timelinePos < $faqPos, 'Timeline must precede FAQ');
        $this->assertTrue($faqPos < $visitPos, 'FAQ must precede Visit CTA');

        // Global footer & inquiry dialog present
        $this->assertStringContainsString('<footer class="site-footer"', $html);
        $this->assertStringContainsString('data-inquiry-dialog', $html);
    }

    public function test_all_form_ctas_use_tel_fallback_and_data_inquiry_with_respite_care(): void
    {
        $html = $this->get('/respite-care')->assertOk()->getContent();

        // Matches all CTAs that trigger the inquiry modal
        preg_match_all('/<a[^>]+data-inquiry="([^"]+)"[^>]*>/', $html, $matches);
        $this->assertNotEmpty($matches[0], 'Expected data-inquiry triggers on the Respite Care page');

        foreach ($matches[0] as $tag) {
            $this->assertStringContainsString('href="tel:16507561995"', $tag, "Form CTA must fall back to tel: — got: $tag");
            $this->assertStringNotContainsString('href="#contact"', $tag);
            $this->assertStringNotContainsString('href="#visit"', $tag);
            $this->assertStringNotContainsString('href="#schedule-visit"', $tag);
        }

        // Primary conversion actions preselect respite_care
        $this->assertStringContainsString('data-inquiry-care="respite_care"', $html);
    }

    public function test_closing_section_contains_inline_inquiry_form_with_respite_care_preset(): void
    {
        $html = $this->get('/respite-care')->assertOk()->getContent();

        $this->assertStringContainsString('id="visit-form"', $html);
        $this->assertStringContainsString('name="care_interest" value="respite_care"', $html);
        $this->assertStringContainsString('Respite Care Inquiry', $html);
    }

    public function test_interactive_scenarios_selector_markup_and_accessibility(): void
    {
        $html = $this->get('/respite-care')->assertOk()->getContent();

        $this->assertStringContainsString('role="tablist"', $html);
        $this->assertSame(4, substr_count($html, 'role="tab"'));
        $this->assertSame(4, substr_count($html, 'role="tabpanel"'));

        // First tab is active
        $this->assertStringContainsString('aria-selected="true"', $html);
        $this->assertStringContainsString('aria-selected="false"', $html);

        // Inactive panels have inert
        $this->assertStringContainsString('inert', $html);
    }

    public function test_stay_planning_timeline_markup_and_accessibility(): void
    {
        $html = $this->get('/respite-care')->assertOk()->getContent();

        $this->assertStringContainsString('id="respite-planning"', $html);
        $this->assertStringContainsString('data-rc-step="1"', $html);
        $this->assertStringContainsString('data-rc-step="5"', $html);
        $this->assertStringContainsString('Reach Out', $html);
        $this->assertStringContainsString('Care Review', $html);
        $this->assertStringContainsString('Choose Dates', $html);
        $this->assertStringContainsString('Prepare for Arrival', $html);
        $this->assertStringContainsString('Welcome to Mission Villa', $html);
    }

    public function test_respite_faq_accordion_and_planning_guide_card(): void
    {
        $html = $this->get('/respite-care')->assertOk()->getContent();

        // Planning guide card present
        $this->assertStringContainsString('Respite Stay Planning Guide', $html);
        $this->assertStringContainsString('data-inquiry-source="rc-faq"', $html);

        // Accordion questions present
        $this->assertStringContainsString('How long can a respite stay be?', $html);
        $this->assertStringContainsString('What’s included in a short-term stay?', $html);
        $this->assertStringContainsString('Can you support someone with memory loss during a respite stay?', $html);
        $this->assertStringContainsString('aria-expanded="true"', $html);
        $this->assertStringContainsString('aria-expanded="false"', $html);
    }

    public function test_images_declare_provenance_and_rights(): void
    {
        $html = $this->get('/respite-care')->assertOk()->getContent();

        // All section content images must declare provenance & rights
        preg_match_all('/<img[^>]+class="rc-[^"]+"[^>]*>/', $html, $matches);
        $this->assertNotEmpty($matches[0], 'Expected rc- images on the page');

        foreach ($matches[0] as $tag) {
            $this->assertMatchesRegularExpression('/data-provenance="(facility|illustrative)"/', $tag);
            $this->assertMatchesRegularExpression('/data-rights="(cleared|unconfirmed)"/', $tag);
            $this->assertMatchesRegularExpression('/alt="[^"]+"/', $tag);
        }
    }

    public function test_respite_hero_schema_validation(): void
    {
        $schema = new RespiteCareHeroSection();
        $page = $this->respiteCarePageData();
        $heroData = collect($page['sections'])->firstWhere('key', 'rc-hero')['data'];

        $normalized = $schema->normalize($heroData);
        $this->assertSame('Short-Term Stays at Mission Villa', $normalized['eyebrow']);
        $this->assertCount(3, $normalized['strip']);
        $this->assertSame('respite_care', $normalized['actions'][0]['care']);

        $this->expectException(InvalidSectionData::class);
        $badData = $heroData;
        unset($badData['image']);
        $schema->normalize($badData);
    }

    public function test_respite_scenarios_schema_validation(): void
    {
        $schema = new RespiteCareScenariosSection();
        $page = $this->respiteCarePageData();
        $data = collect($page['sections'])->firstWhere('key', 'rc-scenarios')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(4, $normalized['scenarios']);
        $this->assertSame('Caregiver Rest & Renewal', $normalized['scenarios'][0]['title']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        array_pop($badData['scenarios']); // requires exactly 4 scenarios
        $schema->normalize($badData);
    }

    public function test_respite_inclusions_schema_validation(): void
    {
        $schema = new RespiteCareInclusionsSection();
        $page = $this->respiteCarePageData();
        $data = collect($page['sections'])->firstWhere('key', 'rc-inclusions')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(6, $normalized['items']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        $badData['items'][0]['icon'] = 'invalid-icon';
        $schema->normalize($badData);
    }

    public function test_respite_story_schema_validation(): void
    {
        $schema = new RespiteCareStorySection();
        $page = $this->respiteCarePageData();
        $data = collect($page['sections'])->firstWhere('key', 'rc-story')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(3, $normalized['moments']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        unset($badData['moments']);
        $schema->normalize($badData);
    }

    public function test_respite_caregiver_schema_validation(): void
    {
        $schema = new RespiteCareCaregiverSection();
        $page = $this->respiteCarePageData();
        $data = collect($page['sections'])->firstWhere('key', 'rc-caregiver')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(3, $normalized['concepts']);
        $this->assertCount(2, $normalized['actions']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        unset($badData['concepts']);
        $schema->normalize($badData);
    }

    public function test_respite_timeline_schema_validation(): void
    {
        $schema = new RespiteCareTimelineSection();
        $page = $this->respiteCarePageData();
        $data = collect($page['sections'])->firstWhere('key', 'rc-timeline')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(5, $normalized['steps']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        array_pop($badData['steps']); // requires exactly 5 steps
        $schema->normalize($badData);
    }

    public function test_respite_faq_schema_validation(): void
    {
        $schema = new RespiteCareFaqSection();
        $page = $this->respiteCarePageData();
        $data = collect($page['sections'])->firstWhere('key', 'rc-faq')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(5, $normalized['faqs']);
        $this->assertSame('Respite Stay Planning Guide', $normalized['guide']['title']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        unset($badData['guide']);
        $schema->normalize($badData);
    }
}
