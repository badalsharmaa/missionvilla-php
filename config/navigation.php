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
    /*
    | Global footer (resources/views/components/site/footer.blade.php).
    | Structure mirrors the React reference footer (components/VisitAndFooterSection.tsx):
    | brand + description, care offerings, site links, location & contact, legal bar.
    |
    | Link safety: internal pages are built in PHP one at a time. Each link names its
    | real destination (`href`) and an optional `fallback` that already exists
    | (a homepage section anchor). App\Support\FooterNavigation renders `href` once
    | that route exists, otherwise `fallback` (with `fallback_label` if set), otherwise drops the link. So the footer
    | never exposes a 404 and upgrades itself as pages ship. Legal links have no
    | fallback: they appear only once a real page exists.
    */
    'footer' => [
        'description' => 'Compassionate, personalized Memory Care and short-term Respite Care in a welcoming, homelike Daly City community.',
        'logo' => [
            'src' => '/images/brand/mission-villa-logo-honor-560.webp',
            'width' => 560,
            'height' => 417,
            'alt' => 'Mission Villa Senior Living. The honor they deserve, the care you’ll love.',
        ],
        // Social profiles. PLACEHOLDER '#' links until the client supplies the real profile URLs.
        'social' => [
            ['label' => 'Facebook', 'icon' => 'facebook', 'href' => '#'],
            ['label' => 'Instagram', 'icon' => 'instagram', 'href' => '#'],
            ['label' => 'LinkedIn', 'icon' => 'linkedin', 'href' => '#'],
        ],
        'groups' => [
            [
                'title' => 'Care & Living',
                'links' => [
                    ['label' => 'Legacies™ Memory Care', 'href' => '/memory-care', 'fallback' => '/#care-options'],
                    ['label' => 'Short-Term Respite Care', 'href' => '/respite-care', 'fallback' => '/#care-options'],
                    ['label' => 'Suites & Floor Plans', 'href' => '/suites-and-floor-plans', 'fallback' => '/#suites', 'fallback_label' => 'Suites & Living Spaces'],
                    ['label' => 'Life at Mission Villa', 'href' => '/life-at-mission-villa', 'fallback' => '/#life-at-mission-villa'],
                ],
            ],
            [
                'title' => 'Explore',
                'links' => [
                    ['label' => 'Why Families Choose Us', 'href' => '/about', 'fallback' => '/#why-families'],
                    ['label' => 'For Families & FAQs', 'href' => '/for-families', 'fallback' => '/#faq', 'fallback_label' => 'Family FAQs'],
                    ['label' => 'Financial Planning', 'href' => '/financial-planning'],
                    ['label' => 'Gallery & Virtual Tour', 'href' => '/gallery'],
                    ['label' => 'Contact & Visits', 'href' => '/contact', 'fallback' => '/#visit', 'fallback_label' => 'Visit & Contact'],
                ],
            ],
        ],
        'legal' => [
            ['label' => 'Privacy Policy', 'href' => '/privacy-policy'],
            ['label' => 'Accessibility Statement', 'href' => '/accessibility'],
        ],
    ],
];
