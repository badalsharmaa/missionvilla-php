<?php

namespace Tests\Feature;

use App\Content\InvalidSectionData;
use App\Content\Sections\ForFamiliesBridgeSection;
use App\Content\Sections\ForFamiliesChecklistSection;
use App\Content\Sections\ForFamiliesDecisionGuideSection;
use App\Content\Sections\ForFamiliesFaqSection;
use App\Content\Sections\ForFamiliesHeroSection;
use App\Content\Sections\ForFamiliesInvolvementSection;
use Tests\TestCase;

class ForFamiliesPageTest extends TestCase
{
    public function test_for_families_page_returns_ok_and_renders_metadata(): void
    {
        $response = $this->get('/for-families');

        $response->assertOk();
        $html = $response->getContent();

        $this->assertStringContainsString('For Families | Questions About Care at Mission Villa', $html);
        $this->assertStringContainsString('415601046', $html);
        $this->assertStringContainsString('<link rel="canonical" href="'.url('/for-families').'"', $html);
    }

    public function test_for_families_page_renders_all_sections_in_order(): void
    {
        $html = $this->get('/for-families')->assertOk()->getContent();

        $posHero = strpos($html, 'id="for-families-hero"');
        $posGuide = strpos($html, 'id="family-decision-guide"');
        $posChecklist = strpos($html, 'id="questions-for-your-visit"');
        $posInv = strpos($html, 'id="family-involvement-and-personalization"');
        $posFaq = strpos($html, 'id="grouped-family-faqs"');
        $posCta = strpos($html, 'id="visit"');

        $this->assertNotFalse($posHero, 'Hero section must exist');
        $this->assertNotFalse($posGuide, 'Decision guide section must exist');
        $this->assertNotFalse($posChecklist, 'Checklist section must exist');
        $this->assertNotFalse($posInv, 'Involvement section must exist');
        $this->assertNotFalse($posFaq, 'FAQ section must exist');
        $this->assertNotFalse($posCta, 'Visit CTA section must exist');

        // ff-bridge is disabled in Editorial V2
        $this->assertStringNotContainsString('id="contextual-planning-bridge"', $html);

        $this->assertTrue($posHero < $posGuide, 'Hero must precede Decision Guide');
        $this->assertTrue($posGuide < $posChecklist, 'Decision Guide must precede Checklist');
        $this->assertTrue($posChecklist < $posInv, 'Checklist must precede Involvement');
        $this->assertTrue($posInv < $posFaq, 'Involvement must precede FAQs');
        $this->assertTrue($posFaq < $posCta, 'FAQs must precede Visit CTA');
    }

    public function test_decision_guide_renders_all_four_steps(): void
    {
        $html = $this->get('/for-families')->assertOk()->getContent();

        $this->assertStringContainsString('Ongoing memory support', $html);
        $this->assertStringContainsString('Temporary support', $html);
        $this->assertStringContainsString('Bridge Support After Illness or Rehabilitation', $html);
        $this->assertStringContainsString('Early Exploration &amp; Suite Comparison', $html);

        $this->assertStringContainsString('data-pathway-tab="ongoing-memory-support"', $html);
        $this->assertStringContainsString('data-pathway-tab="short-term-caregiver-relief"', $html);
        $this->assertStringContainsString('data-pathway-tab="transitional-recovery-stay"', $html);
        $this->assertStringContainsString('data-pathway-tab="planning-ahead-together"', $html);
    }

    public function test_tour_checklist_renders_themes_and_questions(): void
    {
        $html = $this->get('/for-families')->assertOk()->getContent();

        $this->assertStringContainsString('Daily Care &amp; Legacies™', $html);
        $this->assertStringContainsString('Suites &amp; Personalization', $html);
        $this->assertStringContainsString('Dining &amp; Community Life', $html);
        $this->assertStringContainsString('Cost, Assessment &amp; Timing', $html);

        // 8 total questions
        $this->assertSame(8, substr_count($html, 'data-q-card'));
        // Counter displays & submit
        $this->assertStringContainsString('data-selected-count', $html);
        $this->assertStringContainsString('data-check-submit', $html);
    }

