<?php

namespace Tests\Feature;

use App\Integrations\Leads\DeliveryResult;
use App\Integrations\Leads\LeadDestination;
use App\Integrations\Leads\LeadIntake;
use App\Integrations\Leads\UnconfiguredLeadDestination;
use App\Models\LeadSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LeadIntakeTest extends TestCase
{
    use RefreshDatabase;

    private function lead(): array
    {
        return [
            'kind' => 'visit_request',
            'care_interest' => 'Legacies Memory Care',
            'contact' => ['name' => 'Test Family', 'email' => 'family@example.test'],
            'consent' => ['transactional' => true, 'marketing' => false, 'text_version' => 'test-v1'],
        ];
    }

    public function test_duplicate_submissions_are_stored_once(): void
    {
        $intake = new LeadIntake(new UnconfiguredLeadDestination);

        $first = $intake->accept($this->lead(), 'idem-123');
        $second = $intake->accept($this->lead(), 'idem-123');

        $this->assertTrue($first->is($second));
        $this->assertSame(1, LeadSubmission::count());
    }

    public function test_contact_details_are_encrypted_at_rest(): void
    {
        (new LeadIntake(new UnconfiguredLeadDestination))->accept($this->lead(), 'idem-enc');

        $raw = DB::table('lead_submissions')->value('contact');
        $this->assertStringNotContainsString('family@example.test', $raw);
        $this->assertSame('family@example.test', LeadSubmission::first()->contact['email']);
    }

    public function test_unconfigured_destination_never_marks_a_lead_delivered(): void
    {
        $intake = new LeadIntake(new UnconfiguredLeadDestination);
        $lead = $intake->attemptDelivery($intake->accept($this->lead(), 'idem-456'), maxAttempts: 2);

        $this->assertSame(LeadSubmission::STATUS_QUEUED, $lead->status);
        $this->assertNull($lead->delivered_at);

        $lead = $intake->attemptDelivery($lead, maxAttempts: 2);
        $this->assertSame(LeadSubmission::STATUS_FAILED, $lead->status, 'Exhausted leads are kept as failed, never discarded.');
        $this->assertDatabaseCount('lead_submissions', 1);
    }

    public function test_only_receiver_confirmation_marks_delivery(): void
    {
        $confirming = new class implements LeadDestination
        {
            public function name(): string
            {
                return 'fake';
            }

            public function deliver(LeadSubmission $lead): DeliveryResult
            {
                return DeliveryResult::confirmed('ext-789');
            }
        };

        $intake = new LeadIntake($confirming);
        $lead = $intake->attemptDelivery($intake->accept($this->lead(), 'idem-789'));

        $this->assertSame(LeadSubmission::STATUS_DELIVERED, $lead->status);
        $this->assertSame('ext-789', $lead->external_reference);
    }
}
