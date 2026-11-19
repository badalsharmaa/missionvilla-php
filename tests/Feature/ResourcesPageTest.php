<?php

namespace Tests\Feature;

use App\Content\InvalidSectionData;
use App\Content\Sections\ResourcesBlogSection;
use App\Content\Sections\ResourcesDeskSection;
use App\Content\Sections\ResourcesFaqSection;
use App\Content\Sections\ResourcesHeroSection;
use App\Content\Sections\ResourcesPacketSection;
use Tests\TestCase;

class ResourcesPageTest extends TestCase
{
    public function test_resources_page_returns_ok_and_renders_metadata(): void
    {
        $response = $this->get('/resources');

        $response->assertOk();
        $html = $response->getContent();

        $this->assertStringContainsString('Family Resources | Mission Villa Senior Living', $html);
        $this->assertStringContainsString('415601046', $html);
        $this->assertStringContainsString('995 East Market Street', $html);
        $this->assertStringContainsString('<link rel="canonical" href="'.url('/resources').'"', $html);
    }

    public function test_resources_page_renders_active_sections_in_order(): void
    {
        $html = $this->get('/resources')->assertOk()->getContent();

        $posHero = strpos($html, 'id="resources-hero"');
        $posDesk = strpos($html, 'id="resource-pillars-desk"');
        $posPacket = strpos($html, 'id="brochure-and-packet"');
        $posCta = strpos($html, 'id="visit"');

        $this->assertNotFalse($posHero, 'Hero section must exist');
        $this->assertNotFalse($posDesk, 'Desk section must exist');
        $this->assertNotFalse($posPacket, 'Packet builder section must exist');
        $this->assertNotFalse($posCta, 'Visit CTA section must exist');

        // res-blog and res-faq are disabled in Editorial V2
        $this->assertStringNotContainsString('id="blog-inventory-status"', $html);
        $this->assertStringNotContainsString('id="resources-faqs"', $html);

        $this->assertTrue($posHero < $posDesk, 'Hero must precede Resource Desk');
        $this->assertTrue($posDesk < $posPacket, 'Resource Desk must precede Brochure Packet');
        $this->assertTrue($posPacket < $posCta, 'Brochure Packet must precede Visit CTA');
    }

    public function test_hero_renders_four_folio_pillars_and_quick_links(): void
    {
        $html = $this->get('/resources')->assertOk()->getContent();

        // Full-bleed cinematic hero elements
        $this->assertStringContainsString('class="res-hero"', $html);
        $this->assertStringContainsString('res-hero__backdrop', $html);
        $this->assertStringContainsString('sitting-nook-detail.webp', $html);
        $this->assertStringContainsString('res-hero__scrim', $html);
        $this->assertStringContainsString('res-hero__badge', $html);
        $this->assertStringContainsString('res-hero__strip', $html);
        $this->assertStringContainsString('res-hero__provenance', $html);
        $this->assertStringContainsString('res-hero__prov-dot', $html);
        $this->assertStringContainsString('res-hero__prov-text', $html);
        $this->assertStringContainsString('Mission Villa facility photograph · Daly City, CA', $html);

        $this->assertSame(4, substr_count($html, 'data-hero-folio='));
        $this->assertStringContainsString('FOLIO 01', $html);
        $this->assertStringContainsString('FOLIO 02', $html);
        $this->assertStringContainsString('FOLIO 03', $html);
        $this->assertStringContainsString('FOLIO 04', $html);

        $this->assertStringContainsString('Our Editorial Accuracy Commitment', $html);
        $this->assertStringContainsString('Zero Fabricated Articles or Rates', $html);

        // 5 quick links
        $this->assertStringContainsString('href="#resource-pillars-desk"', $html);
        $this->assertStringContainsString('href="#brochure-and-packet"', $html);
        $this->assertStringContainsString('href="#blog-inventory-status"', $html);
        $this->assertStringContainsString('href="#verified-topic-router"', $html);
        $this->assertStringContainsString('href="#resources-faqs"', $html);
    }

