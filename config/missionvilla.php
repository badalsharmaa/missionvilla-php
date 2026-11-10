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

    /*
    | Shared inquiry form. WEBSITE-WIDE RULE (2026-11-10): every CTA whose
    | destination is a form opens the shared inquiry modal
    | (components/inquiry/dialog) with an intent preselected; it never scrolls
    | to a form section. Mark such CTAs with data-inquiry="<intent>" (canonical
    | key or alias below) and give them a tel: href as the no-JavaScript fallback.
    |
    | One form, one endpoint (POST /inquiries), one intent field. Submissions are
    | stored in the lead_submissions outbox. They are only "delivered" once a
    | real LeadDestination (Synergy Hub) confirms them; until then the visitor
    | is told plainly that the request was saved but not sent.
    */
    'inquiries' => [
        // false = the form never posts; it shows a "design preview, nothing was sent" notice instead.
        'store' => env('INQUIRIES_STORE', true),
        // Bumped whenever the consent wording in the form changes (stored with each lead).
        'consent_version' => 'inquiry-consent-2026-11-10',
        // Canonical intents. `kind` is the lead type stored in lead_submissions (and later sent to
        // Synergy Hub); `label` is the "How can we help?" option; title/lede/submit are the modal copy.
        // Order = order of the "How can we help?" options.
        'intents' => [
            'schedule_visit' => [
                'kind' => 'visit_request', 'label' => 'Schedule a visit',
                'title' => 'Schedule a Visit at Mission Villa',
                'lede' => 'Tell us how to reach you and when suits you. We’ll arrange a time to walk through Mission Villa and meet the care team.',
                'submit' => 'Request a Visit',
            ],
            'request_pricing' => [
                'kind' => 'pricing_request', 'label' => 'Request pricing',
                'title' => 'Request Pricing & Availability',
                'lede' => 'Pricing depends on care needs and suite type, so our team shares it with you personally. Tell us how to reach you.',
                'submit' => 'Request Pricing',
            ],
            'request_availability' => [
                'kind' => 'availability_request', 'label' => 'Ask about suites & availability',
                'title' => 'Ask About Suites & Availability',
                'lede' => 'Our team can tell you which private and shared suites are open and share floor plans. Tell us how to reach you.',
                'submit' => 'Ask About Suites',
            ],
            'request_callback' => [
                'kind' => 'callback_request', 'label' => 'Request a call',
                'title' => 'Request a Call From Our Team',
                'lede' => 'Leave your number and a good time to call. A member of our Daly City team can answer your questions.',
                'submit' => 'Request a Call',
            ],
            'general_inquiry' => [
                'kind' => 'general_inquiry', 'label' => 'Ask a general question',
                'title' => 'How Can We Help Your Family?',
                'lede' => 'Tell us how to reach you and what you’d like to know. A member of our team will be in touch.',
                'submit' => 'Send Request',
            ],
        ],
        // Short names accepted by data-inquiry="…" (the brief's intent vocabulary).
        'intent_aliases' => [
            'visit' => 'schedule_visit',
            'pricing' => 'request_pricing',
            'availability' => 'request_availability',
            'callback' => 'request_callback',
            'general' => 'general_inquiry',
        ],
        // Non-sensitive context: which part of the site opened the form (stored with the lead).
        'sources' => ['header', 'hero', 'care-options', 'life-gallery', 'why-families', 'suites', 'faq', 'visit-cta', 'visit-form', 'footer', 'mc-hero', 'mc-legacies', 'mc-day', 'mc-care', 'mc-faq', 'mc-cta', 'memory-care'],
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
