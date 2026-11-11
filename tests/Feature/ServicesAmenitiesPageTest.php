<?php

namespace Tests\Feature;

use App\Content\InvalidSectionData;
use App\Content\Sections\ServicesAmenitiesCareBridgeSection;
use App\Content\Sections\ServicesAmenitiesDiptychSection;
use App\Content\Sections\ServicesAmenitiesDisclosuresSection;
use App\Content\Sections\ServicesAmenitiesExplorerSection;
use App\Content\Sections\ServicesAmenitiesHeroSection;
use Tests\TestCase;

class ServicesAmenitiesPageTest extends TestCase
{
    private function servicesPageData(): array
    {
        return require base_path('content/pages/services-and-amenities.php');
    }

    public function test_services_and_amenities_route_returns_200_and_renders_all_sections_in_order(): void
    {
        $response = $this->get('/services-and-amenities');
        $response->assertOk();
        $html = $response->getContent();

        // SEO meta
        $this->assertStringContainsString('<title>Services &amp; Amenities: 24/7 Support, Dining &amp; Care in Daly City | Mission Villa</title>', $html);
        $this->assertStringContainsString('Explore services and amenities at Mission Villa Senior Living in Daly City', $html);

        // Sections presence in order
        $heroPos = strpos($html, 'data-sa-hero');
        $explorerPos = strpos($html, 'id="services-explorer"');
        $diptychPos = strpos($html, 'id="photographic-feature"');
        $disclosuresPos = strpos($html, 'id="ask-us-about"');
        $bridgePos = strpos($html, 'id="care-programs-bridge"');
        $visitPos = strpos($html, 'id="visit"');

        $this->assertNotFalse($heroPos, 'Hero section missing');
        $this->assertNotFalse($explorerPos, 'Explorer section missing');
        $this->assertNotFalse($diptychPos, 'Diptych section missing');
        $this->assertNotFalse($disclosuresPos, 'Disclosures section missing');
        $this->assertNotFalse($bridgePos, 'Care bridge section missing');
        $this->assertNotFalse($visitPos, 'Closing visit CTA section missing');

        $this->assertTrue($heroPos < $explorerPos, 'Hero must precede Explorer');
        $this->assertTrue($explorerPos < $diptychPos, 'Explorer must precede Diptych');
        $this->assertTrue($diptychPos < $disclosuresPos, 'Diptych must precede Disclosures');
        $this->assertTrue($disclosuresPos < $bridgePos, 'Disclosures must precede Care Bridge');
        $this->assertTrue($bridgePos < $visitPos, 'Care Bridge must precede Visit CTA');

        // Global footer & inquiry dialog present
        $this->assertStringContainsString('<footer class="site-footer"', $html);
        $this->assertStringContainsString('data-inquiry-dialog', $html);
    }

    public function test_all_form_ctas_use_tel_fallback_and_data_inquiry(): void
    {
        $html = $this->get('/services-and-amenities')->assertOk()->getContent();

        preg_match_all('/<a[^>]+data-inquiry="([^"]+)"[^>]*>/', $html, $matches);
        $this->assertNotEmpty($matches[0], 'Expected data-inquiry triggers on Services & Amenities page');

        foreach ($matches[0] as $tag) {
            $this->assertStringContainsString('href="tel:16507561995"', $tag, "Form CTA must fall back to tel: — got: $tag");
            $this->assertStringNotContainsString('href="#contact"', $tag);
            $this->assertStringNotContainsString('href="#visit"', $tag);
            $this->assertStringNotContainsString('href="#schedule-visit"', $tag);
        }

        // Form buttons must use data-inquiry
        $this->assertStringContainsString('data-inquiry="schedule_visit"', $html);
        $this->assertStringContainsString('data-inquiry="general_inquiry"', $html);
    }

    public function test_closing_section_contains_inline_inquiry_form(): void
    {
        $html = $this->get('/services-and-amenities')->assertOk()->getContent();

        $this->assertStringContainsString('id="visit-form"', $html);
        $this->assertStringContainsString('name="care_interest" value="exploring"', $html);
        $this->assertStringContainsString('Services &amp; Amenities Inquiry', $html);
        $this->assertStringContainsString('name="source" value="lo-cta"', $html);
    }

