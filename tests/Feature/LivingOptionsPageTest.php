<?php

namespace Tests\Feature;

use App\Content\InvalidSectionData;
use App\Content\Sections\LivingOptionsCareSection;
use App\Content\Sections\LivingOptionsFaqSection;
use App\Content\Sections\LivingOptionsHeroSection;
use App\Content\Sections\LivingOptionsSettingSection;
use App\Content\Sections\LivingOptionsSuitesSection;
use Tests\TestCase;

class LivingOptionsPageTest extends TestCase
{
    private function livingOptionsPageData(): array
    {
        return require base_path('content/pages/living-options.php');
    }

    public function test_living_options_route_returns_200_and_renders_all_sections_in_order(): void
    {
        $response = $this->get('/living-options');
        $response->assertOk();
        $html = $response->getContent();

        // SEO meta
        $this->assertStringContainsString('<title>Living Options: Memory Care &amp; Respite Care in Daly City | Mission Villa</title>', $html);
        $this->assertStringContainsString('Dedicated Legacies™ Memory Care and short-term Respite Care', $html);

        // Header active state for Living Options
        $this->assertStringContainsString('class="site-nav__link site-nav__toggle is-active"', $html);

        // All 6 sections present in order
        $heroPos = strpos($html, 'id="lo-hero"');
        $carePos = strpos($html, 'id="choose-care"');
        $suitesPos = strpos($html, 'id="suites-floor-plans"');
        $settingPos = strpos($html, 'id="homelike-setting"');
        $faqPos = strpos($html, 'id="living-options-faq"');
        $visitPos = strpos($html, 'id="visit"');

        $this->assertNotFalse($heroPos, 'Hero section missing');
        $this->assertNotFalse($carePos, 'Care selector section missing');
        $this->assertNotFalse($suitesPos, 'Suites section missing');
        $this->assertNotFalse($settingPos, 'Homelike setting section missing');
        $this->assertNotFalse($faqPos, 'FAQ section missing');
        $this->assertNotFalse($visitPos, 'Closing visit CTA section missing');

        $this->assertTrue($heroPos < $carePos, 'Hero must precede Care selector');
        $this->assertTrue($carePos < $suitesPos, 'Care selector must precede Suites');
        $this->assertTrue($suitesPos < $settingPos, 'Suites must precede Homelike setting');
        $this->assertTrue($settingPos < $faqPos, 'Homelike setting must precede FAQ');
        $this->assertTrue($faqPos < $visitPos, 'FAQ must precede Visit CTA');

        // Global footer & inquiry dialog present
        $this->assertStringContainsString('<footer class="site-footer"', $html);
        $this->assertStringContainsString('data-inquiry-dialog', $html);
    }

    public function test_all_form_ctas_use_tel_fallback_and_data_inquiry(): void
    {
        $html = $this->get('/living-options')->assertOk()->getContent();

        // Matches all CTAs that trigger the inquiry modal
        preg_match_all('/<a[^>]+data-inquiry="([^"]+)"[^>]*>/', $html, $matches);
        $this->assertNotEmpty($matches[0], 'Expected data-inquiry triggers on the Living Options page');

        foreach ($matches[0] as $tag) {
            $this->assertStringContainsString('href="tel:16507561995"', $tag, "Form CTA must fall back to tel: — got: $tag");
            $this->assertStringNotContainsString('href="#contact"', $tag);
            $this->assertStringNotContainsString('href="#visit"', $tag);
            $this->assertStringNotContainsString('href="#schedule-visit"', $tag);
        }

        // Exploring care preset present
        $this->assertStringContainsString('data-inquiry-care="exploring"', $html);
    }

    public function test_closing_section_contains_inline_inquiry_form_with_exploring_preset(): void
    {
        $html = $this->get('/living-options')->assertOk()->getContent();

        $this->assertStringContainsString('id="visit-form"', $html);
        $this->assertStringContainsString('name="care_interest" value="exploring"', $html);
        $this->assertStringContainsString('Living Options Inquiry', $html);
        $this->assertStringContainsString('name="source" value="lo-cta"', $html);
    }

