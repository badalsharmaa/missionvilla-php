<?php

/*
|--------------------------------------------------------------------------
| Suites & Floor Plans page content definition (slug: "suites-and-floor-plans")
|--------------------------------------------------------------------------
| Verified against the React reference (app/suites-and-floor-plans/page.tsx
| and lib/mission-villa-data.ts), the Mission Villa design standard,
| and the developer handoff playbook.
|
| Business rule: every form CTA opens the shared inquiry modal with
| care interest preselected to "exploring" (or specific care program).
| Factual rule: only one verified companion floor plan exists.
*/

return [
    'slug' => 'suites-and-floor-plans',
    'title' => 'Suites & Floor Plans | Mission Villa Senior Living',
    'seo' => [
        'title' => 'Suites & Floor Plans | Mission Villa Senior Living',
        'description' => 'View private, companion, and Jack & Jill suite options at Mission Villa in Daly City. Ask about current availability and arrange a tour.',
        'og_image' => '/images/suites/suite-bedroom-facility-899.webp',
    ],
    'sections' => [
        [
            'key' => 'sfp-hero',
            'type' => 'suites-floor-plans.hero',
            'enabled' => true,
            'order' => 10,
            'data' => [
                'eyebrow' => 'Suites & Floor Plans',
                'heading' => 'A comfortable space to call your own.',
                'editorial' => 'Sunlit suites with private en-suite bathrooms and personalized comforts in Daly City.',
                'intro' => 'Whether your loved one prefers privacy or companionship, we can help you explore available suite layouts and the everyday comforts of Mission Villa.',
                'image' => [
                    'src' => '/images/suites/suite-bedroom-facility-899.webp',
                    'src_mobile' => '/images/suites/suite-bedroom-facility-640.webp',
                    'width' => 899,
                    'height' => 601,
                    'alt' => 'Sunlit private suite bedroom at Mission Villa with comfortable furnishings and window daylight',
                    'provenance' => 'facility',
                    'source_url' => 'https://d13iq96prksfh0.cloudfront.net/cdn/photos/430909/900x675',
                    'rights' => 'cleared',
                    'label' => 'Mission Villa property photograph',
                ],
                'strip' => [
                    [
                        'icon' => 'bath',
                        'kicker' => 'Privacy & Dignity',
                        'title' => 'Private En-Suite Bathrooms',
                        'desc' => 'Every private and companion suite includes an attached bathroom.',
                    ],
                    [
                        'icon' => 'sun',
                        'kicker' => 'Natural Light',
                        'title' => 'Bright, Calming Spaces',
                        'desc' => 'Thoughtfully proportioned rooms filled with natural window daylight.',
                    ],
                    [
                        'icon' => 'heart',
                        'kicker' => 'Individualized Living',
                        'title' => 'Personalized Touches',
                        'desc' => 'Space for treasured photographs, favorite bedding, and keepsakes.',
                    ],
                ],
                'actions' => [
                    [
                        'label' => 'Schedule a Suite Tour',
                        'style' => 'primary',
                        'icon' => 'calendar',
                        'intent' => 'schedule_visit',
                        'care' => 'exploring',
                    ],
                    [
                        'label' => 'Request Availability',
                        'style' => 'secondary',
                        'icon' => 'arrow',
                        'intent' => 'request_availability',
                        'care' => 'exploring',
                    ],
                    [
                        'label' => '(650) 756-1995',
                        'style' => 'phone',
                        'icon' => 'phone',
                        'href' => 'tel:6507561995',
                    ],
                ],
            ],
        ],

        [
            'key' => 'sfp-formats',
            'type' => 'suites-floor-plans.formats',
            'enabled' => true,
            'order' => 20,
            'data' => [
                'eyebrow' => 'Your Options',
                'heading' => 'Find the space that feels right.',
                'intro' => 'Choose between private personal sanctuaries and companion arrangements designed to foster daily warmth and reassurance.',
                'suites' => [
                    [
                        'id' => 'private-suite',
                        'code' => 'OPTION 01 · PERSONAL SANCTUARY',
                        'cutout_label' => 'Private Suite',
                        'title' => 'Private Suite Living',
                        'badge' => 'Private Suite with Attached Bathroom',
                        'bathroom' => 'Private En-Suite Bathroom Included',
                        'summary' => 'An individual room with an attached bathroom and room for familiar personal belongings.',
                        'features' => [
                            'Dedicated sleeping and sitting space for restful downtime',
                            'Attached private bathroom designed for safety and dignity',
                            'Uncluttered pathways arranged for effortless movement',
                            'Individual climate control and emergency alert call points',
                        ],
                        'inquiry_suite' => 'private',
                        'image' => [
                            'src' => '/images/suites/suite-bedroom-facility-899.webp',
                            'width' => 899,
                            'height' => 601,
                            'alt' => 'Furnished private bedroom suite at Mission Villa with daylight',
                            'caption' => 'Private suite bedroom at Mission Villa',
                            'provenance' => 'facility',
                            'rights' => 'cleared',
                            'label' => 'Mission Villa property photo',
                        ],
                    ],
                    [
                        'id' => 'companion-unit',
                        'code' => 'OPTION 02 · SHARED COMPANIONSHIP',
                        'cutout_label' => 'Companion Unit',
                        'title' => 'Companion Suite Living',
                        'badge' => 'Companion Unit with Private Bathroom',
                        'bathroom' => 'Private Bathroom Shared Within Suite',
                        'summary' => 'A shared living arrangement with personal sleeping areas and a bathroom within the suite.',
                        'features' => [
                            'Dedicated sleeping and keepsake zones for each resident',
                            'Attached private bathroom shared only within the suite',
                            'Reassuring proximity that reduces loneliness and nighttime anxiety',
                            'Direct step-out access to courtyard gardens and dining',
                        ],
                        'inquiry_suite' => 'shared',
                        'image' => [
                            'src' => '/images/property/sitting-nook-detail.webp',
                            'width' => 899,
                            'height' => 601,
                            'alt' => 'Companion sitting space and homelike furnishings at Mission Villa',
                            'caption' => 'Companion suites foster friendly camaraderie alongside individual dignity and comfort',
                            'provenance' => 'facility',
                            'rights' => 'cleared',
                            'label' => 'Mission Villa property photo',
                        ],
                    ],
                    [
                        'id' => 'jack-and-jill',
                        'code' => 'OPTION 03 · ADJOINING FORMAT',
                        'cutout_label' => 'Jack & Jill Suite',
                        'title' => 'Jack & Jill Suite Living',
                        'badge' => 'Connected Suites with Shared Bath',
                        'bathroom' => 'Adjoining Bathroom Between Rooms',
                        'summary' => 'Two separate rooms connected by a shared bathroom. The original draft lists this as a Memory Care option; check current availability.',
                        'features' => [
                            'Two independent private sleeping and living quarters',
                            'Central en-suite bathroom accessible from both rooms',
                            'Private door access to common hallways and community spaces',
                            'Thoughtful balance of personal independence and mutual comfort',
                        ],
                        'inquiry_suite' => 'shared',
                        'image' => [
                            'src' => '/images/suites/community-lounge-facility-899.webp',
                            'width' => 899,
                            'height' => 601,
                            'alt' => 'Comfortable indoor gathering lounge at Mission Villa near resident suites',
                            'caption' => 'Jack & Jill suites offer defined personal sleeping quarters with an adjoining private bathroom',
                            'provenance' => 'facility',
                            'rights' => 'cleared',
                            'label' => 'Mission Villa property photo',
                        ],
                    ],
                ],
                'cta' => [
                    'label' => 'Ask About Available Suites',
                    'intent' => 'request_availability',
                    'note' => 'Room sizes, furnishings, configurations, and openings vary. Ask the community for details before making plans.',
                ],
            ],
        ],

        [
            'key' => 'sfp-diagram',
            'type' => 'suites-floor-plans.diagram',
            'enabled' => true,
            'order' => 30,
            'data' => [
                'eyebrow' => 'See a Layout',
                'heading' => 'A closer look at companion living.',
                'intro' => 'View the companion-suite diagram, then visit to see how available rooms are arranged in person.',
                'diagram' => [
                    'badge' => 'AUTHENTIC MISSION VILLA FLOOR PLAN',
                    'title' => 'Companion Unit Layout',
                    'subtitle' => 'Shared Companion Living with Attached En-Suite Bathroom',
                    'description' => 'The authentic Companion Unit provides clearly delineated personal living and sleeping spaces for two residents, centered around an attached private bathroom. Built-in storage and bedside space allow each resident to surround themselves with cherished mementos.',
                    'image' => [
                        'src' => '/images/suites/companion-suite-floorplan-1000.webp',
                        'width' => 1000,
                        'height' => 660,
                        'alt' => 'Mission Villa Companion Unit floor plan showing two private beds and en-suite bath',
                        'provenance' => 'facility',
                        'rights' => 'cleared',
                        'label' => 'Official property diagram',
                    ],
                ],
                'highlights' => [
                    [
                        'title' => 'Dual Personal Zones',
                        'desc' => 'Individual dressers, nightstands, and personalized wall decor spaces for each resident.',
                    ],
                    [
                        'title' => 'Attached En-Suite Bath',
                        'desc' => 'Direct internal access to a private bathroom—no corridor walks or shared communal facilities.',
                    ],
                    [
                        'title' => 'Safety & Accessibility',
                        'desc' => 'Step-free transitions, wide doorways, and emergency call cords reachable from both sides.',
                    ],
                    [
                        'title' => 'Steps from Community',
                        'desc' => 'Positioned close to the dining room, activity lounge, and courtyard garden pathways.',
                    ],
                ],
                'disclosure' => [
                    'badge' => 'OUR COMMITMENT TO TRANSPARENCY',
                    'text' => 'Mission Villa does not publish artificial CAD drawings or unverified square-footage figures. Specific window exposures, hallway locations, and room arrangements are walked and verified in person during your visit to 995 East Market Street in Daly City.',
                ],
                'action' => [
                    'label' => 'See the Suites in Person',
                    'intent' => 'schedule_visit',
                    'care' => 'exploring',
                ],
            ],
        ],

        [
            'key' => 'sfp-features',
            'type' => 'suites-floor-plans.features',
            'enabled' => false,
            'order' => 40,
            'data' => [
                'eyebrow' => 'Safety, Dignity & Comfort',
                'heading' => 'Built Around the Needs of <em>Memory Care Residents.</em>',
                'intro' => 'Every suite detail—from bathroom orientation to memory cues—is intentionally designed to reduce disorientation and provide peace of mind.',
                'features' => [
                    [
                        'icon' => 'bath',
                        'code' => 'FEATURE 01 · PRIVACY',
                        'title' => 'Private En-Suite Bathrooms',
                        'lead' => 'Dignity Day and Night',
                        'body' => 'Every suite format includes an attached private bathroom. Residents maintain personal dignity without having to navigate public hallways at night.',
                    ],
                    [
                        'icon' => 'heart',
                        'code' => 'FEATURE 02 · IDENTITY',
                        'title' => 'Memory Boxes & Touchpoints',
                        'lead' => 'Familiar Wayfinding',
                        'body' => 'Personalized display cases and photo frames outside each doorway help residents identify their home with confidence and ease.',
                    ],
                    [
                        'icon' => 'shield',
                        'code' => 'FEATURE 03 · SAFETY',
                        'title' => '24/7 Monitored Call Points',
                        'lead' => 'Immediate Assistance',
                        'body' => 'Easily accessible emergency call features and continuous on-site care staff ensure compassionate assistance is moments away at all hours.',
                    ],
                    [
                        'icon' => 'compass',
                        'code' => 'FEATURE 04 · ORIENTATION',
                        'title' => 'Thoughtful Lighting & Flow',
                        'lead' => 'Calm Daily Movement',
                        'body' => 'Generous natural window daylight, glare-reducing finishes, and wide step-free pathways promote effortless mobility and restful evenings.',
                    ],
                ],
            ],
        ],

        [
            'key' => 'sfp-faq',
            'type' => 'suites-floor-plans.faq',
            'enabled' => true,
            'order' => 50,
            'data' => [
                'eyebrow' => 'Suite Questions & Answers',
                'heading' => 'Frequently Asked <em>Suite Questions.</em>',
                'intro' => 'Common questions families ask about suite furnishings, companion matching, move-in day, and bathroom accommodations.',
                'help_card' => [
                    'title' => 'Have Questions About Suite Availability?',
                    'text' => 'Our Daly City care team can walk you through available private and companion options, pricing structures, and move-in timelines.',
                    'phone_label' => 'Call (650) 756-1995',
                    'cta_label' => 'Schedule a Suite Visit',
                    'cta_intent' => 'schedule_visit',
                ],
                'faqs' => [
                    [
                        'id' => 'faq-personalize',
                        'question' => 'Can we personalize a suite?',
                        'answer' => 'Ask the team about bringing photographs, bedding, and other familiar items; suitability depends on the room and safety requirements.',
                    ],
                    [
                        'id' => 'faq-bathrooms',
                        'question' => 'Do suites have attached bathrooms?',
                        'answer' => 'The source materials describe attached bathrooms for these formats. Confirm the specific room layout during your tour.',
                    ],
                    [
                        'id' => 'faq-pricing',
                        'question' => 'How do we compare suite prices?',
                        'answer' => 'Room type and care needs can affect pricing. The team can explain current options and provide details.',
                    ],
                ],
            ],
        ],

        [
            'key' => 'sfp-cta',
            'type' => 'visit.cta',
            'enabled' => true,
            'order' => 60,
            'data' => [
                'script' => 'Walk Our Suites in Person',
                'heading' => 'See the available spaces for yourself.',
                'body' => 'Tour a suite, ask about layouts, and discuss the options for your loved one.',
                'care' => 'exploring',
                'actions' => [
                    [
                        'intent' => 'schedule_visit',
                        'label' => 'Schedule a Suite Tour',
                        'icon' => 'calendar',
                    ],
                    [
                        'intent' => 'request_pricing',
                        'label' => 'Request Pricing & Plans',
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
                    'heading' => 'Suite & Floor Plan Inquiry',
                    'lede' => 'Submissions save locally while we finalize direct staff notifications. For immediate assistance or current availability, please call us directly at (650) 756-1995.',
                ],
            ],
        ],
    ],
];
