<?php

namespace Tests\Feature;

use App\Content\Sections\FaqFeaturedSection;
use App\Content\Sections\VisitCtaSection;
use App\Models\LeadSubmission;
use App\Support\InquiryIntents;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Website-wide rule (2026-11-10): every CTA whose destination is a form opens
 * the shared inquiry modal; nothing scrolls to a form. The modal and the
 * Section 07 inline card are the same form, posting to the same endpoint.
 */
class InquiryModalTest extends TestCase
{
    use RefreshDatabase;

    private function home(): string
    {
        return $this->get('/')->assertOk()->getContent();
    }

    public function test_homepage_has_one_modal_and_one_inline_form_with_unique_ids(): void
    {
        $html = $this->home();

        $this->assertSame(1, substr_count($html, 'data-inquiry-dialog'));
        $this->assertSame(1, substr_count($html, 'data-inquiry-inline'));
        $this->assertSame(2, substr_count($html, 'data-inquiry-form'));
        $this->assertSame(2, preg_match_all('#action="[^"]*/inquiries"#', $html));

        preg_match_all('/\sid="([^"]+)"/', $html, $m);
        $dupes = array_keys(array_filter(array_count_values($m[1]), fn ($n) => $n > 1));
        $this->assertSame([], $dupes, 'Duplicate HTML ids: '.implode(', ', $dupes));
    }

    public function test_no_cta_links_or_scrolls_to_a_form_anchor(): void
    {
        $html = $this->home();

        foreach (['#visit"', '#visit-form"', '#contact"', '#inquiry', '#schedule-visit', '/contact#'] as $anchor) {
            $this->assertStringNotContainsString('href="'.ltrim($anchor, '"'), $html, "Form anchor link found: {$anchor}");
        }
        $this->assertStringNotContainsString('data-open-visit', $html);
        // The hero's former "nothing was sent" demo visit dialog is retired.
        $this->assertStringNotContainsString('visitModalBackdrop', $html);
    }

    public function test_every_form_cta_names_a_known_intent_and_falls_back_to_tel(): void
    {
        $html = $this->home();

        preg_match_all('/<a\s[^>]*data-inquiry="([^"]+)"[^>]*>/', $html, $m, PREG_SET_ORDER);
        $this->assertGreaterThanOrEqual(12, count($m));
        foreach ($m as [$tag, $intent]) {
            $this->assertNotNull(InquiryIntents::resolve($intent), "Unknown intent {$intent}");
            $this->assertMatchesRegularExpression('/href="tel:\d+"/', $tag, "No tel: fallback on {$tag}");
        }
    }

    public function test_sections_05_to_07_open_the_expected_intents(): void
    {
        $html = $this->home();
        $section = fn (string $id) => preg_match('#<section[^>]*id="'.$id.'".*?</section>#s', $html, $s) ? $s[0] : '';

        $suites = $section('suites');
        $this->assertStringContainsString('data-inquiry="request_pricing"', $suites);
        $this->assertStringContainsString('data-inquiry-suite="private"', $suites);
        $this->assertStringContainsString('Request Availability &amp; Pricing', $suites);
        // Floor-plan page is not built: an availability request, never a 404 link.
        $this->assertStringContainsString('data-inquiry="request_availability"', $suites);
        $this->assertStringNotContainsString('href="'.url('/suites-and-floor-plans').'"', $suites);

        $faq = $section('faq');
        foreach (['request_pricing', 'schedule_visit', 'request_callback', 'request_availability'] as $intent) {
            $this->assertStringContainsString('data-inquiry="'.$intent.'"', $faq);
        }

        $visit = $section('visit');
        foreach (['schedule_visit', 'request_pricing', 'request_callback'] as $intent) {
            $this->assertStringContainsString('data-inquiry="'.$intent.'"', $visit);
        }
        $this->assertStringContainsString('id="visit-form"', $visit);
        $this->assertStringContainsString('Request Information or Schedule a Visit', $visit);
        $this->assertStringContainsString('href="tel:16507561995"', $visit);
    }

    public function test_modal_carries_copy_for_every_intent(): void
    {
        $html = $this->home();
        preg_match("/data-copy='([^']+)'/", $html, $m);
        $copy = json_decode(html_entity_decode($m[1]), true);

        $this->assertSame(InquiryIntents::keys(), array_keys($copy));
        $this->assertSame('Schedule a Visit at Mission Villa', $copy['schedule_visit']['title']);
        $this->assertSame('Request Pricing & Availability', $copy['request_pricing']['title']);
        $this->assertSame('Request a Call From Our Team', $copy['request_callback']['title']);
        $this->assertSame('How Can We Help Your Family?', $copy['general_inquiry']['title']);
        $this->assertSame('Ask About Suites & Availability', $copy['request_availability']['title']);
    }

