<?php

namespace Tests\Feature;

use App\Content\InvalidSectionData;
use App\Content\Sections\FinancialPlanningFactorsSection;
use App\Content\Sections\FinancialPlanningFaqSection;
use App\Content\Sections\FinancialPlanningHeroSection;
use App\Content\Sections\FinancialPlanningInclusionsSection;
use App\Content\Sections\FinancialPlanningPathwaysSection;
use App\Content\Sections\FinancialPlanningWorksheetSection;
use Tests\TestCase;

class FinancialPlanningPageTest extends TestCase
{
    public function test_financial_planning_page_returns_ok_and_renders_metadata(): void
    {
        $response = $this->get('/financial-planning');

        $response->assertOk();
        $html = $response->getContent();

        $this->assertStringContainsString('Memory Care &amp; Respite Care Costs | Mission Villa', $html);
        $this->assertStringContainsString('415601046', $html);
        $this->assertStringContainsString('<link rel="canonical" href="'.url('/financial-planning').'"', $html);
    }

    public function test_financial_planning_page_renders_all_sections_in_order(): void
    {
        $html = $this->get('/financial-planning')->assertOk()->getContent();

        $posHero = strpos($html, 'id="financial-planning-hero"');
        $posFactors = strpos($html, 'id="factors-affecting-cost"');
        $posInclusions = strpos($html, 'id="grouped-cost-inclusions"');
        $posWorksheet = strpos($html, 'id="paper-ledger-worksheet"');
        $posFaq = strpos($html, 'id="financial-planning-faqs"');
        $posCta = strpos($html, 'id="visit"');

        $this->assertNotFalse($posHero, 'Hero section must exist');
        $this->assertNotFalse($posFactors, 'Factors section must exist');
        $this->assertNotFalse($posInclusions, 'Inclusions section must exist');
        $this->assertNotFalse($posWorksheet, 'Worksheet section must exist');
        $this->assertNotFalse($posFaq, 'FAQ section must exist');
        $this->assertNotFalse($posCta, 'Visit CTA section must exist');

        // fp-pathways is disabled in Editorial V2
        $this->assertStringNotContainsString('id="planning-pathways-and-benefits"', $html);

        $this->assertTrue($posHero < $posFactors, 'Hero must precede Factors');
        $this->assertTrue($posFactors < $posInclusions, 'Factors must precede Inclusions');
        $this->assertTrue($posInclusions < $posWorksheet, 'Inclusions must precede Worksheet');
        $this->assertTrue($posWorksheet < $posFaq, 'Worksheet must precede FAQs');
        $this->assertTrue($posFaq < $posCta, 'FAQs must precede Visit CTA');
    }

    public function test_factors_section_renders_all_four_factors_and_what_we_review_together(): void
    {
        $html = $this->get('/financial-planning')->assertOk()->getContent();

        $this->assertSame(4, substr_count($html, 'data-factor-card'));
        $this->assertStringContainsString('Care needs', $html);
        $this->assertStringContainsString('Suite choice', $html);
        $this->assertStringContainsString('Length of stay', $html);
        $this->assertStringContainsString('Additional services', $html);

        $this->assertStringContainsString('href="/memory-care"', $html);
        $this->assertStringContainsString('href="/suites-and-floor-plans"', $html);
        $this->assertStringContainsString('href="/respite-care"', $html);
        $this->assertStringContainsString('href="/services-and-amenities"', $html);

        $this->assertStringContainsString('What We Review With Your Family', $html);
        $this->assertStringContainsString('Level of daily assistance with bathing, dressing, grooming, and personal hygiene', $html);
    }

    public function test_inclusions_section_renders_ten_items_across_categories(): void
    {
        $html = $this->get('/financial-planning')->assertOk()->getContent();

        $this->assertSame(10, substr_count($html, 'data-inc-card'));
        $this->assertStringContainsString('data-inc-filter="All Categories"', $html);
        $this->assertStringContainsString('data-inc-filter="Housing &amp; Suite Comfort"', $html);
        $this->assertStringContainsString('data-inc-filter="Chef-Prepared Dining"', $html);
        $this->assertStringContainsString('data-inc-filter="24-Hour Support &amp; Care"', $html);
        $this->assertStringContainsString('data-inc-filter="Housekeeping &amp; Daily Living"', $html);
        $this->assertStringContainsString('data-inc-filter="Life Enrichment &amp; Community"', $html);

        $this->assertStringContainsString('Standard Community Offering', $html);
        $this->assertStringContainsString('CLIENT CONFIRMATION REQUIRED', $html);
        $this->assertStringContainsString('Three Daily Chef-Prepared Meals &amp; Nutritious Snacks', $html);
    }

