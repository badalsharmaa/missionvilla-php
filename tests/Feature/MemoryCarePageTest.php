<?php

namespace Tests\Feature;

use App\Content\InvalidSectionData;
use App\Content\Sections\MemoryCareCareComfortSection;
use App\Content\Sections\MemoryCareDailyLifeSection;
use App\Content\Sections\MemoryCareHeroSection;
use App\Content\Sections\MemoryCareLegaciesSection;
use Tests\TestCase;

class MemoryCarePageTest extends TestCase
{
    private function memoryCarePageData(): array
    {
        return require base_path('content/pages/memory-care.php');
    }

    public function test_memory_care_route_returns_200_and_renders_all_sections_in_order(): void
    {
        $response = $this->get('/memory-care');
        $response->assertOk();
        $html = $response->getContent();

        // SEO meta
        $this->assertStringContainsString('<title>Legacies™ Memory Care in Daly City | Mission Villa Senior Living</title>', $html);
        $this->assertStringContainsString('Dedicated Memory Care in Daly City featuring the Legacies™ program', $html);

        // Header active state for Memory Care
        $this->assertStringContainsString('class="site-nav__link is-active"  aria-current="page" >Memory Care</a>', $html);

        // All 6 sections present in order
        $heroPos = strpos($html, 'id="mc-hero"');
        $legaciesPos = strpos($html, 'id="legacies-difference"');
        $dailyPos = strpos($html, 'id="daily-life"');
        $carePos = strpos($html, 'id="care-comfort"');
        $faqPos = strpos($html, 'id="faq"');
        $visitPos = strpos($html, 'id="visit"');

        $this->assertNotFalse($heroPos, 'Hero section missing');
        $this->assertNotFalse($legaciesPos, 'Legacies difference section missing');
        $this->assertNotFalse($dailyPos, 'Daily life section missing');
        $this->assertNotFalse($carePos, 'Care, comfort & home section missing');
        $this->assertNotFalse($faqPos, 'FAQ section missing');
        $this->assertNotFalse($visitPos, 'Visit CTA section missing');

        $this->assertTrue($heroPos < $legaciesPos, 'Hero must precede Legacies');
        $this->assertTrue($legaciesPos < $dailyPos, 'Legacies must precede Daily Life');
        $this->assertTrue($dailyPos < $carePos, 'Daily Life must precede Care Comfort');
        $this->assertTrue($carePos < $faqPos, 'Care Comfort must precede FAQ');
        $this->assertTrue($faqPos < $visitPos, 'FAQ must precede Visit CTA');

        // Global footer & inquiry dialog present
        $this->assertStringContainsString('<footer class="site-footer"', $html);
        $this->assertStringContainsString('data-inquiry-dialog', $html);
    }

    public function test_all_form_ctas_use_tel_fallback_and_data_inquiry_with_memory_care(): void
    {
        $html = $this->get('/memory-care')->assertOk()->getContent();

        // Matches all CTAs that trigger the inquiry modal
        preg_match_all('/<a[^>]+data-inquiry="([^"]+)"[^>]*>/', $html, $matches);
        $this->assertNotEmpty($matches[0], 'Expected data-inquiry triggers on the Memory Care page');

        foreach ($matches[0] as $tag) {
            $this->assertStringContainsString('href="tel:16507561995"', $tag, "Form CTA must fall back to tel: — got: $tag");
            $this->assertStringNotContainsString('href="#contact"', $tag);
            $this->assertStringNotContainsString('href="#visit"', $tag);
            $this->assertStringNotContainsString('href="#schedule-visit"', $tag);
        }

        // Primary conversion actions preselect memory_care
        $this->assertStringContainsString('data-inquiry-care="memory_care"', $html);
    }

    public function test_images_declare_provenance_and_rights(): void
    {
        $html = $this->get('/memory-care')->assertOk()->getContent();

        // All section content images must declare provenance & rights
        preg_match_all('/<img[^>]+class="mc-[^"]+"[^>]*>/', $html, $matches);
        $this->assertNotEmpty($matches[0], 'Expected mc- images on the page');

        foreach ($matches[0] as $tag) {
            $this->assertMatchesRegularExpression('/data-provenance="(facility|illustrative)"/', $tag);
            $this->assertMatchesRegularExpression('/data-rights="(cleared|unconfirmed)"/', $tag);
            $this->assertMatchesRegularExpression('/alt="[^"]+"/', $tag);
        }
    }

