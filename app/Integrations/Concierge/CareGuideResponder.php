<?php

namespace App\Integrations\Concierge;

/**
 * Future server-side boundary for the Care Guide (Hiraya Bridge).
 *
 * Phase 1: NOT implemented on the server. The hero ships the approved
 * scripted preview in resources/js/sections/hero-cinematic.js
 * (getCareGuideReply), clearly labelled as a design preview, not live AI.
 *
 * A Hiraya Bridge adapter will implement this interface and be called from
 * a rate-limited, CSRF-protected endpoint. Responses must come from approved
 * Mission Villa content, must not diagnose or give clinical advice, and must
 * always offer a human handoff (phone / visit request).
 */
interface CareGuideResponder
{
    /**
     * @param  list<array{role: 'visitor'|'assistant', text: string}>  $history  Only with visitor consent.
     * @return array{reply: string, handoff_suggested: bool, source: string}
     */
    public function respond(string $question, array $history = []): array;
}
