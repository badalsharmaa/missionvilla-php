<?php

namespace Tests\Feature;

use App\Content\InvalidSectionData;
use App\Content\Sections\LifeAtMissionVillaEngagementSection;
use App\Content\Sections\LifeAtMissionVillaFaqSection;
use App\Content\Sections\LifeAtMissionVillaHeroSection;
use App\Content\Sections\LifeAtMissionVillaPillarsSection;
use App\Content\Sections\LifeAtMissionVillaRhythmSection;
use Tests\TestCase;

class LifeAtMissionVillaPageTest extends TestCase
{
    private function lifePageData(): array
    {
        return require base_path('content/pages/life-at-mission-villa.php');
    }

    public function test_life_at_mission_villa_route_returns_200_and_renders_all_sections_in_order(): void
    {
        $response = $this->get('/life-at-mission-villa');
        $response->assertOk();
        $html = $response->getContent();

        // SEO meta
        $this->assertStringContainsString('<title>Life at Mission Villa | Dining, Activities &amp; Community</title>', $html);
        $this->assertStringContainsString('See daily life at Mission Villa Senior Living in Daly City: shared meals, music, activities, and time outdoors.', $html);

        // Sections presence in order
        $heroPos = strpos($html, 'data-lmv-hero');
        $pillarsPos = strpos($html, 'id="lifestyle-pillars"');
        $rhythmPos = strpos($html, 'id="daily-rhythm"');
        $faqPos = strpos($html, 'id="lifestyle-faq"');
        $visitPos = strpos($html, 'id="visit"');

        $this->assertNotFalse($heroPos, 'Hero section missing');
        $this->assertNotFalse($pillarsPos, 'Pillars section missing');
        $this->assertNotFalse($rhythmPos, 'Daily rhythm section missing');
        $this->assertNotFalse($faqPos, 'FAQ section missing');
        $this->assertNotFalse($visitPos, 'Closing visit CTA section missing');

        // Retired section disabled
        $this->assertFalse(strpos($html, 'id="engagement-activities"'), 'Engagement section must be disabled in Editorial V2');

        $this->assertTrue($heroPos < $pillarsPos, 'Hero must precede Pillars');
        $this->assertTrue($pillarsPos < $rhythmPos, 'Pillars must precede Rhythm');
        $this->assertTrue($rhythmPos < $faqPos, 'Rhythm must precede FAQ');
        $this->assertTrue($faqPos < $visitPos, 'FAQ must precede Visit CTA');

        // Global footer & inquiry dialog present
        $this->assertStringContainsString('<footer class="site-footer"', $html);
        $this->assertStringContainsString('data-inquiry-dialog', $html);
    }

    public function test_all_form_ctas_use_tel_fallback_and_data_inquiry(): void
    {
        $html = $this->get('/life-at-mission-villa')->assertOk()->getContent();

        preg_match_all('/<a[^>]+data-inquiry="([^"]+)"[^>]*>/', $html, $matches);
        $this->assertNotEmpty($matches[0], 'Expected data-inquiry triggers on the Life page');

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
        $html = $this->get('/life-at-mission-villa')->assertOk()->getContent();

        $this->assertStringContainsString('id="visit-form"', $html);
        $this->assertStringContainsString('name="care_interest" value="exploring"', $html);
        $this->assertStringContainsString('Life at Mission Villa Inquiry', $html);
        $this->assertStringContainsString('name="source" value="lo-cta"', $html);
    }

    public function test_pillars_section_highlights_authentic_core_values(): void
    {
        $html = $this->get('/life-at-mission-villa')->assertOk()->getContent();

        $this->assertStringContainsString('The little things matter.', $html);
        $this->assertStringContainsString('Dining Together', $html);
        $this->assertStringContainsString('Activities &amp; Connection', $html);
        $this->assertStringContainsString('Outdoor Moments', $html);
    }