    public function test_care_options_business_accuracy_two_programs_only(): void
    {
        $html = $this->get('/living-options')->assertOk()->getContent();

        // Must accurately present two programs
        $this->assertStringContainsString('Legacies™ Memory Care', $html);
        $this->assertStringContainsString('Short-Term Respite Care', $html);

        // Must NOT advertise standalone Independent Living or Assisted Living programs
        $this->assertStringNotContainsString('Independent Living Program', $html);
        $this->assertStringNotContainsString('Assisted Living Facility', $html);
        $this->assertStringNotContainsString('Assisted Living Program', $html);
    }

    public function test_interactive_care_selector_markup_and_accessibility(): void
    {
        $html = $this->get('/living-options')->assertOk()->getContent();

        // Tablist container
        $this->assertStringContainsString('role="tablist"', $html);
        $this->assertStringContainsString('aria-label="Care program options"', $html);

        // Memory Care tab and panel
        $this->assertStringContainsString('id="tab-memory-care"', $html);
        $this->assertStringContainsString('role="tab"', $html);
        $this->assertStringContainsString('aria-controls="panel-memory-care"', $html);
        $this->assertStringContainsString('id="panel-memory-care"', $html);
        $this->assertStringContainsString('role="tabpanel"', $html);
        $this->assertStringContainsString('aria-labelledby="tab-memory-care"', $html);

        // Respite Care tab and panel
        $this->assertStringContainsString('id="tab-respite-care"', $html);
        $this->assertStringContainsString('aria-controls="panel-respite-care"', $html);
        $this->assertStringContainsString('id="panel-respite-care"', $html);
        $this->assertStringContainsString('aria-labelledby="tab-respite-care"', $html);

        // Route links to individual full service pages
        $this->assertStringContainsString('href="/memory-care"', $html);
        $this->assertStringContainsString('href="/respite-care"', $html);
    }

    public function test_comparison_table_dimensions_and_shared_foundation(): void
    {
        $html = $this->get('/living-options')->assertOk()->getContent();

        $this->assertStringContainsString('At-a-Glance Comparison', $html);
        $this->assertStringContainsString('Primary Purpose', $html);
        $this->assertStringContainsString('Who It Supports', $html);
        $this->assertStringContainsString('Daily Support', $html);
        $this->assertStringContainsString('Accommodations', $html);
        $this->assertStringContainsString('Planning &amp; Pricing', $html);
        $this->assertStringContainsString('CA RCFE License #415601046', $html);
    }

    public function test_suites_section_has_cutout_corner_badges_and_accuracy(): void
    {
        $html = $this->get('/living-options')->assertOk()->getContent();

        // 3 formats present
        $this->assertStringContainsString('Private Suite with Private Bath', $html);
        $this->assertStringContainsString('Companion Unit (Shared Suite)', $html);
        $this->assertStringContainsString('Jack &amp; Jill Suite Format', $html);

        // Inverted cutout corner tabs
        $this->assertStringContainsString('class="lo-suites__cutout"', $html);
        $this->assertStringContainsString('FORMAT 01 · PRIVATE', $html);
        $this->assertStringContainsString('FORMAT 02 · COMPANION', $html);
        $this->assertStringContainsString('FORMAT 03 · JACK &amp; JILL', $html);

        // Jack & Jill accuracy: Memory Care only
        $this->assertStringContainsString('Memory Care Only', $html);

        // Floor plan details CTA uses fallback inquiry modal safely
        $this->assertStringContainsString('data-inquiry="request_availability"', $html);
        $this->assertStringContainsString('View Floor-Plan Details', $html);
    }

    public function test_homelike_setting_four_feature_cards(): void
    {
        $html = $this->get('/living-options')->assertOk()->getContent();

        $this->assertStringContainsString('Chef-Prepared Dining', $html);
        $this->assertStringContainsString('Meaningful Engagement', $html);
        $this->assertStringContainsString('Enclosed Courtyard &amp; Patio', $html);
        $this->assertStringContainsString('24-Hour Attentive Support', $html);
    }

