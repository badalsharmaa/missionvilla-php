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
        [
            // Section 04, approved mockup "A Trusted Partner in Care" (2026-11-09).
            // Replaces React's ApproachAndLifeSection. Facts and values are condensed
            // from verified React content (lib/mission-villa-data.ts: APPROACH_PILLARS,
            // CARE_PROGRAMS, visit copy) and config/missionvilla.php. No awards,
            // ratings, staffing claims or outcomes.
            'key' => 'why-families',
            'type' => 'trust.why-families',
            'enabled' => true,
            'data' => [
                'eyebrow' => 'Why Families Choose Mission Villa',
                'heading' => 'A Trusted Partner in Your Family’s <em>Next Chapter</em>',
                'body' => 'At Mission Villa, we believe meaningful care begins with understanding each individual. Our Daly City community offers a welcoming setting where personal histories, familiar routines, and family connections are valued.',
                'image' => [
                    // Authentic Mission Villa courtyard (same photo as React's Approach section).
                    // Retrieved from Mission Villa's public provider listing on PurpleDoor Finders
                    // (docs/image-sourcing-report.md). Publication rights not yet confirmed by the client.
                    'src' => '/images/why-families/courtyard-patio-facility-1024.webp',
                    'src_mobile' => '/images/why-families/courtyard-patio-facility-768.webp',
                    'alt' => 'The Mission Villa courtyard patio: a blue umbrella over wrought-iron tables, cushioned chairs and shade trees beside the dining room doors',
                    'provenance' => 'facility',
                    'source_url' => 'https://d3ep5zm82rva6t.cloudfront.net/provider-portal/location-images/d11kigwsmsmei1q1zoyo.jpg',
                    'rights' => 'unconfirmed',
                    'position' => '50% 30%',
                    'caption' => 'Our courtyard patio · Daly City',
                ],
                'primary_cta' => ['label' => 'Schedule a Visit', 'intent' => 'schedule_visit'],
                'tour_cta' => [
                    'label' => 'Take a Quick Tour',
                    'href' => '#life-at-mission-villa',
                    // While no Section 03 film is available, the CTA reads as a preview, not a working tour.
                    'manifest' => '/media/mission-villa/life-at-mission-villa/media-manifest.json',
                    'pending_note' => 'Films in production',
                ],
                'glance' => [
                    'kicker' => 'Mission Villa',
                    'title' => 'At a Glance',
                    'facts' => [
                        ['icon' => 'pin', 'title' => 'Daly City, California', 'text' => 'Residential community at 995 East Market Street.'],
                        ['icon' => 'hands', 'title' => 'Two Focused Care Options', 'text' => 'Legacies™ Memory Care and Short-Term Respite Care.'],
                        ['icon' => 'book-heart', 'title' => 'A Personal Approach', 'text' => 'Respect for individual history, familiar routines, and personal preferences.'],
                        ['icon' => 'messages', 'title' => 'Everyday Connection', 'text' => 'A welcoming environment emphasizing meaningful relationships and daily life.'],
                    ],
                ],
                'values' => [
                    ['icon' => 'heart', 'title' => 'Personalized Care', 'text' => 'Support shaped around each person’s story and preferences.'],
                    ['icon' => 'people', 'title' => 'People & Family', 'text' => 'Open, approachable communication with loved ones.'],
                    ['icon' => 'heart-handshake', 'title' => 'Dignity & Respect', 'text' => 'Independence encouraged, privacy and rhythms honored.'],
                    ['icon' => 'sprout', 'title' => 'Support Through Every Step', 'text' => 'Clear, pressure-free guidance for families.'],
                ],
            ],
        ],
        [
            // Section 05. Approved mockup "Mission Villa Suites, FAQ & Visits" (top band, corrected 2026-11-10).
            // Copy condensed from React LIVING_SPACE_OPTIONS (lib/mission-villa-data.ts). Images are authentic
            // Mission Villa photos / current-site artwork (docs/image-sourcing-report.md); reuse rights unconfirmed.
            'key' => 'suites',
            'type' => 'living.suites',
            'enabled' => true,
            'data' => [
                'eyebrow' => 'Suites & Living Spaces',
                'heading' => 'Comfortable Suites & <em>Welcoming Spaces</em>',
                'intro' => 'Thoughtfully designed accommodations and inviting communal spaces create a sense of comfort, familiarity, and belonging at Mission Villa.',
                // Two actions below the composition (approved mockup 2026-11-10). A page link is used only once
                // its page is routed; until then the fallback opens the shared inquiry modal (never a 404).
                // Form actions open the modal; the pricing action also preselects the selected suite.
                'actions' => [
                    [
                        'label' => 'View Suite & Floor Plans',
                        'href' => '/suites-and-floor-plans',
                        'fallback_label' => 'Request Suite Floor Plans',
                        'fallback_intent' => 'availability',
                        'style' => 'secondary',
                    ],
                    [
                        'label' => 'Request Availability & Pricing',
                        'intent' => 'pricing',
                        'icon' => 'calendar',
                        'style' => 'primary',
                    ],
                ],
                'options' => [
                    [
                        'id' => 'private',
                        'label' => 'Private Suites',
                        'icon' => 'bed',
                        'kicker' => 'Private Suites',
                        'caption' => 'A personal space to feel at home.',
                        'image' => [
                            'src' => '/images/suites/suite-bedroom-facility-899.webp',
                            'src_mobile' => '/images/suites/suite-bedroom-facility-640.webp',
                            'width' => 899,
                            'height' => 601,
                            'alt' => 'A furnished bedroom at Mission Villa with a made bed, armchair and a bright window',
                            'provenance' => 'facility',
                            'source_url' => 'https://d13iq96prksfh0.cloudfront.net/cdn/photos/430909/900x675',
                            'rights' => 'unconfirmed',
                            'label' => 'Mission Villa photo',
                            'fit' => 'cover',
                            'position' => '50% 55%',
                        ],
                    ],
                    [
                        'id' => 'shared',
                        'label' => 'Shared Suites',
                        'icon' => 'people',
                        'kicker' => 'Shared Suites',
                        'caption' => 'Companionship, with space of your own.',
                        'image' => [
                            'src' => '/images/suites/companion-suite-floorplan-1000.webp',
                            'src_mobile' => '/images/suites/companion-suite-floorplan-640.webp',
                            'width' => 1000,
                            'height' => 660,
                            'alt' => 'Floor plan of a Mission Villa companion suite: two beds in a shared room with an attached private bathroom',
                            'provenance' => 'facility',
                            'source_url' => 'https://missionvillaseniorliving.com/wp-content/uploads/2025/08/Companion-Unit-1-1.webp',
                            'rights' => 'unconfirmed',
                            'label' => 'Companion suite floor plan',
                            'fit' => 'contain',
                        ],
                    ],
                    [
                        'id' => 'community',
                        'label' => 'Community Spaces',
                        'icon' => 'armchair',
                        'kicker' => 'Community Spaces',
                        'caption' => 'Places to gather, dine and visit.',
                        'image' => [
                            'src' => '/images/suites/community-lounge-facility-899.webp',
                            'src_mobile' => '/images/suites/community-lounge-facility-640.webp',
                            'width' => 899,
                            'height' => 601,
                            'alt' => 'The Mission Villa community lounge with armchairs, a sofa, table lamps and artwork',
                            'provenance' => 'facility',
                            'source_url' => 'https://d13iq96prksfh0.cloudfront.net/cdn/photos/430903/900x675',
                            'rights' => 'unconfirmed',
                            'label' => 'Mission Villa photo',
                            'fit' => 'cover',
                            'position' => '50% 50%',
                        ],
                    ],
                ],
            ],
        ],
        [
            // Section 06. Approved mockup (middle band, corrected 2026-11-10). Answer actions open the inquiry modal. Answers condensed from verified React content:
            // FAMILY_FAQS (SuitesAndFamilySection), LIVING_SPACE_OPTIONS, respite + pricing FAQs in lib/mission-villa-data.ts.
            'key' => 'faq',
            'type' => 'faq.featured',
            'enabled' => true,
            'data' => [
                'eyebrow' => 'Frequently Asked Questions',
                'heading' => 'Questions Families Often Ask',
                'intro' => 'Get quick answers to common questions about care, accommodations, and visiting Mission Villa.',
                // Shown only once /for-families is built in PHP.
                'all_link' => ['label' => 'View All FAQs', 'href' => '/for-families'],
                'entries' => [
                    [
                        'id' => 'legacies-memory-care',
                        'question' => 'What is included in the Legacies™ Memory Care program?',
                        'answer' => 'Our Legacies™ Memory Care program focuses on honoring each resident’s life story, personal preferences, and sense of dignity. By learning about each resident’s background, family connections, and comforting routines, our team provides compassionate daily support tailored to the individual.',
                        'icon' => 'sprout',
                        'order' => 10,
                        'enabled' => true,
                        'featured' => true,
                    ],
                    [
                        'id' => 'respite-stay',
                        'question' => 'Can we arrange a short-term Respite Care stay?',
                        'answer' => 'Yes. Short-Term Respite Care offers a supportive stay when a family caregiver needs time to rest, travel, or manage personal obligations, with attentive care, a comfortable suite, chef-prepared dining, and daily activities. Call (650) 756-1995 to talk through your dates and current availability.',
                        'actions' => [['label' => 'Request a Call', 'intent' => 'callback']],
                        'icon' => 'calendar',
                        'order' => 20,
                        'enabled' => true,
                        'featured' => true,
                    ],
                    [
                        'id' => 'suite-options',
                        'question' => 'What suite options are available?',
                        'answer' => 'Mission Villa offers private suites and shared companion suites, each with a private bathroom. Residents also enjoy welcoming lounges and a dining room. Our team can confirm which suites are currently available by phone or during a visit.',
                        'actions' => [['label' => 'Ask About Availability', 'intent' => 'availability']],
                        'icon' => 'home',
                        'order' => 30,
                        'enabled' => true,
                        'featured' => true,
                    ],
                    [
                        'id' => 'pricing-and-visits',
                        'question' => 'How can we learn about pricing and schedule a visit?',
                        'answer' => 'Pricing depends on your loved one’s daily support needs and the suite you choose, so our team discusses it with you personally rather than publishing set rates. Call (650) 756-1995 or send a request below, and ask to arrange a visit at the same time.',
                        'actions' => [
                            ['label' => 'Request Pricing', 'intent' => 'pricing'],
                            ['label' => 'Schedule a Visit', 'intent' => 'visit'],
                        ],
                        'icon' => 'phone',
                        'order' => 40,
                        'enabled' => true,
                        'featured' => true,
                    ],
                ],
            ],
        ],
        [
            // Section 07. Approved mockup (bottom band, corrected 2026-11-10). Address/phone come from config/missionvilla.php.
            // Actions open the inquiry modal; the inline card is the same shared form for visitors who reach it naturally.
            'key' => 'visit',
            'type' => 'visit.cta',
            'enabled' => true,
            'data' => [
                'script' => 'A Place to Belong',
                'heading' => 'Come See Mission Villa for Yourself',
                'body' => 'We welcome you to visit our Daly City community, meet our care team, and see firsthand the warm, supportive environment we’ve created for residents and their families.',
                'actions' => [
                    ['intent' => 'schedule_visit', 'label' => 'Schedule a Visit', 'icon' => 'calendar'],
                    ['intent' => 'request_pricing', 'label' => 'Request Pricing', 'icon' => 'file-text'],
                    ['intent' => 'request_callback', 'label' => 'Request a Call', 'icon' => 'phone'],
                ],
                'show_contact' => false, // address + phone already in the footer's Visit & Contact column
                'form' => [
                    'enabled' => true,
                    'heading' => 'Request Information or Schedule a Visit',
                    'lede' => 'Have a question or want to see Mission Villa in person? Let us know a few details, and our team will be in touch.',
                ],
            ],
        ],
        // The homepage is complete: no further sections are planned (docs/SECTION_STATUS.md).
    ],
];
