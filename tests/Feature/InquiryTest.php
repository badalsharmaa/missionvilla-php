<?php

namespace Tests\Feature;

use App\Models\LeadSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class InquiryTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $over = []): array
    {
        return array_merge([
            'intent' => 'request_pricing',
            'name' => 'Pat Family',
            'email' => 'pat.family@example.test',
            'suite_preference' => 'private',
            'idempotency_key' => (string) Str::uuid(),
        ], $over);
    }

    public function test_valid_pricing_request_is_stored_and_honestly_reported(): void
    {
        $response = $this->postJson('/inquiries', $this->payload());

        $response->assertCreated()
            ->assertJson(['status' => 'received', 'delivered' => false, 'delivery' => 'not_connected']);
        $this->assertMatchesRegularExpression('/^[0-9A-F]{8}$/', $response->json('reference'));
        $this->assertStringContainsString('has not been sent', $response->json('message'));

        $this->assertSame(1, LeadSubmission::count());
        $lead = LeadSubmission::first();
        $this->assertSame('pricing_request', $lead->kind);
        $this->assertSame('private', $lead->details['suite_preference']);
        $this->assertFalse($lead->consent['marketing']);
        $this->assertSame(config('missionvilla.inquiries.consent_version'), $lead->consent['text_version']);
    }

    public function test_contact_is_encrypted_at_rest(): void
    {
        $this->postJson('/inquiries', $this->payload())->assertCreated();

        $raw = DB::table('lead_submissions')->value('contact');
        $this->assertStringNotContainsString('pat.family@example.test', $raw);
        $this->assertSame('pat.family@example.test', LeadSubmission::first()->contact['email']);
    }

    public function test_response_never_echoes_contact_details(): void
    {
        $body = $this->postJson('/inquiries', $this->payload(['phone' => '(650) 555-0100']))->assertCreated()->getContent();

        $this->assertStringNotContainsString('pat.family@example.test', $body);
        $this->assertStringNotContainsString('555-0100', $body);
    }

    public function test_callback_requires_phone_but_not_email(): void
    {
        $this->postJson('/inquiries', $this->payload(['intent' => 'request_callback']))
            ->assertStatus(422)->assertJsonValidationErrors('phone');

        $this->postJson('/inquiries', $this->payload(['intent' => 'request_callback', 'email' => null, 'phone' => '650-555-0100']))
            ->assertCreated();
        $this->assertSame('callback_request', LeadSubmission::first()->kind);
    }

    public function test_visit_accepts_email_only(): void
    {
        $this->postJson('/inquiries', $this->payload(['intent' => 'schedule_visit']))->assertCreated();
        $this->assertSame('visit_request', LeadSubmission::first()->kind);
    }

    public function test_phone_with_too_few_digits_is_rejected(): void
    {
        $this->postJson('/inquiries', $this->payload(['email' => null, 'phone' => '555-0100']))
            ->assertStatus(422)->assertJsonValidationErrors('phone');
    }

    public function test_invalid_intent_is_rejected(): void
    {
        $this->postJson('/inquiries', $this->payload(['intent' => 'hack']))
            ->assertStatus(422)->assertJsonValidationErrors('intent');
        $this->assertSame(0, LeadSubmission::count());
    }

    public function test_honeypot_blocks_and_stores_nothing(): void
    {
        $this->postJson('/inquiries', $this->payload(['company_website' => 'http://spam.test']))
            ->assertStatus(422);
        $this->assertSame(0, LeadSubmission::count());
    }

    public function test_same_idempotency_key_stores_one_lead(): void
    {
        $payload = $this->payload();

        $this->postJson('/inquiries', $payload)->assertCreated();
        $this->postJson('/inquiries', $payload)->assertCreated();

        $this->assertSame(1, LeadSubmission::count());
    }

    public function test_marketing_opt_in_is_recorded(): void
    {
        $this->postJson('/inquiries', $this->payload(['marketing_opt_in' => 1]))->assertCreated();

        $this->assertTrue(LeadSubmission::first()->consent['marketing']);
    }

    public function test_suite_preference_is_ignored_for_callbacks(): void
    {
        $this->postJson('/inquiries', $this->payload(['intent' => 'request_callback', 'phone' => '650-555-0100', 'suite_preference' => 'shared']))
            ->assertCreated();

        $this->assertArrayNotHasKey('suite_preference', LeadSubmission::first()->details);
    }

    public function test_disabled_storage_returns_503_and_stores_nothing(): void
    {
        config(['missionvilla.inquiries.store' => false]);

        $this->postJson('/inquiries', $this->payload())
            ->assertStatus(503)->assertJson(['status' => 'disabled']);
        $this->assertSame(0, LeadSubmission::count());
    }

    public function test_sixth_request_within_a_minute_is_throttled(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/inquiries', $this->payload())->assertCreated();
        }

        $this->postJson('/inquiries', $this->payload())->assertStatus(429);
    }

    public function test_plain_form_post_redirects_to_visit_section_with_notice(): void
    {
        $this->post('/inquiries', $this->payload())
            ->assertRedirect(url('/').'#visit')
            ->assertSessionHas('inquiry_notice.status', 'received');
    }
}
