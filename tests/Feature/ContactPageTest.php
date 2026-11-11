<?php

namespace Tests\Feature;

use App\Content\InvalidSectionData;
use App\Content\Sections\ContactDirectionsSection;
use App\Content\Sections\ContactFaqSection;
use App\Content\Sections\ContactHeroSection;
use App\Content\Sections\ContactReferralSection;
use App\Content\Sections\ContactStudioSection;
use App\Content\Sections\ContactWorkflowSection;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    public function test_contact_page_returns_ok_and_canonical(): void
    {
        $response = $this->get('/contact');
        $response->assertOk();

        $html = $response->getContent();
        $this->assertStringContainsString('<link rel="canonical" href="'.url('/contact').'">', $html);
        $this->assertStringContainsString('Contact Us &amp; Schedule a Visit | Mission Villa Daly City', $html);
        $this->assertStringContainsString('415601046', $html);
        $this->assertStringContainsString('995 East Market Street', $html);
    }

    public function test_contact_page_renders_all_seven_sections_in_order(): void
    {
        $html = $this->get('/contact')->assertOk()->getContent();

        $heroPos = strpos($html, 'id="contact-hero"');
        $studioPos = strpos($html, 'id="schedule-visit"');
        $directionsPos = strpos($html, 'id="map-and-directions"');
        $workflowPos = strpos($html, 'id="what-happens-next"');
        $referralPos = strpos($html, 'id="referral-interest"');
        $faqPos = strpos($html, 'id="contact-faqs"');
        $visitPos = strpos($html, 'id="visit"');

        $this->assertNotFalse($heroPos);
        $this->assertNotFalse($studioPos);
        $this->assertNotFalse($directionsPos);
        $this->assertNotFalse($workflowPos);
        $this->assertNotFalse($referralPos);
        $this->assertNotFalse($faqPos);
        $this->assertNotFalse($visitPos);

        $this->assertTrue($heroPos < $studioPos, 'Hero must appear before Studio');
        $this->assertTrue($studioPos < $directionsPos, 'Studio must appear before Directions');
        $this->assertTrue($directionsPos < $workflowPos, 'Directions must appear before Workflow');
        $this->assertTrue($workflowPos < $referralPos, 'Workflow must appear before Referral');
        $this->assertTrue($referralPos < $faqPos, 'Referral must appear before FAQs');
        $this->assertTrue($faqPos < $visitPos, 'FAQs must appear before closing Visit CTA');
    }

    public function test_contact_hero_renders_verified_contact_trio_and_arch_plate(): void
    {
        $html = $this->get('/contact')->assertOk()->getContent();

        // Phone, Email, Address
        $this->assertStringContainsString('650-756-1995', $html);
        $this->assertStringContainsString('href="tel:16507561995"', $html);
        $this->assertStringContainsString('mktg.missionvilla@missionvillaseniorliving.com', $html);
        $this->assertStringContainsString('href="mailto:mktg.missionvilla@missionvillaseniorliving.com"', $html);
        $this->assertStringContainsString('data-copy-address="995 East Market Street, Daly City, CA 94014"', $html);

        // Botanical Arch Arrival Plate
        $this->assertStringContainsString('/images/property/courtyard-patio.webp', $html);
        $this->assertStringContainsString('botanical-arch', $html);
        $this->assertStringContainsString('MISSION VILLA · PROPERTY PHOTO', $html);

        // 4 Quick Section Links & Modal Form CTA
        $this->assertStringContainsString('data-inquiry="schedule_visit"', $html);
        $this->assertStringContainsString('href="#schedule-visit"', $html);
        $this->assertStringContainsString('href="#map-and-directions"', $html);
        $this->assertStringContainsString('href="#what-happens-next"', $html);
        $this->assertStringContainsString('href="#referral-interest"', $html);
    }

    public function test_contact_studio_renders_form_presets_and_privacy_guardrail(): void
    {
        $html = $this->get('/contact')->assertOk()->getContent();

        $this->assertStringContainsString('data-contact-studio', $html);
        $this->assertStringContainsString('data-contact-form', $html);
        $this->assertStringContainsString('data-testid="contact-demo-confirmation"', $html);

        // 4 Presets
        $this->assertStringContainsString('Tour Memory Care Suites', $html);
        $this->assertStringContainsString('Short-Term Respite Stay', $html);
        $this->assertStringContainsString('Pricing &amp; Paper-Ledger Chat', $html);
        $this->assertStringContainsString('First Family Phone Call', $html);

        // Non-Medical Privacy Notice
        $this->assertStringContainsString('Privacy &amp; Non-Clinical Form Guardrail', $html);
        $this->assertStringContainsString('never asks for medical diagnoses, medication lists, or clinical health histories', $html);

        // Form Inputs
        $this->assertStringContainsString('name="full_name"', $html);
        $this->assertStringContainsString('name="preferred_method"', $html);
        $this->assertStringContainsString('name="phone"', $html);
        $this->assertStringContainsString('name="email"', $html);
        $this->assertStringContainsString('name="care_interest"', $html);
        $this->assertStringContainsString('name="suite_preference"', $html);
        $this->assertStringContainsString('name="preferred_window"', $html);
        $this->assertStringContainsString('name="visit_timing"', $html);
        $this->assertStringContainsString('name="message"', $html);
        $this->assertStringContainsString('name="consent_accepted"', $html);
    }

    public function test_contact_directions_renders_all_four_corridors_and_both_canvas_modes(): void
    {
        $html = $this->get('/contact')->assertOk()->getContent();

        // 4 Corridors
        $this->assertStringContainsString('data-corridor-id="corridor-i280-peninsula"', $html);
        $this->assertStringContainsString('data-corridor-id="corridor-sf-mission"', $html);
        $this->assertStringContainsString('data-corridor-id="corridor-bart-transit"', $html);
        $this->assertStringContainsString('data-corridor-id="corridor-parking-accessibility"', $html);

        // Routes
        $this->assertStringContainsString('Approaching From I-280 North or South', $html);
        $this->assertStringContainsString('Approaching From San Francisco, Excelsior, Glen Park &amp; Sunset', $html);
        $this->assertStringContainsString('BART &amp; SamTrans Connections in Daly City', $html);
        $this->assertStringContainsString('On-Site Visitor Parking &amp; Accessible Community Entry', $html);

        // Canvas modes
        $this->assertStringContainsString('data-canvas-editorial', $html);
        $this->assertStringContainsString('data-canvas-embed', $html);
        $this->assertStringContainsString('output=embed', $html);
    }

    public function test_contact_workflow_renders_all_four_steps(): void
    {
        $html = $this->get('/contact')->assertOk()->getContent();

        $this->assertStringContainsString('data-workflow-tab="post-step-01-acknowledgment"', $html);
        $this->assertStringContainsString('data-workflow-tab="post-step-02-listening-call"', $html);
        $this->assertStringContainsString('data-workflow-tab="post-step-03-personal-walkthrough"', $html);
        $this->assertStringContainsString('data-workflow-tab="post-step-04-care-and-pricing-plan"', $html);

        $this->assertStringContainsString('Step 01', $html);
        $this->assertStringContainsString('Step 02', $html);
        $this->assertStringContainsString('Step 03', $html);
        $this->assertStringContainsString('Step 04', $html);

        $this->assertStringContainsString('Once Live Backend Is Connected', $html);
        $this->assertStringContainsString('Current Prototype Stage (Today)', $html);
    }

    public function test_contact_referral_renders_both_pathways(): void
    {
        $html = $this->get('/contact')->assertOk()->getContent();

        $this->assertStringContainsString('data-referral-tab="family-friend-referral"', $html);
        $this->assertStringContainsString('data-referral-tab="professional-care-referral"', $html);
        $this->assertStringContainsString('Referring a Friend or Relative to Mission Villa', $html);
        $this->assertStringContainsString('Discharge Planners, Care Managers &amp; Peninsula Senior Advisors', $html);
        $this->assertStringContainsString('CLIENT CONFIRMATION REQUIRED', $html);
        $this->assertStringContainsString('data-referral-prefill', $html);
    }

    public function test_contact_faqs_renders_search_categories_and_all_six_items(): void
    {
        $html = $this->get('/contact')->assertOk()->getContent();

        $this->assertStringContainsString('data-faq-search', $html);
        $this->assertStringContainsString('data-faq-item="contact-faq-schedule-tour"', $html);
        $this->assertStringContainsString('data-faq-item="contact-faq-what-to-expect-on-tour"', $html);
        $this->assertStringContainsString('data-faq-item="contact-faq-parking-and-mobility"', $html);
        $this->assertStringContainsString('data-faq-item="contact-faq-phone-numbers"', $html);
        $this->assertStringContainsString('data-faq-item="contact-faq-no-medical-history"', $html);
        $this->assertStringContainsString('data-faq-item="contact-faq-digital-accessibility"', $html);

        // Bridges
        $this->assertStringContainsString('For Families &amp; Visit Questions Guide', $html);
        $this->assertStringContainsString('Financial Planning &amp; Paper Ledger', $html);
        $this->assertStringContainsString('Suites, Floor Plans &amp; Gallery', $html);
    }

    public function test_contact_hero_schema_validation(): void
    {
        $schema = new ContactHeroSection;
        $this->assertSame('contact.hero', $schema::type());
        $this->assertSame('sections.contact-hero.index', $schema::view());

        $this->expectException(InvalidSectionData::class);
        $schema->normalize(['eyebrow' => 'Incomplete']);
    }

    public function test_contact_studio_schema_validation(): void
    {
        $schema = new ContactStudioSection;
        $this->assertSame('contact.studio', $schema::type());
        $this->assertSame('sections.contact-studio.index', $schema::view());

        $this->expectException(InvalidSectionData::class);
        $schema->normalize(['heading' => 'Missing fields']);
    }

    public function test_contact_directions_schema_validation(): void
    {
        $schema = new ContactDirectionsSection;
        $this->assertSame('contact.directions', $schema::type());
        $this->assertSame('sections.contact-directions.index', $schema::view());

        $this->expectException(InvalidSectionData::class);
        $schema->normalize(['heading' => 'Missing fields']);
    }

    public function test_contact_workflow_schema_validation(): void
    {
        $schema = new ContactWorkflowSection;
        $this->assertSame('contact.workflow', $schema::type());
        $this->assertSame('sections.contact-workflow.index', $schema::view());

        $this->expectException(InvalidSectionData::class);
        $schema->normalize(['steps' => []]);
    }

    public function test_contact_referral_schema_validation(): void
    {
        $schema = new ContactReferralSection;
        $this->assertSame('contact.referral', $schema::type());
        $this->assertSame('sections.contact-referral.index', $schema::view());

        $this->expectException(InvalidSectionData::class);
        $schema->normalize(['pathways' => []]);
    }

    public function test_contact_faq_schema_validation(): void
    {
        $schema = new ContactFaqSection;
        $this->assertSame('contact.faq', $schema::type());
        $this->assertSame('sections.contact-faq.index', $schema::view());

        $this->expectException(InvalidSectionData::class);
        $schema->normalize(['faqs' => []]);
    }
}
