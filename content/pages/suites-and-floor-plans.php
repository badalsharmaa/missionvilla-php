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
        'title' => 'Suites & Floor Plans: Memory Care Living in Daly City | Mission Villa',
        'description' => 'Explore comfortable private and companion suites at Mission Villa in Daly City. Each suite includes a private en-suite bathroom, natural daylight, and 24/7 care support.',
        'og_image' => '/images/suites/suite-bedroom-facility-899.webp',
    ],
    'sections' => [
        [
            'key' => 'sfp-hero',
            'type' => 'suites-floor-plans.hero',
            'enabled' => true,
            'order' => 10,
            'data' => [
                'eyebrow' => 'Accommodations & Living Spaces',
                'heading' => 'Calm Personal Sanctuaries, <em>Designed for Dignity.</em>',
                'editorial' => 'Sunlit suites with private en-suite bathrooms and personalized comforts in Daly City.',
                'intro' => 'Every suite at Mission Villa provides a peaceful, personal retreat where familiar furnishings, favorite keepsakes, and caring 24-hour support create an immediate sense of home and belonging.',
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
                        'label' => 'Request Pricing & Plans',
                        'style' => 'secondary',
                        'icon' => 'arrow',
                        'intent' => 'request_pricing',
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
                'eyebrow' => 'Suite Layout Options',
                'heading' => 'Thoughtfully Arranged for <em>Comfort & Connection.</em>',
                'intro' => 'Choose between private personal sanctuaries and companion arrangements designed to foster daily warmth and reassurance.',
                'suites' => [
                    [
                        'id' => 'private-suite',
                        'code' => 'OPTION 01 · PERSONAL SANCTUARY',
                        'cutout_label' => 'Private Suite',
                        'title' => 'Private Suite Living',
                        'badge' => 'Private Suite with Attached Bathroom',
                        'bathroom' => 'Private En-Suite Bathroom Included',
                        'summary' => 'Our private suites offer older adults an unhurried, quiet sanctuary where favorite chairs, family photos, and personal routines create an immediate feeling of ownership.',
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
                        'summary' => 'For residents who find reassurance in daily friendship, our Companion Unit balances camaraderie with defined personal sleeping zones and a shared en-suite bathroom.',
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
                        'summary' => 'A versatile accommodation featuring two individual private bedrooms connected by a shared central bathroom—ideal for privacy with familiar neighborly closeness.',
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
                    'label' => 'Check Current Suite Availability',
                    'intent' => 'request_availability',
                    'note' => 'Suite configurations and availability vary. Our Daly City team provides personalized guidance during tours.',
                ],
            ],
        ],

        [
            'key' => 'sfp-diagram',
            'type' => 'suites-floor-plans.diagram',
            'enabled' => true,
            'order' => 30,
            'data' => [
                'eyebrow' => 'Architectural Layout & Transparency',
                'heading' => 'Authentic Floor Plans, <em>Walked in Person.</em>',
                'intro' => 'We believe in complete transparency. Rather than displaying fabricated blueprints, we share our authentic companion layout and invite you to tour each available room in person.',
                'diagram' => [
                    'badge' => 'AUTHENTIC MISSION VILLA FLOOR PLAN',
                    'title' => 'Companion Unit Layout',
                    'subtitle' => 'Shared Companion Living with Attached En-Suite Bathroom',
                    'description' => 'The authentic Companion Unit provides clearly delineated personal living and sleeping spaces for two residents, centered around an attached private bathroom. Built-in storage and bedside space allow each resident to surround themselves with cherished mementos.',
                    'image' => [
                        'src' => '/images/suites/companion-suite-floorplan-1000.webp',
                        'width' => 1000,
                        'height' => 750,
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
                    'label' => 'Tour Available Suites in Person',
                    'intent' => 'schedule_visit',
                    'care' => 'exploring',
                ],
            ],
        ],

        [
            'key' => 'sfp-features',
            'type' => 'suites-floor-plans.features',
            'enabled' => true,
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
                        'id' => 'faq-furnished-or-unfurnished',
                        'question' => 'Are suites furnished, or can we bring our loved one’s own furniture?',
                        'answer' => 'Families are warmly encouraged to bring familiar bedroom furniture, favorite recliners, cherished quilts, and framed family photos to make the suite feel truly like home. If needed, Mission Villa can also assist with comfortable furnishings to ensure an easy transition.',
                    ],
                    [
                        'id' => 'faq-private-bathrooms',
                        'question' => 'Do all suites include a private bathroom?',
                        'answer' => 'Yes. Both our private suites and companion units include private en-suite bathrooms located directly inside the accommodation, rather than communal corridor-style restrooms. This ensures personal dignity and comfort at all hours.',
                    ],
                    [
                        'id' => 'faq-companion-matching',
                        'question' => 'How does Mission Villa match residents in companion suites?',
                        'answer' => 'We take great care in companion placement, considering daily sleep routines, background, interests, and personality traits. A well-matched roommate often becomes a reassuring daily friend and comforting presence.',
                    ],
                    [
                        'id' => 'faq-suite-pricing',
                        'question' => 'How does pricing differ between private and companion suites?',
                        'answer' => 'Pricing reflects the selected suite layout (private vs. companion) alongside individual care support requirements determined during your initial wellness assessment. Our team provides clear, transparent cost sheets during your visit.',
                    ],
                    [
                        'id' => 'faq-safety-features',
                        'question' => 'What safety features are built into each suite?',
                        'answer' => 'Suites feature emergency call systems, step-free threshold transitions, bathroom safety grab bars, secure window limiters, and 24-hour monitoring by our trained memory care caregiving staff.',
                    ],
                    [
                        'id' => 'faq-personalization',
                        'question' => 'How can we personalize our loved one’s suite for memory support?',
                        'answer' => 'We encourage memory boxes outside the suite door with favorite career mementos, wedding photos, or artwork. Inside, familiar bedside arrangements and favorite music players help create immediate calm and reassurance.',
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
                'heading' => 'Experience the Comfort & Warmth',
                'body' => 'Schedule a personal tour to walk our private and companion suites, meet our memory care team, and explore our secure courtyard in Daly City.',
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
                    'lede' => 'Our Daly City care coordinator will connect with you to discuss room availability and move-in options.',
                ],
            ],
        ],
    ],
];