    public function test_family_involvement_renders_four_chapters_and_facility_images(): void
    {
        $html = $this->get('/for-families')->assertOk()->getContent();

        $this->assertStringContainsString('id="inv-tab-first-conversations"', $html);
        $this->assertStringContainsString('id="inv-tab-personalizing-the-suite"', $html);
        $this->assertStringContainsString('id="inv-tab-staying-connected"', $html);
        $this->assertStringContainsString('id="inv-tab-evolving-partnership"', $html);

        // Verified images across chapters
        $this->assertStringContainsString('/images/care/memory-care-companion-1122.webp', $html);
        $this->assertStringContainsString('/images/suites/suite-bedroom-facility-899.webp', $html);
        $this->assertStringContainsString('/images/suites/community-lounge-facility-899.webp', $html);
        $this->assertStringContainsString('/images/why-families/courtyard-patio-facility-1024.webp', $html);

        // Strict provenance distinction: Chapter 01 is illustrative; Chapters 02-04 are authentic facility photos
        $this->assertStringContainsString('ILLUSTRATIVE COMMUNITY PHOTO', $html);
        $this->assertStringContainsString('Illustrative photograph', $html);
        $this->assertStringContainsString('MISSION VILLA PROPERTY PHOTO', $html);
        $this->assertStringContainsString('Mission Villa facility photograph · Daly City, CA', $html);
        $this->assertStringContainsString('ff-inv__prov-pill', $html);
    }

    public function test_hero_and_sections_have_no_orphan_font_script_classes(): void
    {
        $html = $this->get('/for-families')->assertOk()->getContent();

        // Hero top-right provenance badge
        $this->assertStringContainsString('class="ff-hero__provenance"', $html);
        $this->assertStringContainsString('class="ff-hero__prov-dot"', $html);
        $this->assertStringContainsString('Mission Villa facility photograph · Daly City, CA', $html);

        // No residual/orphan font-script classes
        $this->assertStringNotContainsString('font-script', $html);
    }

    public function test_grouped_faqs_renders_all_twelve_items_across_four_categories(): void
    {
        $html = $this->get('/for-families')->assertOk()->getContent();

        $this->assertStringContainsString('data-faq-filter="All Topics"', $html);
        $this->assertStringContainsString('data-faq-filter="Care"', $html);
        $this->assertStringContainsString('data-faq-filter="Suites"', $html);
        $this->assertStringContainsString('data-faq-filter="Cost"', $html);
        $this->assertStringContainsString('data-faq-filter="Visits"', $html);

        $this->assertSame(12, substr_count($html, 'data-faq-item'));
        $this->assertStringContainsString('What care does Mission Villa offer?', $html);
        $this->assertStringContainsString('Can I find prices online?', $html);
        $this->assertStringContainsString('Can families use Long-Term Care Insurance, referral credits, or state assistance programs?', $html);
    }

    public function test_planning_bridge_is_disabled_in_editorial_v2(): void
    {
        $page = require base_path('content/pages/for-families.php');
        $bridge = collect($page['sections'])->firstWhere('key', 'ff-bridge');
        $this->assertFalse($bridge['enabled']);
    }

    public function test_all_cta_triggers_bind_modal_intent_and_whitelisted_source(): void
    {
        $html = $this->get('/for-families')->assertOk()->getContent();

        $this->assertStringContainsString('data-inquiry="schedule_visit"', $html);
        $this->assertStringContainsString('data-inquiry-source="visit-cta"', $html);
        $this->assertStringContainsString('data-inquiry-source="ff-faq"', $html);
        $this->assertStringContainsString('href="tel:16507561995"', $html);

        // Honest non-delivery notice in closing CTA
        $this->assertStringContainsString('Submissions save locally while we finalize direct staff notifications', $html);
        $this->assertStringNotContainsString('Our community director will reach out promptly', $html);
    }

    public function test_schema_validates_required_fields_and_rejects_bad_data(): void
    {
        $heroSchema = new ForFamiliesHeroSection();
        $this->expectException(InvalidSectionData::class);
        $heroSchema->normalize(['eyebrow' => '']);
    }

    public function test_faq_schema_rejects_missing_items(): void
    {
        $faqSchema = new ForFamiliesFaqSection();
        $this->expectException(InvalidSectionData::class);
        $faqSchema->normalize([
            'eyebrow' => 'Test',
            'heading' => 'Test',
            'intro' => 'Test',
            'categories' => ['Care', 'Suites', 'Cost'],
            'items' => [], // Must be size 12
        ]);
    }
}
