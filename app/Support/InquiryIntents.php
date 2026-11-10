<?php

namespace App\Support;

/**
 * The one vocabulary of inquiry intents (config/missionvilla.php → inquiries.intents).
 *
 * Content and markup may use a canonical key ("request_pricing") or a short
 * alias ("pricing"); everything is resolved to the canonical key before it
 * reaches the page, the form or the lead outbox.
 */
final class InquiryIntents
{
    /** @return list<string> canonical intent keys, in display order */
    public static function keys(): array
    {
        return array_keys(config('missionvilla.inquiries.intents'));
    }

    /** @return list<string> every accepted spelling (canonical keys + aliases) */
    public static function accepted(): array
    {
        return [...self::keys(), ...array_keys(config('missionvilla.inquiries.intent_aliases'))];
    }

    public static function resolve(?string $intent): ?string
    {
        if ($intent === null) {
            return null;
        }
        $intent = config('missionvilla.inquiries.intent_aliases')[$intent] ?? $intent;

        return in_array($intent, self::keys(), true) ? $intent : null;
    }

    /** @return list<string> */
    public static function sources(): array
    {
        return config('missionvilla.inquiries.sources');
    }
}