    public function test_faq_section_accordion_and_schema_markup(): void
    {
        $html = $this->get('/living-options')->assertOk()->getContent();

        // 5 specific verified questions
        $this->assertStringContainsString('Which care options does Mission Villa offer?', $html);
        $this->assertStringContainsString('What is the difference between Memory Care and Respite Care?', $html);
        $this->assertStringContainsString('What suite configurations are available?', $html);
        $this->assertStringContainsString('How do families choose the appropriate care option?', $html);
        $this->assertStringContainsString('Can families tour Mission Villa and inquire about accommodations?', $html);

        // Accordion triggers
        $this->assertStringContainsString('data-faq-trigger', $html);
        $this->assertStringContainsString('data-faq-body', $html);

        // Schema.org FAQPage
        $this->assertStringContainsString('"@type": "FAQPage"', $html);
        $this->assertStringContainsString('"@type": "Question"', $html);
    }

    public function test_image_provenance_and_rights_attributes(): void
    {
        $html = $this->get('/living-options')->assertOk()->getContent();

        // Check for lo- images
        preg_match_all('/<img[^>]+class="lo-[^"]+"[^>]*>/', $html, $matches);
        $this->assertNotEmpty($matches[0], 'Expected lo- images on the page');

        foreach ($matches[0] as $tag) {
            $this->assertMatchesRegularExpression('/data-provenance="(facility|illustrative)"/', $tag);
            $this->assertMatchesRegularExpression('/data-rights="(cleared|unconfirmed)"/', $tag);
            $this->assertMatchesRegularExpression('/alt="[^"]+"/', $tag);
        }
    }

    public function test_living_options_hero_schema_validation(): void
    {
        $schema = new LivingOptionsHeroSection();
        $page = $this->livingOptionsPageData();
        $heroData = collect($page['sections'])->firstWhere('key', 'lo-hero')['data'];

        $normalized = $schema->normalize($heroData);
        $this->assertSame('Living Options at Mission Villa', $normalized['eyebrow']);
        $this->assertCount(3, $normalized['strip']);
        $this->assertSame('exploring', $normalized['actions'][0]['care']);

        $this->expectException(InvalidSectionData::class);
        $badData = $heroData;
        unset($badData['image']);
        $schema->normalize($badData);
    }

    public function test_living_options_care_schema_validation(): void
    {
        $schema = new LivingOptionsCareSection();
        $page = $this->livingOptionsPageData();
        $data = collect($page['sections'])->firstWhere('key', 'lo-care')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(2, $normalized['options']);
        $this->assertSame('Legacies™ Memory Care', $normalized['options'][0]['title']);
        $this->assertSame('Short-Term Respite Care', $normalized['options'][1]['title']);
        $this->assertCount(5, $normalized['comparison']['rows']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        array_pop($badData['options']); // requires exactly 2 options
        $schema->normalize($badData);
    }

    public function test_living_options_suites_schema_validation(): void
    {
        $schema = new LivingOptionsSuitesSection();
        $page = $this->livingOptionsPageData();
        $data = collect($page['sections'])->firstWhere('key', 'lo-suites')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(3, $normalized['suites']);
        $this->assertSame('FORMAT 01 · PRIVATE', $normalized['suites'][0]['cutout_label']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        unset($badData['suites']);
        $schema->normalize($badData);
    }

    public function test_living_options_setting_schema_validation(): void
    {
        $schema = new LivingOptionsSettingSection();
        $page = $this->livingOptionsPageData();
        $data = collect($page['sections'])->firstWhere('key', 'lo-setting')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(4, $normalized['features']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        array_pop($badData['features']); // requires exactly 4 features
        $schema->normalize($badData);
    }

    public function test_living_options_faq_schema_validation(): void
    {
        $schema = new LivingOptionsFaqSection();
        $page = $this->livingOptionsPageData();
        $data = collect($page['sections'])->firstWhere('key', 'lo-faq')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(5, $normalized['faqs']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        unset($badData['help_card']);
        $schema->normalize($badData);
    }
}
