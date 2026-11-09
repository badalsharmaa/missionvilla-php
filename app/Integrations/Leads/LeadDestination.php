<?php

namespace App\Integrations\Leads;

use App\Models\LeadSubmission;

/**
 * Adapter boundary between the website and any lead receiver (Synergy Hub).
 *
 * Implementations translate a stored LeadSubmission into the receiver's
 * documented API. They must return delivered=true ONLY when the receiver has
 * confirmed acceptance, and must never be called from browser code.
 */
interface LeadDestination
{
    /** Short identifier stored on the submission, e.g. "synergyhub". */
    public function name(): string;

    public function deliver(LeadSubmission $lead): DeliveryResult;
}