    public function test_rhythm_section_renders_daily_routine_schedule(): void
    {
        $html = $this->get('/life-at-mission-villa')->assertOk()->getContent();

        $this->assertStringContainsString('Breakfast and help with daily routines as needed.', $html);
        $this->assertStringContainsString('Activities, a shared meal, conversation, or some quiet time.', $html);
        $this->assertStringContainsString('Dinner followed by a calm, familiar routine.', $html);
    }

    public function test_engagement_programs_render_authentic_activities(): void
    {
        $html = $this->get('/life-at-mission-villa')->assertOk()->getContent();

        $this->assertFalse(strpos($html, 'id="engagement-activities"'), 'Engagement section must not be rendered when disabled');
    }

    public function test_faq_section_renders_accordion_and_schema_json_ld(): void
    {
        $html = $this->get('/life-at-mission-villa')->assertOk()->getContent();

        $this->assertStringContainsString('Do residents have to join group activities?', $html);
        $this->assertStringContainsString('Can families visit?', $html);
        $this->assertStringContainsString('Can we see an activity calendar?', $html);

        // Schema.org FAQPage
        $this->assertStringContainsString('"@type": "FAQPage"', $html);
        $this->assertStringContainsString('"@type": "Question"', $html);
    }

    public function test_hero_schema_validation(): void
    {
        $schema = new LifeAtMissionVillaHeroSection();
        $page = $this->lifePageData();
        $heroData = collect($page['sections'])->firstWhere('key', 'lmv-hero')['data'];

        $normalized = $schema->normalize($heroData);
        $this->assertSame('Life at Mission Villa', $normalized['eyebrow']);
        $this->assertCount(3, $normalized['strip']);

        $this->expectException(InvalidSectionData::class);
        $badData = $heroData;
        unset($badData['image']);
        $schema->normalize($badData);
    }

    public function test_pillars_schema_validation(): void
    {
        $schema = new LifeAtMissionVillaPillarsSection();
        $page = $this->lifePageData();
        $data = collect($page['sections'])->firstWhere('key', 'lmv-pillars')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(3, $normalized['pillars']);
        $this->assertSame('Dining Together', $normalized['pillars'][0]['title']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        unset($badData['pillars']);
        $schema->normalize($badData);
    }

    public function test_rhythm_schema_validation(): void
    {
        $schema = new LifeAtMissionVillaRhythmSection();
        $page = $this->lifePageData();
        $data = collect($page['sections'])->firstWhere('key', 'lmv-rhythm')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(4, $normalized['moments']);
        $this->assertSame('Morning · 7:30 AM – 10:00 AM', $normalized['moments'][0]['time']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        unset($badData['moments']);
        $schema->normalize($badData);
    }

    public function test_engagement_schema_validation(): void
    {
        $schema = new LifeAtMissionVillaEngagementSection();
        $page = $this->lifePageData();
        $data = collect($page['sections'])->firstWhere('key', 'lmv-engagement')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(4, $normalized['activities']);
        $this->assertSame('Music & Reminiscence Therapy', $normalized['activities'][0]['title']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        unset($badData['activities']);
        $schema->normalize($badData);
    }

    public function test_faq_schema_validation(): void
    {
        $schema = new LifeAtMissionVillaFaqSection();
        $page = $this->lifePageData();
        $data = collect($page['sections'])->firstWhere('key', 'lmv-faq')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(3, $normalized['faqs']);
        $this->assertArrayHasKey('question', $normalized['faqs'][0]);
        $this->assertArrayHasKey('answer', $normalized['faqs'][0]);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        unset($badData['faqs']);
        $schema->normalize($badData);
    }

    public function test_life_at_mission_villa_closing_cta_displays_honest_notice_and_no_false_promises(): void
    {
        $response = $this->get('/life-at-mission-villa');

        $response->assertOk()
            ->assertSee('Submissions save locally while we finalize direct staff notifications.', false)
            ->assertSee('call us directly at (650) 756-1995', false)
            ->assertDontSee('our Daly City care team will be in touch soon', false)
            ->assertDontSee('will reach out promptly', false);
    }
}
