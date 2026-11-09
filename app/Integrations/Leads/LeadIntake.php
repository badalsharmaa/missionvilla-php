<?php

namespace App\Integrations\Leads;

use App\Models\LeadSubmission;
use Illuminate\Support\Str;

/**
 * Stores a validated website lead durably before any delivery attempt and
 * prevents duplicates from double-clicks or retried requests.
 *
 * Not yet exposed by a public route: the approved hero visit form is still
 * an explicit "nothing was sent" design preview.
 */
final class LeadIntake
{
    public function __construct(private readonly LeadDestination $destination) {}

    /**
     * @param  array{kind: string, care_interest?: ?string, contact: array, details?: ?array, consent: array, attribution?: ?array}  $lead
     */
    public function accept(array $lead, string $idempotencyKey): LeadSubmission
    {
        $existing = LeadSubmission::where('idempotency_key', $idempotencyKey)->first();
        if ($existing) {
            return $existing;
        }

        return LeadSubmission::create([
            'uuid' => (string) Str::uuid(),
            'idempotency_key' => $idempotencyKey,
            'kind' => $lead['kind'],
            'care_interest' => $lead['care_interest'] ?? null,
            'contact' => $lead['contact'],
            'details' => $lead['details'] ?? null,
            'consent' => $lead['consent'],
            'attribution' => $lead['attribution'] ?? null,
            'status' => LeadSubmission::STATUS_RECEIVED,
        ]);
    }

    /** One delivery attempt. Callers (a queued job) decide retry timing. */
    public function attemptDelivery(LeadSubmission $lead, int $maxAttempts = 8): LeadSubmission
    {
        if ($lead->status === LeadSubmission::STATUS_DELIVERED) {
            return $lead;
        }

        $result = $this->destination->deliver($lead);
        $lead->delivery_attempts++;
        $lead->destination = $this->destination->name();

        if ($result->delivered) {
            $lead->status = LeadSubmission::STATUS_DELIVERED;
            $lead->external_reference = $result->externalReference;
            $lead->delivered_at = now();
            $lead->last_error = null;
        } elseif ($result->retryable && $lead->delivery_attempts < $maxAttempts) {
            $lead->status = LeadSubmission::STATUS_QUEUED;
            $lead->last_error = $result->error;
        } else {
            // Never silently discarded: failed leads remain for staff follow-up.
            $lead->status = LeadSubmission::STATUS_FAILED;
            $lead->last_error = $result->error;
        }

        $lead->save();

        return $lead;
    }
}
