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

        $this->assertStringContainsString('Financial Planning &amp; Cost Clarity: Memory Care in Daly City | Mission Villa', $html);
        $this->assertStringContainsString('415601046', $html);
        $this->assertStringContainsString('<link rel="canonical" href="'.url('/financial-planning').'"', $html);
    }

    public function test_financial_planning_page_renders_all_seven_sections_in_order(): void
    {
        $html = $this->get('/financial-planning')->assertOk()->getContent();

        $posHero = strpos($html, 'id="financial-planning-hero"');
        $posFactors = strpos($html, 'id="factors-affecting-cost"');
        $posInclusions = strpos($html, 'id="grouped-cost-inclusions"');
        $posWorksheet = strpos($html, 'id="paper-ledger-worksheet"');
        $posPathways = strpos($html, 'id="planning-pathways-and-benefits"');
        $posFaq = strpos($html, 'id="financial-planning-faqs"');
        $posCta = strpos($html, 'id="visit"');

        $this->assertNotFalse($posHero, 'Hero section must exist');
        $this->assertNotFalse($posFactors, 'Factors section must exist');
        $this->assertNotFalse($posInclusions, 'Inclusions section must exist');
        $this->assertNotFalse($posWorksheet, 'Worksheet section must exist');
        $this->assertNotFalse($posPathways, 'Pathways section must exist');
        $this->assertNotFalse($posFaq, 'FAQ section must exist');
        $this->assertNotFalse($posCta, 'Visit CTA section must exist');

        $this->assertTrue($posHero < $posFactors, 'Hero must precede Factors');
        $this->assertTrue($posFactors < $posInclusions, 'Factors must precede Inclusions');
        $this->assertTrue($posInclusions < $posWorksheet, 'Inclusions must precede Worksheet');
        $this->assertTrue($posWorksheet < $posPathways, 'Worksheet must precede Pathways');
        $this->assertTrue($posPathways < $posFaq, 'Pathways must precede FAQs');
        $this->assertTrue($posFaq < $posCta, 'FAQs must precede Visit CTA');
    }

    public function test_factors_section_renders_all_four_factors_and_what_we_review_together(): void
    {
        $html = $this->get('/financial-planning')->assertOk()->getContent();

        $this->assertSame(4, substr_count($html, 'data-factor-card'));
        $this->assertStringContainsString('Assessment-Informed Personal Care Needs', $html);
        $this->assertStringContainsString('Suite Layout &amp; Shared vs. Private Living', $html);
        $this->assertStringContainsString('Long-Term Memory Care vs. Short-Term Respite Stays', $html);
        $this->assertStringContainsString('Included Community Living vs. Personal Add-Ons', $html);

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

    public function test_pathways_section_renders_all_four_pathways_and_notes(): void
    {
        $html = $this->get('/financial-planning')->assertOk()->getContent();

        $this->assertSame(4, substr_count($html, 'data-pathway-card'));
        $this->assertStringContainsString('Personalized Care Assessment &amp; Written Cost Overview', $html);
        $this->assertStringContainsString('Long-Term Care Insurance Policies', $html);
        $this->assertStringContainsString('Home Equity, Family Contributions &amp; Companion Suite Value', $html);
        $this->assertStringContainsString('Referral Credits &amp; State Assistance Participation', $html);

        $this->assertStringContainsString('CLIENT CONFIRMATION REQUIRED: Referral credit offers', $html);
    }

    public function test_financial_faq_section_renders_all_six_items(): void
    {
        $html = $this->get('/financial-planning')->assertOk()->getContent();

        $this->assertSame(6, substr_count($html, 'data-faq-item'));
        $this->assertStringContainsString('Why doesn’t Mission Villa list fixed monthly prices or an automated calculator online?', $html);
        $this->assertStringContainsString('How does the care assessment influence Memory Care costs?', $html);
        $this->assertStringContainsString('What is typically included in monthly Memory Care living at Mission Villa?', $html);
        $this->assertStringContainsString('How do Companion Units and Jack &amp; Jill suites help families planning a budget?', $html);
        $this->assertStringContainsString('Can we use Long-Term Care Insurance, referral credits, or state assistance programs?', $html);
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