    public function test_memory_care_hero_schema_validation(): void
    {
        $schema = new MemoryCareHeroSection();
        $page = $this->memoryCarePageData();
        $heroData = collect($page['sections'])->firstWhere('key', 'mc-hero')['data'];

        $normalized = $schema->normalize($heroData);
        $this->assertSame('Memory Care at Mission Villa', $normalized['eyebrow']);
        $this->assertCount(3, $normalized['badges']);
        $this->assertCount(3, $normalized['actions']);

        // Test invalid data rejected
        $this->expectException(InvalidSectionData::class);
        $schema->normalize(['eyebrow' => ''] + $heroData);
    }

    public function test_legacies_difference_schema_requires_exactly_four_chapters(): void
    {
        $schema = new MemoryCareLegaciesSection();
        $page = $this->memoryCarePageData();
        $legaciesData = collect($page['sections'])->firstWhere('key', 'mc-legacies')['data'];

        $normalized = $schema->normalize($legaciesData);
        $this->assertCount(4, $normalized['touchpoints']);
        $this->assertSame('Personal Histories', $normalized['touchpoints'][0]['tab_label']);
        $this->assertSame('Familiar Routines', $normalized['touchpoints'][1]['tab_label']);
        $this->assertSame('Meaningful Connection', $normalized['touchpoints'][2]['tab_label']);
        $this->assertSame('Family Partnership', $normalized['touchpoints'][3]['tab_label']);

        // Reject 3 chapters
        $badData = $legaciesData;
        array_pop($badData['touchpoints']);
        $this->expectException(InvalidSectionData::class);
        $schema->normalize($badData);
    }

    public function test_daily_life_schema_requires_exactly_three_scenes(): void
    {
        $schema = new MemoryCareDailyLifeSection();
        $page = $this->memoryCarePageData();
        $dailyData = collect($page['sections'])->firstWhere('key', 'mc-daily')['data'];

        $normalized = $schema->normalize($dailyData);
        $this->assertCount(3, $normalized['scenes']);
        $this->assertSame('morning', $normalized['scenes'][0]['id']);
        $this->assertSame('midday', $normalized['scenes'][1]['id']);
        $this->assertSame('evening', $normalized['scenes'][2]['id']);

        // Reject 2 scenes
        $badData = $dailyData;
        array_pop($badData['scenes']);
        $this->expectException(InvalidSectionData::class);
        $schema->normalize($badData);
    }

    public function test_care_comfort_schema_validation(): void
    {
        $schema = new MemoryCareCareComfortSection();
        $page = $this->memoryCarePageData();
        $careData = collect($page['sections'])->firstWhere('key', 'mc-care')['data'];

        $normalized = $schema->normalize($careData);
        $this->assertCount(5, $normalized['checklist']);
        $this->assertNotNull($normalized['reassurance_box']);
        $this->assertCount(2, $normalized['actions']);

        // Reject missing checklist
        $this->expectException(InvalidSectionData::class);
        $schema->normalize(['checklist' => []] + $careData);
    }

    public function test_faq_accordion_renders_five_featured_questions_on_memory_care_page(): void
    {
        $html = $this->get('/memory-care')->assertOk()->getContent();

        $this->assertStringContainsString('What makes the Legacies™ Memory Care approach meaningful for residents?', $html);
        $this->assertStringContainsString('What kind of everyday assistance and 24-hour safety support do residents receive?', $html);
        $this->assertStringContainsString('What types of activities, dining, and daily routines are offered?', $html);
        $this->assertStringContainsString('What suite options are available in Memory Care?', $html);
        $this->assertStringContainsString('How can family members visit and stay involved after move-in?', $html);

        // 5 questions rendered
        $count = substr_count($html, 'class="faq-item"');
        $this->assertSame(5, $count);
    }
}
