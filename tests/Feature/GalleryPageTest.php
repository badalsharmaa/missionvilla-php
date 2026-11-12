<?php

namespace Tests\Feature;

use App\Content\InvalidSectionData;
use App\Content\Sections\GalleryHeroSection;
use App\Content\Sections\GalleryMasonrySection;
use App\Content\Sections\GalleryPathwaysSection;
use App\Content\Sections\GalleryVirtualTourSection;
use Tests\TestCase;

class GalleryPageTest extends TestCase
{
    private function galleryPageData(): array
    {
        return require base_path('content/pages/gallery.php');
    }

    public function test_gallery_route_returns_200_and_renders_all_sections_in_order(): void
    {
        $response = $this->get('/gallery');
        $response->assertOk();
        $html = $response->getContent();

        // SEO meta
        $this->assertStringContainsString('<title>Photo Gallery &amp; Virtual Tour: Suites, Dining &amp; Courtyard | Mission Villa</title>', $html);
        $this->assertStringContainsString('Explore the photo gallery and virtual walkthrough of Mission Villa in Daly City', $html);

        // Sections presence in order
        $heroPos = strpos($html, 'data-gh-hero');
        $masonryPos = strpos($html, 'id="editorial-masonry-gallery"');
        $tourPos = strpos($html, 'id="virtual-tour"');
        $bridgePos = strpos($html, 'id="gallery-visit-bridge"');
        $visitPos = strpos($html, 'id="visit"');

        $this->assertNotFalse($heroPos, 'Hero section missing');
        $this->assertNotFalse($masonryPos, 'Masonry section missing');
        $this->assertNotFalse($tourPos, 'Virtual tour section missing');
        $this->assertNotFalse($bridgePos, 'Pathways bridge section missing');
        $this->assertNotFalse($visitPos, 'Closing visit CTA section missing');

        $this->assertTrue($heroPos < $masonryPos, 'Hero must precede Masonry');
        $this->assertTrue($masonryPos < $tourPos, 'Masonry must precede Virtual Tour');
        $this->assertTrue($tourPos < $bridgePos, 'Virtual Tour must precede Pathways Bridge');
        $this->assertTrue($bridgePos < $visitPos, 'Pathways Bridge must precede Visit CTA');

        // Global footer, lightbox & inquiry dialogs present
        $this->assertStringContainsString('<footer class="site-footer"', $html);
        $this->assertStringContainsString('data-gm-dialog', $html);
        $this->assertStringContainsString('data-inquiry-dialog', $html);
    }

    public function test_all_form_ctas_use_tel_fallback_and_data_inquiry(): void
    {
        $html = $this->get('/gallery')->assertOk()->getContent();

        preg_match_all('/<a[^>]+data-inquiry="([^"]+)"[^>]*>/', $html, $matches);
        $this->assertNotEmpty($matches[0], 'Expected data-inquiry triggers on Gallery page');

        foreach ($matches[0] as $tag) {
            $this->assertStringContainsString('href="tel:16507561995"', $tag, "Form CTA must fall back to tel: — got: $tag");
            $this->assertStringNotContainsString('href="#contact"', $tag);
            $this->assertStringNotContainsString('href="#visit"', $tag);
            $this->assertStringNotContainsString('href="#schedule-visit"', $tag);
        }

        // Form buttons must use data-inquiry
        $this->assertStringContainsString('data-inquiry="schedule_visit"', $html);
        $this->assertStringContainsString('data-inquiry="request_pricing"', $html);
    }

    public function test_closing_section_contains_inline_inquiry_form(): void
    {
        $html = $this->get('/gallery')->assertOk()->getContent();

        $this->assertStringContainsString('id="visit-form"', $html);
        $this->assertStringContainsString('name="care_interest" value="exploring"', $html);
        $this->assertStringContainsString('Gallery &amp; Virtual Tour Inquiry', $html);
        $this->assertStringContainsString('Submissions save locally while we finalize direct staff notifications', $html);
        $this->assertStringNotContainsString('Our community director will reach out promptly', $html);
        $this->assertStringContainsString('name="source" value="lo-cta"', $html);
    }

    public function test_hero_section_renders_triptych_previews_and_categories(): void
    {
        $html = $this->get('/gallery')->assertOk()->getContent();

        $this->assertStringContainsString('Suites &amp; Bedrooms', $html);
        $this->assertStringContainsString('Culinary Warmth', $html);
        $this->assertStringContainsString('Outdoor Sanctuary', $html);
        $this->assertStringContainsString('Rooms &amp; Suites', $html);
        $this->assertStringContainsString('Common Lounges', $html);
    }

