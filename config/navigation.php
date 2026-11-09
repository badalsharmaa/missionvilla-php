<?php

/*
|--------------------------------------------------------------------------
| Primary navigation
|--------------------------------------------------------------------------
| Mirrors the React design reference (components/HeaderAndUtilityBar.tsx).
| Becomes CMS-managed (menus table) in a later phase; the header component
| only consumes this array shape, so the source can change without
| touching presentation code.
|
| Prototype-only entries from the React reference (brochure placeholder,
| blog inventory audit) are intentionally omitted.
*/

return [
    'primary' => [
        ['label' => 'Home', 'href' => '/'],
        [
            'label' => 'Living Options',
            'href' => '/living-options',
            'children' => [
                ['label' => 'Living Options Overview', 'href' => '/living-options', 'description' => 'Compare Memory Care vs. Respite Care & suites'],
                ['label' => 'Memory Care', 'href' => '/memory-care', 'description' => 'Legacies™ Alzheimer’s & dementia support'],
                ['label' => 'Respite Care', 'href' => '/respite-care', 'description' => 'Short-term stays & caregiver relief'],
                ['label' => 'Suites & Floor Plans', 'href' => '/suites-and-floor-plans', 'description' => 'Private, Companion & Jack & Jill suites'],
                ['label' => 'Financial Planning', 'href' => '/financial-planning', 'description' => 'Cost factors & what may be included'],
                ['label' => 'For Families & FAQs', 'href' => '/for-families', 'description' => 'Decision guide, visit questions & FAQs'],
            ],
        ],
        ['label' => 'Memory Care', 'href' => '/memory-care'],
        ['label' => 'Respite Care', 'href' => '/respite-care'],
        [
            'label' => 'Life at Mission Villa',
            'href' => '/life-at-mission-villa',
            'children' => [
                ['label' => 'Life at Mission Villa', 'href' => '/life-at-mission-villa', 'description' => 'Daily culture, dining, activities & belonging'],
                ['label' => 'Services & Amenities', 'href' => '/services-and-amenities', 'description' => '24-hour staff, dining, spaces & convenience'],
                ['label' => 'Gallery & Virtual Tour', 'href' => '/gallery', 'description' => 'Rooms, dining, lounges & gardens'],
            ],
        ],
        ['label' => 'About', 'href' => '/about'],
        [
            'label' => 'Resources',
            'href' => '/resources',
            'children' => [
                ['label' => 'Resources Overview', 'href' => '/resources', 'description' => 'Planning guides for families'],
                ['label' => 'Financial Planning', 'href' => '/financial-planning', 'description' => 'Cost factors & what may be included'],
                ['label' => 'For Families & FAQs', 'href' => '/for-families', 'description' => 'Decision guide, visit questions & FAQs'],
            ],
        ],
        ['label' => 'For Families & FAQs', 'href' => '/for-families'],
        ['label' => 'Contact', 'href' => '/contact'],
    ],
];
