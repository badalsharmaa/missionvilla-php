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
        $this->assertStringContainsString('<title>Photo Gallery | Mission Villa Senior Living in Daly City</title>', $html);
        $this->assertStringContainsString('Take a look inside Mission Villa Senior Living in Daly City', $html);

        // Sections presence in order
        $heroPos = strpos($html, 'data-gh-hero');
        $masonryPos = strpos($html, 'id="editorial-masonry-gallery"');
        $tourPos = strpos($html, 'id="virtual-tour"');
        $visitPos = strpos($html, 'id="visit"');

        $this->assertNotFalse($heroPos, 'Hero section missing');
        $this->assertNotFalse($masonryPos, 'Masonry section missing');
        $this->assertNotFalse($tourPos, 'Virtual tour section missing');
        $this->assertNotFalse($visitPos, 'Closing visit CTA section missing');

        // gallery-pathways is disabled in Editorial V2
        $this->assertStringNotContainsString('id="gallery-visit-bridge"', $html);

        $this->assertTrue($heroPos < $masonryPos, 'Hero must precede Masonry');
        $this->assertTrue($masonryPos < $tourPos, 'Masonry must precede Virtual Tour');
        $this->assertTrue($tourPos < $visitPos, 'Virtual Tour must precede Visit CTA');

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

    public function test_masonry_section_renders_five_verified_plates_with_cutouts_and_lightbox(): void
    {
        $html = $this->get('/gallery')->assertOk()->getContent();

        // 5 plates codes
        $this->assertStringContainsString('PLATE 01', $html);
        $this->assertStringContainsString('PLATE 02', $html);
        $this->assertStringContainsString('PLATE 03', $html);
        $this->assertStringContainsString('PLATE 04', $html);
        $this->assertStringContainsString('PLATE 05', $html);
        $this->assertStringNotContainsString('PLATE 06', $html);

        // Core titles
        $this->assertStringContainsString('Private Suite', $html);
        $this->assertStringContainsString('Community Lounge', $html);
        $this->assertStringContainsString('Courtyard &amp; Patio', $html);
        $this->assertStringContainsString('Dining Space', $html);
        $this->assertStringContainsString('Quiet Sitting Area', $html);

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

    public function test_pathways_bridge_is_disabled_in_editorial_v2(): void
    {
        $page = $this->galleryPageData();
        $pathways = collect($page['sections'])->firstWhere('key', 'gallery-pathways');
        $this->assertFalse($pathways['enabled']);
    }

    public function test_hero_schema_validation(): void
    {
        $schema = new GalleryHeroSection();
        $page = $this->galleryPageData();
        $heroData = collect($page['sections'])->firstWhere('key', 'gallery-hero')['data'];

        $normalized = $schema->normalize($heroData);
        $this->assertSame('Photo Gallery', $normalized['eyebrow']);
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
        $this->assertCount(5, $normalized['plates']);
        $this->assertSame('Private Suite', $normalized['plates'][0]['title']);

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