    public function test_explorer_section_renders_all_five_categories_and_items(): void
    {
        $html = $this->get('/services-and-amenities')->assertOk()->getContent();

        // 5 category tabs
        $this->assertStringContainsString('data-sa-tab="support"', $html);
        $this->assertStringContainsString('data-sa-tab="dining"', $html);
        $this->assertStringContainsString('data-sa-tab="lifestyle"', $html);
        $this->assertStringContainsString('data-sa-tab="spaces"', $html);
        $this->assertStringContainsString('data-sa-tab="convenience"', $html);

        // Core items
        $this->assertStringContainsString('24-Hour Staff Availability', $html);
        $this->assertStringContainsString('Restaurant-Style Full-Table Service', $html);
        $this->assertStringContainsString('Dedicated Activity Director Programming', $html);
        $this->assertStringContainsString('Secure Central Courtyard &amp; Patio', $html);
        $this->assertStringContainsString('Personal Laundry &amp; Linen Care', $html);
    }

    public function test_diptych_section_presents_facility_photography_and_hospitality_protocols(): void
    {
        $html = $this->get('/services-and-amenities')->assertOk()->getContent();

        $this->assertStringContainsString('community-lounge-facility-899.webp', $html);
        $this->assertStringContainsString('Community Gathering Lounge', $html);
        $this->assertStringContainsString('Unrushed Dining Hospitality', $html);
        $this->assertStringContainsString('Protected Courtyard Air', $html);
        $this->assertStringContainsString('24-Hour Attentive Vigilance', $html);
    }

    public function test_disclosures_section_details_transparent_guidance_topics(): void
    {
        $html = $this->get('/services-and-amenities')->assertOk()->getContent();

        $this->assertStringContainsString('Care Eligibility &amp; RCFE Scope', $html);
        $this->assertStringContainsString('Base Inclusions vs. Specialized Services', $html);
        $this->assertStringContainsString('Routine Assessments &amp; Care Conferences', $html);
        $this->assertStringContainsString('Respite Care Inclusions Consistency', $html);
    }

    public function test_care_bridge_links_to_memory_care_and_respite_care(): void
    {
        $html = $this->get('/services-and-amenities')->assertOk()->getContent();

        $this->assertStringContainsString('href="/memory-care"', $html);
        $this->assertStringContainsString('href="/respite-care"', $html);
        $this->assertStringContainsString('Memory Care &amp; Legacies™ Program', $html);
        $this->assertStringContainsString('Respite Care &amp; Caregiver Relief', $html);
    }

    public function test_hero_schema_validation(): void
    {
        $schema = new ServicesAmenitiesHeroSection();
        $page = $this->servicesPageData();
        $heroData = collect($page['sections'])->firstWhere('key', 'sa-hero')['data'];

        $normalized = $schema->normalize($heroData);
        $this->assertSame('Services & Amenities Directory', $normalized['eyebrow']);
        $this->assertCount(5, $normalized['categories_dock']);
        $this->assertCount(3, $normalized['actions']);

        $this->expectException(InvalidSectionData::class);
        $badData = $heroData;
        unset($badData['categories_dock']);
        $schema->normalize($badData);
    }

    public function test_explorer_schema_validation(): void
    {
        $schema = new ServicesAmenitiesExplorerSection();
        $page = $this->servicesPageData();
        $data = collect($page['sections'])->firstWhere('key', 'sa-explorer')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(5, $normalized['categories']);
        $this->assertSame('Support', $normalized['categories'][0]['label']);
        $this->assertCount(4, $normalized['categories'][0]['items']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        unset($badData['categories']);
        $schema->normalize($badData);
    }

    public function test_diptych_schema_validation(): void
    {
        $schema = new ServicesAmenitiesDiptychSection();
        $page = $this->servicesPageData();
        $data = collect($page['sections'])->firstWhere('key', 'sa-diptych')['data'];

        $normalized = $schema->normalize($data);
        $this->assertSame('Community Gathering Lounge', $normalized['feature']['cutout_label']);
        $this->assertCount(3, $normalized['field_notes']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        unset($badData['feature']);
        $schema->normalize($badData);
    }

    public function test_disclosures_schema_validation(): void
    {
        $schema = new ServicesAmenitiesDisclosuresSection();
        $page = $this->servicesPageData();
        $data = collect($page['sections'])->firstWhere('key', 'sa-disclosures')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(4, $normalized['disclosures']);
        $this->assertSame('Care Eligibility & RCFE Scope', $normalized['disclosures'][0]['title']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        unset($badData['disclosures']);
        $schema->normalize($badData);
    }

    public function test_care_bridge_schema_validation(): void
    {
        $schema = new ServicesAmenitiesCareBridgeSection();
        $page = $this->servicesPageData();
        $data = collect($page['sections'])->firstWhere('key', 'sa-care-bridge')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(2, $normalized['programs']);
        $this->assertSame('/memory-care', $normalized['programs'][0]['link_href']);
        $this->assertSame('/respite-care', $normalized['programs'][1]['link_href']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        unset($badData['programs']);
        $schema->normalize($badData);
    }
}
