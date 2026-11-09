<?php

/*
|--------------------------------------------------------------------------
| Homepage content (Phase 1 source of truth)
|--------------------------------------------------------------------------
| Ordered list of approved sections. Each entry is validated by its section
| schema (app/Content/Sections) before rendering. Only add a section here
| after it is approved in docs/SECTION_STATUS.md.
|
| Hero copy is reproduced verbatim from the approved prototype
| mission_villa_cinematic_hero_final.html.
*/

return [
    'slug' => 'home',
    'seo' => [
        'title' => 'Mission Villa Senior Living — Memory Care & Respite Care in Daly City, CA',
        'description' => 'Legacies™ Memory Care and Short-Term Respite Care in an unhurried, residential community at 995 East Market Street, Daly City, CA. Call (650) 756-1995 to schedule a visit.',
        'og_image' => '/images/hero/family-connection-1200.webp',
    ],
    'sections' => [
        [
            'key' => 'hero',
            'type' => 'hero.cinematic',
            'enabled' => true,
            'data' => [
                'autoplay_seconds' => 6.0,
                'slides' => [
                    [
                        'eyebrow' => 'Chapter 01 · Welcome to Mission Villa',
                        'line1' => 'A calm, trusted home',
                        'line2' => 'where <em>your loved one</em>',
                        'line3' => 'is genuinely known.',
                        'body' => 'At Mission Villa Senior Living in Daly City, specialized <strong>Legacies™ Memory Care</strong> and flexible <strong>Short-Term Respite Care</strong> come together in an unhurried, residential community—supporting your family with warmth, clarity, and respect.',
                        'cta' => 'Schedule a Visit',
                        'chapter_title' => 'Welcome to Mission Villa',
                        'chapter_subtitle' => 'Memory Care & Respite in Daly City',
                        'image' => [
                            'src' => '/images/hero/family-connection-2000.webp',
                            'src_mobile' => '/images/hero/family-connection-1200.webp',
                            'alt' => 'A senior mother and adult daughter laughing together on a sofa in a welcoming home',
                            'fallback_label' => 'Mission Villa · A Place to Belong',
                            'provenance' => 'illustrative',
                            'source_url' => 'https://www.pexels.com/photo/elderly-woman-and-young-woman-laughing-together-7232037/',
                        ],
                    ],
                    [
                        'eyebrow' => 'Chapter 02 · Legacies™ Memory Care',
                        'line1' => 'When memory changes,',
                        'line2' => '<em>dignity and rhythm</em>',
                        'line3' => 'remain at the center.',
                        'body' => 'Our <strong>Legacies™ Memory Care</strong> neighborhood honors your loved one’s personal history, familiar daily routines, and meaningful human connection—creating calm, reassuring days in the heart of Daly City.',
                        'cta' => 'Schedule a Memory Care Visit',
                        'chapter_title' => 'Legacies™ Memory Care',
                        'chapter_subtitle' => 'Dignity, familiar routines & connection',
                        'image' => [
                            'src' => '/images/hero/memory-care-conversation-2000.webp',
                            'src_mobile' => '/images/hero/memory-care-conversation-1200.webp',
                            'alt' => 'Two older women enjoying a warm conversation in a comfortable living room',
                            'fallback_label' => 'Legacies™ Memory Care',
                            'provenance' => 'illustrative',
                            'source_url' => 'https://www.pexels.com/photo/two-elderly-woman-talking-to-each-other-while-sitting-on-a-couch-6941661/',
                        ],
                    ],
                    [
                        'eyebrow' => 'Chapter 03 · Short-Term Respite Care',
                        'line1' => 'Trusted short-term care,',
                        'line2' => '<em>peace of mind</em> for',
                        'line3' => 'family caregivers.',
                        'body' => 'Whether you need time to rest, travel, or recover, <strong>Short-Term Respite Care</strong> at Mission Villa welcomes your loved one into a warm, attentive residential community at 995 East Market Street.',
                        'cta' => 'Inquire About Respite Stays',
                        'chapter_title' => 'Short-Term Respite Care',
                        'chapter_subtitle' => 'Trusted support for family caregivers',
                        'image' => [
                            'src' => '/images/hero/respite-quiet-reading-2000.webp',
                            'src_mobile' => '/images/hero/respite-quiet-reading-1200.webp',
                            'alt' => 'An older woman enjoying a quiet moment reading at home with her dog nearby',
                            'fallback_label' => 'Short-Term Respite Care',
                            'provenance' => 'illustrative',
                            'source_url' => 'https://www.pexels.com/photo/elderly-woman-reading-book-at-home-10117260/',
                        ],
                    ],
                ],
                'care_guide' => [
                    'kicker' => 'A thoughtful place to begin',
                    'brand' => 'Mission Villa Care Guide',
                    'tag' => 'PREVIEW',
                    'title' => 'How can we help your family today?',
                    'description' => 'Explore care options, ask a question, or arrange a visit. Start wherever feels comfortable.',
                    'choices' => [
                        ['label' => 'Explore Memory Care', 'question' => 'What does Legacies Memory Care offer?'],
                        ['label' => 'Understand Respite Care', 'question' => 'How does Short-Term Respite Care work?'],
                        ['label' => "I'm not sure where to begin", 'question' => 'I am not sure where to begin.'],
                    ],
                    'placeholder' => 'Or ask your own question…',
                    'footnote' => 'Guided demo, not live chat · No contact details required',
                ],
            ],
        ],
        // Future approved sections are appended here (see docs/SECTION_STATUS.md).
    ],
];