    public function test_paper_ledger_worksheet_renders_eight_rows_and_interactive_elements(): void
    {
        $html = $this->get('/financial-planning')->assertOk()->getContent();

        $this->assertSame(8, substr_count($html, 'data-ledger-row='));
        $this->assertSame(8, substr_count($html, 'data-ledger-input='));
        $this->assertSame(8, substr_count($html, 'data-ledger-check='));

        // Blank input structure verified (never pre-filled fake pricing)
        $this->assertStringContainsString('type="number"', $html);
        $this->assertStringContainsString('min="0"', $html);
        $this->assertStringContainsString('placeholder="Blank — enter your figure"', $html);

        // Action controls
        $this->assertStringContainsString('data-ledger-action="print"', $html);
        $this->assertStringContainsString('data-ledger-action="clear"', $html);
        $this->assertStringContainsString('data-ledger-mode="worksheet"', $html);
        $this->assertStringContainsString('data-ledger-mode="checklist"', $html);
        $this->assertStringContainsString('data-ledger-submit-btn', $html);
    }

    public function test_pathways_section_is_disabled_in_editorial_v2(): void
    {
        $page = require base_path('content/pages/financial-planning.php');
        $pathways = collect($page['sections'])->firstWhere('key', 'fp-pathways');
        $this->assertFalse($pathways['enabled']);
    }

    public function test_financial_faq_section_renders_all_six_items(): void
    {
        $html = $this->get('/financial-planning')->assertOk()->getContent();

        $this->assertSame(6, substr_count($html, 'data-faq-item'));
        $this->assertStringContainsString('Can I get a price before visiting?', $html);
        $this->assertStringContainsString('How does the care assessment influence Memory Care costs?', $html);
        $this->assertStringContainsString('What is typically included in monthly Memory Care living at Mission Villa?', $html);
        $this->assertStringContainsString('Will the cost depend on the suite?', $html);
        $this->assertStringContainsString('What about insurance or benefits?', $html);
        $this->assertStringContainsString('How does pricing work for a short-term Respite Care stay?', $html);
    }

    public function test_all_cta_triggers_bind_modal_intent_and_whitelisted_sources(): void
    {
        $html = $this->get('/financial-planning')->assertOk()->getContent();

        $this->assertStringContainsString('data-inquiry="schedule_visit"', $html);
        $this->assertStringContainsString('data-inquiry="request_pricing"', $html);
        $this->assertStringContainsString('data-inquiry-source="visit-cta"', $html);
        $this->assertStringContainsString('data-inquiry-source="fp-worksheet"', $html);
        $this->assertStringContainsString('href="tel:16507561995"', $html);

        // Honest non-delivery notice in closing CTA
        $this->assertStringContainsString('Submissions save locally while we finalize direct staff notifications', $html);
        $this->assertStringNotContainsString('Our community director will reach out promptly', $html);

        // Standardized top-right hero provenance badge
        $this->assertStringContainsString('fp-hero__provenance', $html);
        $this->assertStringContainsString('fp-hero__prov-dot', $html);
        $this->assertStringContainsString('fp-hero__prov-text', $html);
        $this->assertStringContainsString('Mission Villa facility photograph · Daly City, CA', $html);

        // Zero legacy font-script classes
        $this->assertStringNotContainsString('font-script', $html, 'Legacy undefined font-script class must not be present');
    }

    public function test_schemas_validate_required_fields_and_reject_bad_data(): void
    {
        $heroSchema = new FinancialPlanningHeroSection();
        $this->expectException(InvalidSectionData::class);
        $heroSchema->normalize(['eyebrow' => '']);
    }

    public function test_factors_schema_rejects_missing_factors(): void
    {
        $factorsSchema = new FinancialPlanningFactorsSection();
        $this->expectException(InvalidSectionData::class);
        $factorsSchema->normalize([
            'eyebrow' => 'Test',
            'heading' => 'Test',
            'intro' => 'Test',
            'factors' => [], // Must be size 4
        ]);
    }

    public function test_worksheet_schema_rejects_invalid_row_count(): void
    {
        $worksheetSchema = new FinancialPlanningWorksheetSection();
        $this->expectException(InvalidSectionData::class);
        $worksheetSchema->normalize([
            'eyebrow' => 'Test',
            'heading' => 'Test',
            'intro' => 'Test',
            'instructions' => 'Test',
            'rows' => [], // Must be size 8
            'print_disclaimer' => 'Test',
        ]);
    }
}
