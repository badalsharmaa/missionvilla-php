<?php

namespace Tests\Feature;

use App\Content\InvalidSectionData;
use App\Content\Sections\SuitesFloorPlansDiagramSection;
use App\Content\Sections\SuitesFloorPlansFaqSection;
use App\Content\Sections\SuitesFloorPlansFeaturesSection;
use App\Content\Sections\SuitesFloorPlansFormatsSection;
use App\Content\Sections\SuitesFloorPlansHeroSection;
use Tests\TestCase;

class SuitesFloorPlansPageTest extends TestCase
{
    private function suitesPageData(): array
    {
        return require base_path('content/pages/suites-and-floor-plans.php');
    }

    public function test_suites_and_floor_plans_route_returns_200_and_renders_all_sections_in_order(): void
    {
        $response = $this->get('/suites-and-floor-plans');
        $response->assertOk();
        $html = $response->getContent();

        // SEO meta
        $this->assertStringContainsString('<title>Suites &amp; Floor Plans: Memory Care Living in Daly City | Mission Villa</title>', $html);
        $this->assertStringContainsString('Explore comfortable private and companion suites at Mission Villa', $html);

        // Sections presence in order
        $heroPos = strpos($html, 'data-sfp-hero');
        $formatsPos = strpos($html, 'id="suite-formats"');
        $diagramPos = strpos($html, 'id="floor-plans"');
        $featuresPos = strpos($html, 'id="suite-features"');
        $faqPos = strpos($html, 'id="suite-faq"');
        $visitPos = strpos($html, 'id="visit"');

        $this->assertNotFalse($heroPos, 'Hero section missing');
        $this->assertNotFalse($formatsPos, 'Suite formats section missing');
        $this->assertNotFalse($diagramPos, 'Floor plan diagram section missing');
        $this->assertNotFalse($featuresPos, 'Features section missing');
        $this->assertNotFalse($faqPos, 'FAQ section missing');
        $this->assertNotFalse($visitPos, 'Closing visit CTA section missing');

        $this->assertTrue($heroPos < $formatsPos, 'Hero must precede Formats');
        $this->assertTrue($formatsPos < $diagramPos, 'Formats must precede Diagram');
        $this->assertTrue($diagramPos < $featuresPos, 'Diagram must precede Features');
        $this->assertTrue($featuresPos < $faqPos, 'Features must precede FAQ');
        $this->assertTrue($faqPos < $visitPos, 'FAQ must precede Visit CTA');

        // Global footer & inquiry dialog present
        $this->assertStringContainsString('<footer class="site-footer"', $html);
        $this->assertStringContainsString('data-inquiry-dialog', $html);
    }

    public function test_all_form_ctas_use_tel_fallback_and_data_inquiry(): void
    {
        $html = $this->get('/suites-and-floor-plans')->assertOk()->getContent();

        preg_match_all('/<a[^>]+data-inquiry="([^"]+)"[^>]*>/', $html, $matches);
        $this->assertNotEmpty($matches[0], 'Expected data-inquiry triggers on the Suites page');

        foreach ($matches[0] as $tag) {
            $this->assertStringContainsString('href="tel:16507561995"', $tag, "Form CTA must fall back to tel: — got: $tag");
            $this->assertStringNotContainsString('href="#contact"', $tag);
            $this->assertStringNotContainsString('href="#visit"', $tag);
            $this->assertStringNotContainsString('href="#schedule-visit"', $tag);
        }

        // Form buttons must use data-inquiry
        $this->assertStringContainsString('data-inquiry="schedule_visit"', $html);
        $this->assertStringContainsString('data-inquiry="request_pricing"', $html);
        $this->assertStringContainsString('data-inquiry="request_availability"', $html);
    }

    public function test_closing_section_contains_inline_inquiry_form(): void
    {
        $html = $this->get('/suites-and-floor-plans')->assertOk()->getContent();

        $this->assertStringContainsString('id="visit-form"', $html);
        $this->assertStringContainsString('name="care_interest" value="exploring"', $html);
        $this->assertStringContainsString('Suite &amp; Floor Plan Inquiry', $html);
        $this->assertStringContainsString('name="source" value="lo-cta"', $html);
    }

    public function test_authentic_companion_floor_plan_is_presented_with_honesty_disclosure(): void
    {
        $html = $this->get('/suites-and-floor-plans')->assertOk()->getContent();

        // Authentic companion diagram
        $this->assertStringContainsString('companion-suite-floorplan-1000.webp', $html);
        $this->assertStringContainsString('AUTHENTIC MISSION VILLA FLOOR PLAN', $html);

        // Honesty disclosure
        $this->assertStringContainsString('OUR COMMITMENT TO TRANSPARENCY', $html);
        $this->assertStringContainsString('Mission Villa does not publish artificial CAD drawings', $html);
    }

    public function test_faq_section_renders_accordion_and_schema_json_ld(): void
    {
        $html = $this->get('/suites-and-floor-plans')->assertOk()->getContent();

        $this->assertStringContainsString('Are suites furnished, or can we bring our loved one’s own furniture?', $html);
        $this->assertStringContainsString('Do all suites include a private bathroom?', $html);
        $this->assertStringContainsString('How does Mission Villa match residents in companion suites?', $html);

        // Schema.org FAQPage
        $this->assertStringContainsString('"@type": "FAQPage"', $html);
        $this->assertStringContainsString('"@type": "Question"', $html);
    }

    public function test_hero_schema_validation(): void
    {
        $schema = new SuitesFloorPlansHeroSection();
        $page = $this->suitesPageData();
        $heroData = collect($page['sections'])->firstWhere('key', 'sfp-hero')['data'];

        $normalized = $schema->normalize($heroData);
        $this->assertSame('Accommodations & Living Spaces', $normalized['eyebrow']);
        $this->assertCount(3, $normalized['strip']);

        $this->expectException(InvalidSectionData::class);
        $badData = $heroData;
        unset($badData['image']);
        $schema->normalize($badData);
    }

    public function test_formats_schema_validation(): void
    {
        $schema = new SuitesFloorPlansFormatsSection();
        $page = $this->suitesPageData();
        $data = collect($page['sections'])->firstWhere('key', 'sfp-formats')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(3, $normalized['suites']);
        $this->assertSame('Private Suite', $normalized['suites'][0]['cutout_label']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        unset($badData['suites']);
        $schema->normalize($badData);
    }

    public function test_diagram_schema_validation(): void
    {
        $schema = new SuitesFloorPlansDiagramSection();
        $page = $this->suitesPageData();
        $data = collect($page['sections'])->firstWhere('key', 'sfp-diagram')['data'];

        $normalized = $schema->normalize($data);
        $this->assertSame('Companion Unit Layout', $normalized['diagram']['title']);
        $this->assertCount(4, $normalized['highlights']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        unset($badData['diagram']);
        $schema->normalize($badData);
    }

    public function test_features_schema_validation(): void
    {
        $schema = new SuitesFloorPlansFeaturesSection();
        $page = $this->suitesPageData();
        $data = collect($page['sections'])->firstWhere('key', 'sfp-features')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(4, $normalized['features']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        array_pop($badData['features']); // requires size 4
        $schema->normalize($badData);
    }

    public function test_faq_schema_validation(): void
    {
        $schema = new SuitesFloorPlansFaqSection();
        $page = $this->suitesPageData();
        $data = collect($page['sections'])->firstWhere('key', 'sfp-faq')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(6, $normalized['faqs']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        unset($badData['help_card']);
        $schema->normalize($badData);
    }
}
