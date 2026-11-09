<?php

/*
|--------------------------------------------------------------------------
| Mission Villa verified business facts
|--------------------------------------------------------------------------
| Single source for facts repeated across templates. These become
| CMS-managed "site settings" once the admin is built; until then they
| are code-reviewed here. Only verified values belong in this file.
*/

return [
    'name' => 'Mission Villa Senior Living',
    'short_name' => 'Mission Villa',
    'locality' => 'Daly City, California',

    'address' => [
        'street' => '995 East Market Street',
        'street_short' => '995 East Market St',
        'city' => 'Daly City',
        'region' => 'CA',
        'postal_code' => '94014',
    ],

    'phone' => [
        'display' => '(650) 756-1995',
        'href' => 'tel:16507561995',
    ],

    'license' => [
        'label' => 'CA RCFE License',
        'number' => '415601046',
    ],

    'programs' => [
        'memory_care' => 'Legacies™ Memory Care',
        'respite_care' => 'Short-Term Respite Care',
    ],

    // Where "Schedule a Visit" links when no on-page visit dialog exists.
    'visit_url' => '/contact#schedule-visit',

    /*
    | Shared inquiry form (Schedule a Visit · Request Pricing · Request a Call).
    | One form, one endpoint (POST /inquiries), one intent field. Submissions are
    | stored in the lead_submissions outbox. They are only "delivered" once a
    | real LeadDestination (Synergy Hub) confirms them; until then the visitor
    | is told plainly that the request was saved but not sent.
    */
    'inquiries' => [
        // false = the form never posts; it shows a "design preview, nothing was sent" notice instead.
        'store' => env('INQUIRIES_STORE', true),
        // Bumped whenever the consent wording in the form changes (stored with each lead).
        'consent_version' => 'inquiry-consent-2026-11-09',
        'intents' => [
            'schedule_visit' => ['kind' => 'visit_request', 'label' => 'Schedule a Visit'],
            'request_pricing' => ['kind' => 'pricing_request', 'label' => 'Request Pricing'],
            'request_callback' => ['kind' => 'callback_request', 'label' => 'Request a Call'],
        ],
        'care_interests' => [
            'memory_care' => 'Legacies™ Memory Care',
            'respite_care' => 'Short-Term Respite Care',
            'exploring' => 'Exploring options',
        ],
        'suite_preferences' => [
            'private' => 'Private suite',
            'shared' => 'Shared companion suite',
            'undecided' => 'Not sure yet',
        ],
        'contact_times' => [
            'weekday_morning' => 'Weekday morning',
            'weekday_afternoon' => 'Weekday afternoon',
            'weekend' => 'Weekend',
            'any' => 'Any time',
        ],
        // Per-IP limits for POST /inquiries.
        'per_minute' => 5,
        'per_day' => 20,
    ],

    /*
    | Content source for public pages: "file" (content/pages/*.php, reviewed
    | in git) or "database" (CMS tables). Phase 1 ships with "file".
    */
    'content_source' => env('CONTENT_SOURCE', 'file'),
];
