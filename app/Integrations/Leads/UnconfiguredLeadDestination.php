<?php

namespace App\Integrations\Leads;

use App\Models\LeadSubmission;

/**
 * Default destination until the Synergy Hub contract is verified.
 * It never claims delivery: leads stay in the outbox as not delivered.
 */
final class UnconfiguredLeadDestination implements LeadDestination
{
    public function name(): string
    {
        return 'unconfigured';
    }

    public function deliver(LeadSubmission $lead): DeliveryResult
    {
        return DeliveryResult::retryLater('No lead destination configured (Synergy Hub integration pending).');
    }
}