    public function test_resource_desk_renders_six_items_and_category_filters(): void
    {
        $html = $this->get('/resources')->assertOk()->getContent();

        $this->assertSame(6, substr_count($html, 'data-desk-item='));
        $this->assertSame(6, substr_count($html, 'data-desk-reader='));

        $this->assertStringContainsString('data-desk-filter="All Resources"', $html);
        $this->assertStringContainsString('data-desk-filter="Financial &amp; Cost Planning"', $html);
        $this->assertStringContainsString('data-desk-filter="Family FAQs &amp; Tour Prep"', $html);
        $this->assertStringContainsString('data-desk-filter="Care &amp; Suite Guides"', $html);
        $this->assertStringContainsString('data-desk-filter="Brochure &amp; Blog Status"', $html);

        $this->assertStringContainsString('Costs &amp; Planning', $html);
        $this->assertStringContainsString('Preparing for a Visit', $html);
        $this->assertStringContainsString('Choosing Care', $html);
        $this->assertStringContainsString('Daily Life &amp; Suites', $html);

        $this->assertStringContainsString('href="'.url('/financial-planning').'"', $html);
        $this->assertStringContainsString('href="'.url('/for-families').'"', $html);
        $this->assertStringContainsString('href="'.url('/living-options').'"', $html);
        $this->assertStringContainsString('href="'.url('/services-and-amenities').'"', $html);
    }

    public function test_brochure_and_packet_builder_renders_five_items_and_honest_brochure_status(): void
    {
        $html = $this->get('/resources')->assertOk()->getContent();

        $this->assertSame(5, substr_count($html, 'data-packet-item='));
        $this->assertStringContainsString('Awaiting Official Mission Villa Brochure PDF &amp; Floor-Plan Inserts', $html);
        $this->assertStringContainsString('CLIENT CONFIRMATION &amp; ASSET REQUIRED', $html);
        $this->assertStringContainsString('mktg.missionvilla@missionvillaseniorliving.com', $html);
        $this->assertStringContainsString('tel:16507561995', $html);

        $this->assertStringContainsString('data-packet-select-all', $html);
        $this->assertStringContainsString('data-packet-clear', $html);
        $this->assertStringContainsString('data-packet-attach-btn', $html);
    }

    public function test_blog_status_is_disabled_in_editorial_v2(): void
    {
        $page = require base_path('content/pages/resources.php');
        $blog = collect($page['sections'])->firstWhere('key', 'res-blog');
        $this->assertFalse($blog['enabled']);
    }

    public function test_resources_faqs_is_disabled_in_editorial_v2(): void
    {
        $page = require base_path('content/pages/resources.php');
        $faq = collect($page['sections'])->firstWhere('key', 'res-faq');
        $this->assertFalse($faq['enabled']);
    }

    public function test_all_cta_triggers_bind_modal_intent_and_whitelisted_sources(): void
    {
        $html = $this->get('/resources')->assertOk()->getContent();

        $this->assertStringContainsString('data-inquiry="schedule_visit"', $html);
        $this->assertStringContainsString('data-inquiry-source="res-hero"', $html);
        $this->assertStringContainsString('data-inquiry-source="res-packet"', $html);
        $this->assertStringContainsString('data-inquiry-source="visit-cta"', $html);
        $this->assertStringContainsString('href="tel:16507561995"', $html);

        // DOCX & Architecture Rule: honest non-delivery notice, zero false promises
        $this->assertStringContainsString('Submissions save locally while we finalize direct staff notifications', $html);
        $this->assertStringNotContainsString('Our community director will reach out promptly', $html);

        // Zero legacy font-script classes
        $this->assertStringNotContainsString('font-script', $html, 'Legacy undefined font-script class must not be present');
    }

    public function test_schemas_validate_required_fields_and_reject_bad_data(): void
    {
        $heroSchema = new ResourcesHeroSection();
        $this->expectException(InvalidSectionData::class);
        $heroSchema->normalize(['eyebrow' => '']);
    }

    public function test_desk_schema_rejects_missing_items(): void
    {
        $deskSchema = new ResourcesDeskSection();
        $this->expectException(InvalidSectionData::class);
        $deskSchema->normalize([
            'eyebrow' => 'Test',
            'heading' => 'Test',
            'intro' => 'Test',
            'categories' => ['All Resources', 'A', 'B', 'C', 'D'],
            'items' => [], // Must be size 6
        ]);
    }

    public function test_packet_schema_rejects_invalid_item_count(): void
    {
        $packetSchema = new ResourcesPacketSection();
        $this->expectException(InvalidSectionData::class);
        $packetSchema->normalize([
            'eyebrow' => 'Test',
            'heading' => 'Test',
            'intro' => 'Test',
            'brochure_card' => [],
            'packet_items' => [], // Must be size 5
        ]);
    }

    public function test_blog_schema_rejects_invalid_stage_count(): void
    {
        $blogSchema = new ResourcesBlogSection();
        $this->expectException(InvalidSectionData::class);
        $blogSchema->normalize([
            'eyebrow' => 'Test',
            'heading' => 'Test',
            'intro' => 'Test',
            'guardrails' => [],
            'stages' => [], // Must be size 4
            'router_eyebrow' => 'Test',
            'router_heading' => 'Test',
            'router_intro' => 'Test',
            'bridges' => [],
        ]);
    }
}