    public function test_masonry_section_renders_ten_plates_with_cutouts_and_lightbox(): void
    {
        $html = $this->get('/gallery')->assertOk()->getContent();

        // 10 plates codes
        $this->assertStringContainsString('PLATE 01', $html);
        $this->assertStringContainsString('PLATE 02', $html);
        $this->assertStringContainsString('PLATE 03', $html);
        $this->assertStringContainsString('PLATE 04', $html);
        $this->assertStringContainsString('PLATE 05', $html);
        $this->assertStringContainsString('PLATE 06', $html);
        $this->assertStringContainsString('PLATE 07', $html);
        $this->assertStringContainsString('PLATE 08', $html);
        $this->assertStringContainsString('PLATE 09', $html);
        $this->assertStringContainsString('PLATE 10', $html);

        // Core titles
        $this->assertStringContainsString('Sunlit Private Suite Sanctuary', $html);
        $this->assertStringContainsString('Restaurant-Style Community Dining', $html);
        $this->assertStringContainsString('Homelike Fireside &amp; Conversation Lounge', $html);
        $this->assertStringContainsString('Enclosed Garden Courtyard &amp; Patio', $html);
        $this->assertStringContainsString('Companion Unit Layout Arrangements', $html);

        // Lightbox trigger attributes and cycling controls
        $this->assertStringContainsString('data-gm-trigger', $html);
        $this->assertStringContainsString('data-gm-dialog', $html);
        $this->assertStringContainsString('data-gm-prev', $html);
        $this->assertStringContainsString('data-gm-next', $html);
        $this->assertStringContainsString('data-gm-dialog-counter', $html);
        $this->assertStringContainsString('gm-plate__badge-cutout', $html);
        $this->assertStringContainsString('gm-plate__pill-badge', $html);
        $this->assertStringContainsString('gm-plate__prov-pill', $html);
    }

    public function test_virtual_tour_renders_four_guided_spatial_stops(): void
    {
        $html = $this->get('/gallery')->assertOk()->getContent();

        $this->assertStringContainsString('STOP 01', $html);
        $this->assertStringContainsString('Main Reception &amp; Welcoming Foyer', $html);
        $this->assertStringContainsString('STOP 02', $html);
        $this->assertStringContainsString('Community Dining Room &amp; Private Dining', $html);
        $this->assertStringContainsString('STOP 03', $html);
        $this->assertStringContainsString('Enclosed Courtyard &amp; Patio Sanctuary', $html);
        $this->assertStringContainsString('STOP 04', $html);
        $this->assertStringContainsString('Private &amp; Companion Suites with Attached Baths', $html);
        $this->assertStringContainsString('Prefer a Live Video Walkthrough?', $html);
        $this->assertStringContainsString('gvt-stop__badge-cutout', $html);
        $this->assertStringContainsString('gvt-stop__pill-badge', $html);
        $this->assertStringContainsString('gvt-stop__prov-pill', $html);
    }

    public function test_pathways_bridge_links_to_suites_services_and_memory_care(): void
    {
        $html = $this->get('/gallery')->assertOk()->getContent();

        $this->assertStringContainsString('href="/suites-and-floor-plans"', $html);
        $this->assertStringContainsString('href="/services-and-amenities"', $html);
        $this->assertStringContainsString('href="/memory-care"', $html);
    }

    public function test_hero_schema_validation(): void
    {
        $schema = new GalleryHeroSection();
        $page = $this->galleryPageData();
        $heroData = collect($page['sections'])->firstWhere('key', 'gallery-hero')['data'];

        $normalized = $schema->normalize($heroData);
        $this->assertSame('Visual Monograph & Photographic Tour', $normalized['eyebrow']);
        $this->assertCount(3, $normalized['previews']);
        $this->assertCount(5, $normalized['categories']);

        $this->expectException(InvalidSectionData::class);
        $badData = $heroData;
        unset($badData['previews']);
        $schema->normalize($badData);
    }

    public function test_masonry_schema_validation(): void
    {
        $schema = new GalleryMasonrySection();
        $page = $this->galleryPageData();
        $data = collect($page['sections'])->firstWhere('key', 'gallery-masonry')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(10, $normalized['plates']);
        $this->assertSame('Rooms · Private Suite', $normalized['plates'][0]['cutout_badge']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        unset($badData['plates']);
        $schema->normalize($badData);
    }

    public function test_virtual_tour_schema_validation(): void
    {
        $schema = new GalleryVirtualTourSection();
        $page = $this->galleryPageData();
        $data = collect($page['sections'])->firstWhere('key', 'gallery-virtual-tour')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(4, $normalized['stops']);
        $this->assertSame('STOP 01', $normalized['stops'][0]['stop_index']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        unset($badData['stops']);
        $schema->normalize($badData);
    }

    public function test_pathways_schema_validation(): void
    {
        $schema = new GalleryPathwaysSection();
        $page = $this->galleryPageData();
        $data = collect($page['sections'])->firstWhere('key', 'gallery-pathways')['data'];

        $normalized = $schema->normalize($data);
        $this->assertCount(3, $normalized['cards']);
        $this->assertSame('01', $normalized['cards'][0]['step']);

        $this->expectException(InvalidSectionData::class);
        $badData = $data;
        unset($badData['cards']);
        $schema->normalize($badData);
    }
}
