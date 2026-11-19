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
        $this->assertStringContainsString('Contact &amp; Schedule a Visit | Mission Villa Senior Living', $html);
        $this->assertStringContainsString('415601046', $html);
        $this->assertStringContainsString('995 East Market Street', $html);
    }

    public function test_contact_page_renders_active_sections_in_order(): void
    {
        $html = $this->get('/contact')->assertOk()->getContent();

        $heroPos = strpos($html, 'id="contact-hero"');
        $studioPos = strpos($html, 'id="schedule-visit"');
        $directionsPos = strpos($html, 'id="map-and-directions"');
        $visitPos = strpos($html, 'id="visit"');

        $this->assertNotFalse($heroPos);
        $this->assertNotFalse($studioPos);
        $this->assertNotFalse($directionsPos);
        $this->assertNotFalse($visitPos);

        // contact-workflow, contact-referral, and contact-faq are disabled in Editorial V2
        $this->assertStringNotContainsString('id="what-happens-next"', $html);
        $this->assertStringNotContainsString('id="referral-interest"', $html);
        $this->assertStringNotContainsString('id="contact-faqs"', $html);

        $this->assertTrue($heroPos < $studioPos, 'Hero must appear before Studio');
        $this->assertTrue($studioPos < $directionsPos, 'Studio must appear before Directions');
        $this->assertTrue($directionsPos < $visitPos, 'Directions must appear before Visit CTA');
    }

    public function test_contact_hero_renders_verified_contact_trio_and_arch_plate(): void
    {
        $html = $this->get('/contact')->assertOk()->getContent();

        // Full-bleed cinematic hero elements
        $this->assertStringContainsString('class="contact-hero"', $html);
        $this->assertStringContainsString('contact-hero__backdrop', $html);
        $this->assertStringContainsString('contact-hero__scrim', $html);
        $this->assertStringContainsString('contact-hero__badge', $html);
        $this->assertStringContainsString('contact-hero__provenance', $html);
        $this->assertStringContainsString('contact-hero__prov-dot', $html);
        $this->assertStringContainsString('contact-hero__prov-text', $html);
        $this->assertStringContainsString('Mission Villa facility photograph · Daly City, CA', $html);

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
        $this->assertStringContainsString('class="contact-hero__btn contact-hero__btn--primary"', $html);
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
        $this->assertStringContainsString('Schedule a Visit', $html);
        $this->assertStringContainsString('Request Pricing', $html);
        $this->assertStringContainsString('Ask About Respite Availability', $html);
        $this->assertStringContainsString('Request a Call', $html);

        // Non-Medical Privacy Notice
        $this->assertStringContainsString('Privacy &amp; Non-Clinical Form Guardrail', $html);
        $this->assertStringContainsString('Please don&#039;t include diagnoses, medication lists, or other sensitive medical information', $html);

        // Form Inputs & Accessibility
        $this->assertStringContainsString('name="full_name"', $html);
        $this->assertStringContainsString('autocomplete="name"', $html);
        $this->assertStringContainsString('name="preferred_method"', $html);
        $this->assertStringContainsString('name="phone"', $html);
        $this->assertStringContainsString('autocomplete="tel"', $html);
        $this->assertStringContainsString('name="email"', $html);
        $this->assertStringContainsString('autocomplete="email"', $html);
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

    public function test_contact_workflow_is_disabled_in_editorial_v2(): void
    {
        $page = require base_path('content/pages/contact.php');
        $workflow = collect($page['sections'])->firstWhere('key', 'contact-workflow');
        $this->assertFalse($workflow['enabled']);
    }

    public function test_contact_referral_is_disabled_in_editorial_v2(): void
    {
        $page = require base_path('content/pages/contact.php');
        $referral = collect($page['sections'])->firstWhere('key', 'contact-referral');
        $this->assertFalse($referral['enabled']);
    }

    public function test_contact_faqs_is_disabled_in_editorial_v2(): void
    {
        $page = require base_path('content/pages/contact.php');
        $faq = collect($page['sections'])->firstWhere('key', 'contact-faq');
        $this->assertFalse($faq['enabled']);
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

    public function test_closing_cta_displays_honest_notice_and_no_false_promises(): void
    {
        $html = $this->get('/contact')->assertOk()->getContent();

        // DOCX Section 6 & 10: Honest non-delivery notice, zero false promises
        $this->assertStringContainsString('Submissions save locally while we finalize direct staff notifications', $html);
        $this->assertStringNotContainsString('Our Daly City community director will reach out promptly', $html);
    }
}
