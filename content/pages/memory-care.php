<?php

/*
|--------------------------------------------------------------------------
| Memory Care page content definition (slug: "memory-care")
|--------------------------------------------------------------------------
| Verified against the React reference (app/memory-care/page.tsx and
| lib/mission-villa-data.ts) and the approved Mission Villa design standard.
|
| Business rule: every form CTA opens the shared inquiry modal with
| care interest preselected to "memory_care".
*/

return [
    'slug' => 'memory-care',
    'title' => 'Legacies™ Memory Care in Daly City | Mission Villa',
    'seo' => [
        'title' => 'Legacies™ Memory Care in Daly City | Mission Villa',
        'description' => 'Learn about Legacies™ Memory Care at Mission Villa in Daly City: personalized routines, meaningful activities, and family involvement.',
        'og_image' => '/images/hero/memory-care-conversation-2000.webp',
    ],
    'sections' => [
        [
            'key' => 'mc-hero',
            'type' => 'memory-care.hero',
            'enabled' => true,
            'order' => 10,
            'data' => [
                'eyebrow' => 'Legacies™ Memory Care',
                'heading' => 'Memory care that starts with the person.',
                'editorial' => 'Dignity, familiar routines, and <em>meaningful connection.</em>',
                'intro' => 'When someone is living with Alzheimer’s disease or another form of dementia, familiar things matter. At Mission Villa, care is shaped around personal history, daily routines, and respectful support.',
                'image' => [
                    'src' => '/images/hero/memory-care-conversation-2000.webp',
                    'src_mobile' => '/images/hero/memory-care-conversation-1200.webp',
                    'width' => 2000,
                    'height' => 1125,
                    'alt' => 'Caregiver sharing a compassionate conversation with a senior resident in a sunlit living space',
                    'provenance' => 'illustrative',
                    'rights' => 'cleared',
                    'label' => 'Illustrative image · not actual residents',
                ],
                'badges' => [
                    [
                        'kicker' => 'Signature Approach',
                        'title' => 'Legacies™ Life-Story Care',
                        'desc' => 'Shaped by personal history, habits & comforting preferences.',
                    ],
                    [
                        'kicker' => 'Accommodations',
                        'title' => 'Private & Companion Suites',
                        'desc' => 'Comfortable suites with private baths and emergency alert features.',
                    ],
                    [
                        'kicker' => 'Daly City Community',
                        'title' => '995 East Market Street',
                        'desc' => 'CA RCFE License #415601046 · Serving San Mateo County families.',
                    ],
                ],
                'actions' => [
                    [
                        'label' => 'Schedule a Memory Care Visit',
                        'style' => 'primary',
                        'icon' => 'calendar',
                        'intent' => 'schedule_visit',
                        'care' => 'memory_care',
                    ],
                    [
                        'label' => 'See Our Living Options',
                        'style' => 'secondary',
                        'icon' => 'arrow',
                        'href' => '/living-options',
                    ],
                    [
                        'label' => '(650) 756-1995',
                        'style' => 'phone',
                        'icon' => 'phone',
                        'href' => 'tel:16507561995',
                    ],
                ],
            ],
        ],

        [
            'key' => 'mc-legacies',
            'type' => 'memory-care.legacies',
            'enabled' => true,
            'order' => 20,
            'data' => [
                'eyebrow' => 'Our Approach',
                'heading' => 'A life story is part of the care plan.',
                'intro' => 'We listen to families and learn about each resident’s interests, habits, and ways of finding comfort. That understanding guides everyday interactions.',
                'touchpoints' => [
                    [
                        'id' => 'life-story',
                        'chapter' => 'Chapter 01',
                        'tab_label' => 'Personal Histories',
                        'icon' => 'book-open',
                        'title' => 'Personal history',
                        'subtitle' => 'Care shaped by your loved one’s life story, vocation, and cherished traditions',
                        'description' => 'Favorite music, memories, and meaningful relationships.',
                        'in_practice' => [
                            'Learning personal histories, family relationships, and comforting conversation topics',
                            'Honoring lifelong preferences in how a resident likes to be addressed and supported',
                            'Using familiar touchpoints to bring reassurance during moments of uncertainty',
                        ],
                        'takeaway' => 'Your loved one is known as an individual with a rich life story—never defined solely by Alzheimer’s or dementia.',
                        'image' => [
                            'src' => '/images/suites/community-lounge-facility-899.webp',
                            'src_mobile' => '/images/suites/community-lounge-facility-640.webp',
                            'width' => 899,
                            'height' => 601,
                            'alt' => 'Mission Villa community lounge with comfortable armchairs and natural light',
                            'provenance' => 'facility',
                            'rights' => 'unconfirmed',
                            'label' => 'Mission Villa photo',
                            'caption' => 'Listening closely to personal histories, memories, and cherished traditions',
                        ],
                        'cta_label' => 'Ask About Legacies™',
                        'cta_intent' => 'schedule_visit',
                    ],
                    [
                        'id' => 'daily-rhythm',
                        'chapter' => 'Chapter 02',
                        'tab_label' => 'Familiar Routines',
                        'icon' => 'compass',
                        'title' => 'Familiar routines',
                        'subtitle' => 'Gentle structure that reduces overwhelm while respecting personal pace',
                        'description' => 'Gentle support with daily activities at an individual pace.',
                        'in_practice' => [
                            'Unhurried morning routines aligned with personal waking and grooming habits',
                            'Consistent, welcoming cues for chef-prepared meals and social gatherings',
                            'Quiet afternoon and evening spaces that support restful transitions',
                        ],
                        'takeaway' => 'Predictable rhythms help residents feel grounded and secure while preserving personal choice.',
                        'image' => [
                            'src' => '/images/suites/suite-bedroom-facility-899.webp',
                            'src_mobile' => '/images/suites/suite-bedroom-facility-640.webp',
                            'width' => 899,
                            'height' => 601,
                            'alt' => 'Furnished suite bedroom at Mission Villa with natural daylight',
                            'provenance' => 'facility',
                            'rights' => 'unconfirmed',
                            'label' => 'Mission Villa photo',
                            'caption' => 'Homelike residential spaces designed for calm transitions and everyday ease',
                        ],
                        'cta_label' => 'Ask About Legacies™',
                        'cta_intent' => 'schedule_visit',
                    ],
                    [
                        'id' => 'meaningful-engagement',
                        'chapter' => 'Chapter 03',
                        'tab_label' => 'Meaningful Connection',
                        'icon' => 'heart',
                        'title' => 'Connection',
                        'subtitle' => 'Activities adapted to individual interests, sensory comfort, and current abilities',
                        'description' => 'Opportunities for conversation, activities, and family visits.',
                        'in_practice' => [
                            'Music, reminiscence, art, and gentle movement tailored to resident abilities',
                            'Shared mealtimes with freshly prepared, comforting dishes in our dining room',
                            'Opportunities for quiet enjoyment in communal lounges or outdoor patio areas',
                        ],
                        'takeaway' => 'Every day holds gentle invitations to participate, connect with neighbors, and experience accomplishment.',
                        'image' => [
                            'src' => '/images/life/meaningful-connection-illustrative-1402.webp',
                            'src_mobile' => '/images/life/meaningful-connection-illustrative-960.webp',
                            'width' => 1402,
                            'height' => 789,
                            'alt' => 'Illustrative image: Engaging conversation between care partner and senior resident in a residential setting',
                            'provenance' => 'illustrative',
                            'rights' => 'cleared',
                            'label' => 'Illustrative image · not actual residents',
                            'caption' => 'Sensory-rich activities, music, and shared moments tailored to each resident',
                        ],
                        'cta_label' => 'Ask About Legacies™',
                        'cta_intent' => 'schedule_visit',
                    ],
                    [
                        'id' => 'family-partnership',
                        'chapter' => 'Chapter 04',
                        'tab_label' => 'Family Partnership',
                        'icon' => 'people',
                        'title' => 'Supporting the Whole Family Journey',
                        'subtitle' => 'Open communication and a warm welcome whenever you visit in Daly City',
                        'description' => 'Choosing Memory Care is an act of love, not a step away from family life. At Mission Villa, we help lift the daily caregiving strain so spouses, adult children, and relatives can return to simply enjoying meaningful time together.',
                        'in_practice' => [
                            'Approachable, transparent communication with our Daly City care team',
                            'Inviting common areas and dining spaces where families can visit comfortably',
                            'Collaborative care planning before move-in and as needs evolve over time',
                        ],
                        'takeaway' => 'You remain at the heart of your loved one’s life, supported by an attentive team at 995 East Market Street.',
                        'image' => [
                            'src' => '/images/why-families/courtyard-patio-facility-1024.webp',
                            'src_mobile' => '/images/why-families/courtyard-patio-facility-768.webp',
                            'width' => 1024,
                            'height' => 576,
                            'alt' => 'Mission Villa outdoor courtyard patio with tables and green foliage',
                            'provenance' => 'facility',
                            'rights' => 'unconfirmed',
                            'label' => 'Mission Villa photo',
                            'caption' => 'A reassuring partnership that welcomes family connection every day',
                        ],
                        'cta_label' => 'Ask About Legacies™',
                        'cta_intent' => 'schedule_visit',
                    ],
                ],
            ],
        ],

        [
            'key' => 'mc-daily',
            'type' => 'memory-care.daily-life',
            'enabled' => true,
            'order' => 30,
            'data' => [
                'eyebrow' => 'A Typical Day',
                'heading' => 'Support throughout the day.',
                'intro' => 'A familiar rhythm, engaging experiences, and plenty of meaningful moments throughout the day.',
                'scenes' => [
                    [
                        'id' => 'morning',
                        'rhythm' => 'Morning · Personal Pace',
                        'title' => 'A Reassuring Start to the Day',
                        'narrative' => 'Help with personal routines and a welcoming breakfast.',
                        'highlights' => [
                            'Individualized assistance with dressing, grooming, and personal hygiene',
                            'Private bathroom access inside private and companion suites',
                            'Warm greetings and unhurried guidance toward morning breakfast',
                        ],
                        'image' => [
                            'src' => '/images/suites/suite-bedroom-facility-640.webp',
                            'width' => 640,
                            'height' => 428,
                            'alt' => 'Comfortable, well-lit bedroom suite at Mission Villa',
                            'provenance' => 'facility',
                            'rights' => 'unconfirmed',
                            'label' => 'Mission Villa photo',
                        ],
                    ],
                    [
                        'id' => 'midday',
                        'rhythm' => 'Midday · Shared Table',
                        'title' => 'Chef-Prepared Dining & Familiar Flavors',
                        'narrative' => 'Shared meals, music or other activities, and quiet time when needed.',
                        'highlights' => [
                            'Three chef-prepared daily meals plus snacks in an inviting dining room',
                            'Attentive dining support accommodating personal preferences and needs',
                            'A sociable, homelike atmosphere that encourages appetite and warmth',
                        ],
                        'image' => [
                            'src' => '/images/life/dining-daily-life-illustrative-960.webp',
                            'width' => 960,
                            'height' => 540,
                            'alt' => 'Freshly prepared, balanced meal served at a warm community dining table',
                            'provenance' => 'illustrative',
                            'rights' => 'cleared',
                            'label' => 'Illustrative image',
                        ],
                    ],
                    [
                        'id' => 'evening',
                        'rhythm' => 'Evening · Quiet Sanctuary',
                        'title' => 'Afternoon Engagement & Restful Evenings',
                        'narrative' => 'A familiar pace and assistance with settling in.',
                        'highlights' => [
                            'Engaging activities adapted to resident abilities and interests',
                            'Comfortable lounges and outdoor patio spaces for family visits',
                            'Calm, reassuring evening support tailored to personal comfort',
                        ],
                        'image' => [
                            'src' => '/images/suites/community-lounge-facility-640.webp',
                            'width' => 640,
                            'height' => 428,
                            'alt' => 'Mission Villa community lounge with soft lighting and armchairs',
                            'provenance' => 'facility',
                            'rights' => 'unconfirmed',
                            'label' => 'Mission Villa photo',
                        ],
                    ],
                ],
            ],
        ],

        [
            'key' => 'mc-care',
            'type' => 'memory-care.care-comfort',
            'enabled' => true,
            'order' => 40,
            'data' => [
                'eyebrow' => 'At Home at Mission Villa',
                'heading' => 'Care, comfort, and room for family.',
                'intro' => 'Specialized memory care, a welcoming environment, and the comfort of home — all in one supportive setting in Daly City.',
                'checklist' => [
                    '24/7 compassionate, trained care staff on-site',
                    'Secure, thoughtfully designed environment with indoor & outdoor patio spaces',
                    'Engaging, ability-based programs shaped around life histories',
                    'Chef-prepared, nutritious meals with attentive dining assistance',
                    'Comfortable private and companion suites with private bathrooms',
                ],
                'reassurance_box' => [
                    'title' => 'Personalized Care Planning',
                    'text' => 'We encourage families to talk with the team about their loved one’s specific needs before making a decision.',
                ],
                'image' => [
                    'src' => '/images/suites/suite-bedroom-facility-899.webp',
                    'src_mobile' => '/images/suites/suite-bedroom-facility-640.webp',
                    'width' => 899,
                    'height' => 601,
                    'alt' => 'Furnished private suite bedroom at Mission Villa Senior Living in Daly City',
                    'provenance' => 'facility',
                    'rights' => 'unconfirmed',
                    'label' => 'Mission Villa photo',
                    'caption' => 'Comfortable suites designed for personal dignity, safety, and everyday calm',
                ],
                'actions' => [
                    [
                        'label' => 'Ask About Accommodations',
                        'style' => 'primary',
                        'icon' => 'calendar',
                        'intent' => 'request_availability',
                        'care' => 'memory_care',
                    ],
                    [
                        'label' => 'Tour Memory Care',
                        'style' => 'secondary',
                        'icon' => 'arrow',
                        'intent' => 'schedule_visit',
                        'care' => 'memory_care',
                    ],
                ],
            ],
        ],

        [
            'key' => 'mc-faq',
            'type' => 'faq.featured',
            'enabled' => true,
            'order' => 50,
            'data' => [
                'eyebrow' => 'Questions Families Often Ask',
                'heading' => 'Questions Families <em>Often Ask</em>',
                'intro' => 'Clear answers about our Legacies™ Memory Care program, everyday support, and visiting Mission Villa.',
                'display_count' => 3,
                'entries' => [
                    [
                        'id' => 'mc-faq-program',
                        'question' => 'Who is Memory Care for?',
                        'answer' => 'Older adults living with Alzheimer’s disease or other forms of dementia who may benefit from ongoing residential support. Admission depends on an individual care assessment.',
                        'actions' => [
                            ['label' => 'Schedule a Visit', 'intent' => 'visit'],
                        ],
                        'icon' => 'sprout',
                        'order' => 10,
                        'enabled' => true,
                        'featured' => true,
                    ],
                    [
                        'id' => 'mc-faq-visiting',
                        'question' => 'Can our family stay involved?',
                        'answer' => 'Yes. Family knowledge, regular conversations, and visits are important parts of our approach.',
                        'actions' => [
                            ['label' => 'Plan a Visit', 'intent' => 'visit'],
                        ],
                        'icon' => 'people',
                        'order' => 20,
                        'enabled' => true,
                        'featured' => true,
                    ],
                    [
                        'id' => 'mc-faq-support',
                        'question' => 'How do we get started?',
                        'answer' => 'Call (650) 756-1995 or request a visit to discuss care needs and current suite options.',
                        'actions' => [
                            ['label' => 'Request a Call', 'intent' => 'callback'],
                        ],
                        'icon' => 'shield',
                        'order' => 30,
                        'enabled' => true,
                        'featured' => true,
                    ],
                ],
            ],
        ],

        [
            'key' => 'mc-cta',
            'type' => 'visit.cta',
            'enabled' => true,
            'order' => 60,
            'data' => [
                'script' => 'Let’s Connect',
                'heading' => 'Let’s talk about your loved one.',
                'body' => 'We’ll answer your questions and help you decide whether Mission Villa is a good fit.',
                'care' => 'memory_care',
                'actions' => [
                    [
                        'intent' => 'schedule_visit',
                        'label' => 'Schedule a Visit',
                        'icon' => 'calendar',
                    ],
                    [
                        'intent' => 'request_pricing',
                        'label' => 'Request Pricing',
                        'icon' => 'file-text',
                    ],
                    [
                        'intent' => 'request_callback',
                        'label' => 'Request a Call',
                        'icon' => 'phone',
                    ],
                ],
                'show_contact' => false,
                'form' => [
                    'enabled' => true,
                    'heading' => 'Request Information or Schedule a Visit',
                    'lede' => 'Submissions save locally while we finalize direct staff notifications. For immediate assistance or current availability, please call us directly at (650) 756-1995.',
                ],
            ],
        ],
    ],
];
