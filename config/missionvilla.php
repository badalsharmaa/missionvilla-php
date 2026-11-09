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
    | Content source for public pages: "file" (content/pages/*.php, reviewed
    | in git) or "database" (CMS tables). Phase 1 ships with "file".
    */
    'content_source' => env('CONTENT_SOURCE', 'file'),
];