    public function test_aliases_resolve_to_canonical_intents(): void
    {
        $this->assertSame('schedule_visit', InquiryIntents::resolve('visit'));
        $this->assertSame('request_pricing', InquiryIntents::resolve('pricing'));
        $this->assertSame('request_callback', InquiryIntents::resolve('callback'));
        $this->assertSame('general_inquiry', InquiryIntents::resolve('general'));
        $this->assertSame('request_availability', InquiryIntents::resolve('availability'));
        $this->assertNull(InquiryIntents::resolve('newsletter'));
    }

    public function test_faq_and_visit_schemas_reject_unknown_intents(): void
    {
        $this->expectException(\App\Content\InvalidSectionData::class);
        (new VisitCtaSection)->normalize([
            'script' => 'x', 'heading' => 'x', 'body' => 'x', 'show_contact' => true,
            'actions' => [['intent' => 'subscribe', 'label' => 'x', 'icon' => 'phone']],
        ]);
    }

    public function test_faq_answer_actions_are_resolved(): void
    {
        $data = require base_path('content/pages/home.php');
        $faq = collect($data['sections'])->firstWhere('key', 'faq')['data'];
        $items = (new FaqFeaturedSection)->normalize($faq)['items'];

        $pricing = collect($items)->firstWhere('id', 'pricing-and-visits');
        $this->assertSame(['request_pricing', 'schedule_visit'], array_column($pricing['actions'], 'intent'));
        $this->assertSame([], collect($items)->firstWhere('id', 'legacies-memory-care')['actions']);
    }

    // ---- Shared endpoint: new intents, names, source -------------------------------------

    private function payload(array $over = []): array
    {
        return array_merge([
            'intent' => 'request_availability',
            'first_name' => 'Pat',
            'email' => 'pat.family@example.test',
            'suite_preference' => 'shared',
            'source' => 'suites',
            'idempotency_key' => (string) Str::uuid(),
        ], $over);
    }

    public function test_availability_request_stores_kind_suite_and_source(): void
    {
        $this->postJson('/inquiries', $this->payload())->assertCreated()->assertJsonPath('delivery', 'not_connected');

        $lead = LeadSubmission::sole();
        $this->assertSame('availability_request', $lead->kind);
        $this->assertSame('shared', $lead->details['suite_preference']);
        $this->assertSame('suites', $lead->details['source']);
        $this->assertSame('Pat', $lead->contact['name']);
        $this->assertArrayNotHasKey('last_name', $lead->contact);
    }

    public function test_general_inquiry_combines_first_and_last_name(): void
    {
        $this->postJson('/inquiries', $this->payload(['intent' => 'general_inquiry', 'last_name' => 'Family', 'source' => 'visit-form']))->assertCreated();

        $lead = LeadSubmission::sole();
        $this->assertSame('general_inquiry', $lead->kind);
        $this->assertSame('Pat Family', $lead->contact['name']);
        $this->assertArrayNotHasKey('suite_preference', $lead->details);
    }

    public function test_first_name_is_required_and_last_name_is_optional(): void
    {
        $this->postJson('/inquiries', $this->payload(['first_name' => '']))
            ->assertStatus(422)->assertJsonValidationErrors(['first_name'])->assertJsonMissingValidationErrors(['last_name']);
    }

    public function test_unknown_source_and_alias_intent_are_rejected_server_side(): void
    {
        $this->postJson('/inquiries', $this->payload(['source' => 'newsletter']))->assertStatus(422)->assertJsonValidationErrors(['source']);
        // Aliases are a markup convenience only; the form always posts the canonical key.
        $this->postJson('/inquiries', $this->payload(['intent' => 'pricing']))->assertStatus(422)->assertJsonValidationErrors(['intent']);
        $this->assertSame(0, LeadSubmission::count());
    }

    public function test_no_javascript_validation_error_returns_to_inline_form_with_input_kept(): void
    {
        $this->from('/')->post('/inquiries', $this->payload(['first_name' => '', 'email' => 'kept@example.test']))
            ->assertRedirect(url('/').'#visit-form')
            ->assertSessionHasErrors('first_name');

        $html = $this->from('/')->followingRedirects()
            ->post('/inquiries', $this->payload(['first_name' => '', 'email' => 'kept@example.test']))
            ->assertOk()->getContent();
        preg_match('#<div class="vc__card".*?</form>#s', $html, $card);
        $this->assertStringContainsString('value="kept@example.test"', $card[0]);
        $this->assertStringContainsString('Please tell us your first name.', $card[0]);
        // The modal's copy of the form never shows the inline form's round-trip state.
        preg_match('#<dialog.*?</dialog>#s', $html, $dialog);
        $this->assertStringNotContainsString('kept@example.test', $dialog[0]);
    }
}
