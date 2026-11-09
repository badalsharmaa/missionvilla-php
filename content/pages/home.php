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
            // Opening scene from the React reference (components/ConservatoryShutters.tsx).
            'key' => 'intro',
            'type' => 'intro.shutters',
            'enabled' => true,
            'data' => [
                'left_script' => 'A Place to Belong',
                'left_kicker' => 'Mission Villa',
                'left_tagline' => '“The honor they deserve,”',
                'left_footer' => 'Dignity · Connection · Purpose',
                'right_top' => 'Daly City, California',
                'right_kicker' => 'Senior Living',
                'right_tagline' => '“the care you’ll love.”',
                'right_footer' => 'Memory Care · Respite Care',
                'skip_label' => 'Skip Intro',
            ],
        ],
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
        [
            // Section 02, approved mockups (2026-11-09): default front faces +
            // hover-flipped Memory Care card. Copy condensed from the React
            // reference CareOptionsSection / CARE_PROGRAMS (lib/mission-villa-data.ts).
            'key' => 'care-options',
            'type' => 'care.options',
            'enabled' => true,
            'data' => [
                'eyebrow' => 'Our Care Options',
                'heading' => 'Two Paths. <em>One Commitment to Care.</em>',
                'subheading' => 'Specialized care and short-term support, all in a welcoming residential setting in Daly City.',
                'cards' => [
                    [
                        'id' => 'memory-care',
                        'icon' => 'brain',
                        'kicker' => 'Legacies™',
                        'title' => 'Memory Care',
                        'summary' => 'Specialized, personalized support for seniors living with Alzheimer’s disease and other forms of dementia.',
                        'image' => [
                            'src' => '/images/care/memory-care-companion-1122.webp',
                            'src_mobile' => '/images/care/memory-care-companion-720.webp',
                            'alt' => 'An older woman folding linen napkins at a dining table while a caregiver sits beside her and smiles',
                            'provenance' => 'illustrative',
                            'source_url' => null,
                            'position' => '50% 26%',
                        ],
                        'cta' => ['label' => 'Explore Memory Care', 'href' => '/memory-care', 'style' => 'terracotta'],
                        'back' => [
                            'kicker' => 'Legacies™ Memory Care',
                            'statement' => 'Specialized, personalized support for seniors living with Alzheimer’s disease and other forms of dementia.',
                            'benefits' => [
                                ['icon' => 'brain', 'text' => 'Care built around each life story and routine'],
                                ['icon' => 'heart', 'text' => 'Calm, predictable rhythms that feel familiar'],
                                ['icon' => 'people', 'text' => 'Compassionate support that preserves dignity'],
                            ],
                            'audience_label' => 'Who this supports',
                            'audience' => 'Seniors living with Alzheimer’s disease or other forms of dementia.',
                        ],
                    ],
                    [
                        'id' => 'respite-care',
                        'icon' => 'calendar',
                        'kicker' => 'Short-Term Stays',
                        'title' => 'Respite Care',
                        'summary' => 'A welcoming short-term stay that provides caring support and gives family caregivers peace of mind.',
                        'image' => [
                            'src' => '/images/care/respite-care-welcome-1402.webp',
                            'src_mobile' => '/images/care/respite-care-welcome-900.webp',
                            'alt' => 'An older woman placing a family photo on a dresser in a bright suite while her daughter embraces her',
                            'provenance' => 'illustrative',
                            'source_url' => null,
                            'position' => '72% 40%',
                        ],
                        'cta' => ['label' => 'Explore Respite Care', 'href' => '/respite-care', 'style' => 'cream'],
                        'back' => [
                            'kicker' => 'Short-Term Respite Care',
                            'statement' => 'Welcoming short-term support in the same compassionate, homelike Daly City community.',
                            'benefits' => [
                                ['icon' => 'bed', 'text' => 'A comfortable suite with a private bathroom'],
                                ['icon' => 'dining', 'text' => 'Chef-prepared meals and daily activities'],
                                ['icon' => 'hands', 'text' => 'Personal attention from our care team'],
                            ],
                            'audience_label' => 'Who this supports',
                            'audience' => 'Families who need a short-term stay while a caregiver rests or travels.',
                        ],
                    ],
                ],
                'visit_cta' => 'Schedule a Visit',
                'care_guide_cta' => 'Not sure which fits? Ask our Care Guide',
            ],
        ],
        [
            // Section 03, approved mockup (2026-11-09) "Life at Mission Villa: A Closer Look".
            // Copy condensed from verified React content (lib/mission-villa-data.ts:
            // suites, dining, daily engagement, Legacies™ life-story approach).
            // Films are produced separately: docs/SECTION_03_VIDEO_CONTRACT.md.
            // Until they arrive each chapter shows its fallback still with an
            // honest "film in production" state.
            'key' => 'life-gallery',
            'type' => 'life.gallery',
            'enabled' => true,
            'data' => [
                'eyebrow' => 'Life at Mission Villa',
                'heading' => 'A Closer Look at <em>Life Here</em>',
                'subheading' => 'A welcoming community designed for comfort, engagement, and meaningful connection.',
                'manifest' => '/media/mission-villa/life-at-mission-villa/media-manifest.json',
                'chapters' => [
                    [
                        'id' => 'living-spaces',
                        'icon' => 'home',
                        'label' => 'Living Spaces',
                        'kicker' => 'Living Spaces',
                        'title' => 'Comfortable, Private, and Peaceful',
                        'description' => 'Private and shared suites, each with a private bathroom, plus inviting lounges where residents relax and families visit.',
                        'cta' => ['label' => 'Explore Our Suites', 'href' => '/suites-and-floor-plans', 'fallback_label' => 'See Our Suites in Person'],
                        'media' => ['manifest_id' => 'living-spaces'],
                        'fallback_poster' => [
                            'src' => '/images/life/living-spaces-illustrative-1145.webp',
                            'src_mobile' => '/images/life/living-spaces-illustrative-960.webp',
                            'alt' => 'An older man reading in an armchair beside sunlit garden doors, a dog resting at his feet',
                            'provenance' => 'illustrative',
                            'position' => '50% 40%',
                        ],
                    ],
                    [
                        'id' => 'dining-daily-life',
                        'icon' => 'dining',
                        'label' => 'Dining & Daily Life',
                        'kicker' => 'Dining & Daily Life',
                        'title' => 'Everyday Moments That Matter',
                        'description' => 'Chef-prepared meals shared in a welcoming dining room, with group and one-on-one activities woven through each day.',
                        'cta' => ['label' => 'Explore Daily Life', 'href' => '/life-at-mission-villa', 'fallback_label' => 'See Daily Life in Person'],
                        'media' => ['manifest_id' => 'dining-daily-life'],
                        'fallback_poster' => [
                            'src' => '/images/life/dining-daily-life-illustrative-1672.webp',
                            'src_mobile' => '/images/life/dining-daily-life-illustrative-960.webp',
                            'alt' => 'Three older adults sharing a meal at a dining table while a smiling server brings a plate',
                            'provenance' => 'illustrative',
                            'position' => '50% 50%',
                        ],
                    ],
                    [
                        'id' => 'meaningful-connection',
                        'icon' => 'people',
                        'label' => 'Meaningful Connection',
                        'kicker' => 'Meaningful Connection',
                        'title' => 'Connection Makes a Place Feel Like Home',
                        'description' => 'Care shaped around each resident’s life story, with music, reminiscence, and comfortable spaces for family visits.',
                        'cta' => ['label' => 'Explore Memory Care', 'href' => '/memory-care', 'fallback_label' => 'Meet Our Care Team'],
                        'media' => ['manifest_id' => 'meaningful-connection'],
                        'fallback_poster' => [
                            'src' => '/images/life/meaningful-connection-illustrative-1402.webp',
                            'src_mobile' => '/images/life/meaningful-connection-illustrative-960.webp',
                            'alt' => 'An older woman and a younger woman talking warmly in armchairs in a bright lounge',
                            'provenance' => 'illustrative',
                            'position' => '50% 50%',
                        ],
                    ],
                ],
                'labels' => [
                    'illustrative_video' => 'Illustrative film · not actual residents or facility',
                    'illustrative_image' => 'Illustrative image · not actual residents',
                    'facility_video' => 'Filmed at Mission Villa',
                    'facility_image' => 'Mission Villa property photo',
                    'unavailable' => 'Film in production',
                    'unavailable_detail' => 'This chapter’s short film is in production. A preview image is shown for now.',
                ],
                'visit_cta' => 'Schedule a Visit',
                'care_guide_cta' => 'Questions? Ask our Care Guide',
            ],
        ],
        // Future approved sections are appended here (see docs/SECTION_STATUS.md).
    ],
];
