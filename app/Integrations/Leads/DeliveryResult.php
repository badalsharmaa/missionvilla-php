<?php

namespace App\Integrations\Leads;

final class DeliveryResult
{
    private function __construct(
        public readonly bool $delivered,
        public readonly bool $retryable,
        public readonly ?string $externalReference = null,
        public readonly ?string $error = null,
    ) {}

    /** The receiver confirmed acceptance and returned its reference. */
    public static function confirmed(string $externalReference): self
    {
        return new self(true, false, $externalReference);
    }

    /** Temporary failure (timeout, 5xx, rate limit): keep the lead and retry. */
    public static function retryLater(string $error): self
    {
        return new self(false, true, null, $error);
    }

    /** Permanent rejection (validation, auth): keep the lead, alert staff, do not retry. */
    public static function rejected(string $error): self
    {
        return new self(false, false, null, $error);
    }
}
