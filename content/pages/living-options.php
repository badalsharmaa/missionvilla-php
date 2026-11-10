<?php

/*
|--------------------------------------------------------------------------
| Living Options page content definition (slug: "living-options")
|--------------------------------------------------------------------------
| Verified against the React reference (app/living-options/page.tsx and
| lib/mission-villa-data.ts), the approved design mockup, and the
| Mission Villa design standard (.agents/skills/missionvilla-design-standard/).
|
| Business rule: every form CTA opens the shared inquiry modal with
| care interest preselected to "exploring" (or specific care program).
*/

return [
    'slug' => 'living-options',
    'title' => 'Living Options: Memory Care & Respite Care | Mission Villa Senior Living',
    'seo' => [
        'title' => 'Living Options: Memory Care & Respite Care in Daly City | Mission Villa',
        'description' => 'Explore living options at Mission Villa in Daly City. Dedicated Legacies™ Memory Care and short-term Respite Care with private, companion, and Jack & Jill suites.',
        'og_image' => '/images/suites/suite-bedroom-facility-899.webp',
    ],
    'sections' => [
        [
            'key' => 'lo-hero',
            'type' => 'living-options.hero',
            'enabled' => true,
            'order' => 10,
            'data' => [
                'eyebrow' => 'Living Options at Mission Villa',
                'heading' => 'Comfortable Living, <em>Personalized Support.</em>',
                'editorial' => 'Two dedicated care paths in a welcoming, homelike Daly City setting.',
                'intro' => 'Mission Villa provides ongoing Legacies™ Memory Care and flexible Short-Term Respite Care—delivering personalized daily support, private and companion suites, and peace of mind for Bay Area families.',
                'image' => [
                    'src' => '/images/suites/suite-bedroom-facility-899.webp',
                    'src_mobile' => '/images/suites/suite-bedroom-facility-640.webp',
                    'width' => 899,
                    'height' => 601,
                    'alt' => 'Furnished private bedroom suite at Mission Villa with natural window light and personal comforts',
                    'provenance' => 'facility',
                    'source_url' => 'https://d13iq96prksfh0.cloudfront.net/cdn/photos/430909/900x675',
                    'rights' => 'cleared',
                    'label' => 'Mission Villa property photograph',
                ],
                'strip' => [
                    [
                        'icon' => 'bed',
                        'kicker' => 'Accommodations',
                        'title' => 'Private & Companion Suites',
                        'desc' => 'Private, Companion Unit & Jack & Jill layouts with private bath.',
                    ],
                    [
                        'icon' => 'heart',
                        'kicker' => 'Two Programs',
                        'title' => 'Memory & Respite Care',
                        'desc' => 'Dedicated long-term support and short-term caregiver relief.',
                    ],
                    [
                        'icon' => 'home',
                        'kicker' => 'Community Life',
                        'title' => 'Homelike Daly City Setting',
                        'desc' => 'Chef-prepared dining, courtyard garden, and 24-hour staff.',
                    ],
                ],
                'actions' => [
                    [
                        'label' => 'Schedule a Visit',
                        'style' => 'primary',
                        'icon' => 'calendar',
                        'intent' => 'schedule_visit',
                        'care' => 'exploring',
                    ],
                    [
                        'label' => 'Explore Living Options',
                        'style' => 'secondary',
                        'icon' => 'arrow',
                        'href' => '#choose-care',
                    ],
                    [
                        'label' => '(650) 756-1995',
                        'style' => 'phone',
                        'icon' => 'phone',
                    ],
                ],
            ],
        ],

        [
            'key' => 'lo-care',
            'type' => 'living-options.care',
            'enabled' => true,
            'order' => 20,
            'data' => [
                'eyebrow' => 'CARE OPTIONS AT MISSION VILLA',
                'heading' => 'Choose the Care That <em>Fits Your Needs.</em>',
                'intro' => 'Mission Villa focuses exclusively on two specialized care paths: ongoing Legacies™ Memory Care and flexible Short-Term Respite Care—each delivered in a warm, residential community.',
                'options' => [
                    [
                        'id' => 'memory-care',
                        'tag' => 'Long-Term Residential Care · Legacies™ Program',
                        'number' => 'Living Option 01',
                        'title' => 'Legacies™ Memory Care',
                        'headline' => 'Person-Centered Support for Alzheimer’s & Dementia',
                        'lead' => 'At Mission Villa, Memory Care is not a side wing—it is the heart of our community. Through our Legacies™ Memory Care program, we honor each resident’s life story, daily rhythms, and personal dignity in a calm, homelike environment.',
                        'key_distinction' => 'Best suited for older adults seeking an ongoing, supportive home where 24-hour staff know their personal history and provide steady daily assistance.',
                        'ideal_for' => [
                            'Older adults living with Alzheimer’s disease or other forms of dementia',
                            'Families seeking a safe, nurturing residential setting with predictable daily rhythms',
                            'Residents who thrive with story-driven engagement, chef-prepared dining, and attentive personal care',
                        ],
                        'inclusions' => [
                            'Signature Legacies™ Memory Care life-story approach',
                            '24-hour on-site staff support, routine assessments, and escort help',
                            'Private Suites, Companion Units, and Jack & Jill formats with private baths',
                            'Three chef-prepared meals daily, housekeeping, laundry, and life-enrichment',
                        ],
                        'suite_summary' => 'Private Suite, Companion Unit, and Jack & Jill formats — personalizable with family furnishings.',
                        'route_href' => '/memory-care',
                        'route_label' => 'Explore Full Memory Care Details',
                        'inquiry_intent' => 'schedule_visit',
                        'inquiry_care' => 'memory_care',
                        'inquiry_label' => 'Schedule a Tour',
                        'image' => [
                            'src' => '/images/care/memory-care-companion-1122.webp',
                            'width' => 1122,
                            'height' => 748,
                            'alt' => 'Resident and caregiver sharing an engaging conversation at Mission Villa',
                            'caption' => 'Legacies™ Memory Care honors personal history, familiar routines, and family connection',
                            'provenance' => 'illustrative',
                            'rights' => 'cleared',
                            'label' => 'Illustrative image · not actual residents',
                        ],
                    ],
                    [
                        'id' => 'respite-care',
                        'tag' => 'Short-Term Stays · Family Caregiver Relief',
                        'number' => 'Living Option 02',
                        'title' => 'Short-Term Respite Care',
                        'headline' => 'Welcoming Short-Term Stays & Caregiver Peace of Mind',
                        'lead' => 'Caring for a loved one at home takes deep devotion. Our Respite Care program offers short-term stays of a few days to several weeks—welcoming guests into the full warmth, dining, and attentive support of Mission Villa while family caregivers rest, travel, or recharge.',
                        'key_distinction' => 'Best suited for temporary stays when a family caregiver needs dependable relief, during post-rehabilitation transitions, or as a gentle introduction to community life.',
                        'ideal_for' => [
                            'Primary family caregivers needing time to rest, travel, or attend to personal obligations',
                            'Older adults transitioning after an illness or rehabilitation stay who benefit from temporary 24-hour support',
                            'Families considering Memory Care who want their loved one to experience Mission Villa firsthand',
                        ],
                        'inclusions' => [
                            'Comfortable short-term suite accommodations with private bathroom access',
                            'Tailored daily assistance with personal care, routines, and mobility',
                            'Full access to chef-prepared meals, communal lounges, courtyard, and daily activities',
                            'Direct communication with family members throughout the stay',
                        ],
                        'suite_summary' => 'Furnished short-term suite accommodations with private bathroom access.',
                        'route_href' => '/respite-care',
                        'route_label' => 'Explore Full Respite Care Details',
                        'inquiry_intent' => 'request_availability',
                        'inquiry_care' => 'respite_care',
                        'inquiry_label' => 'Check Stay Availability',
                        'image' => [
                            'src' => '/images/care/respite-care-welcome-1402.webp',
                            'width' => 1402,
                            'height' => 935,
                            'alt' => 'Family member and caregiver discussing respite stay details in a warm environment',
                            'caption' => 'Short-term Respite Care stays support both older adults and dedicated family caregivers',
                            'provenance' => 'illustrative',
                            'rights' => 'cleared',
                            'label' => 'Illustrative image · not actual residents',
                        ],
                    ],
                ],
                'comparison' => [
                    'heading' => 'At-a-Glance Comparison',
                    'intro' => 'Key distinctions and shared foundations between our two care programs.',
                    'rows' => [
                        [
                            'dimension' => 'Primary Purpose',
                            'memory_care' => 'Ongoing, long-term residential support with steady daily routines for Alzheimer’s or dementia.',
                            'respite_care' => 'Short-term stays (days to weeks) for caregiver relief, recovery, or trial experience.',
                        ],
                        [
                            'dimension' => 'Who It Supports',
                            'memory_care' => 'Seniors with memory loss who benefit from 24-hour specialized care in a nurturing setting.',
                            'respite_care' => 'Seniors cared for at home whose caregivers need relief or seniors post-rehab.',
                        ],
                        [
                            'dimension' => 'Daily Support',
                            'memory_care' => 'Signature Legacies™ approach with personalized help for bathing, dressing, and daily life.',
                            'respite_care' => 'Tailored daily personal care, medication assistance, and warm orientation from day one.',
                        ],
                        [
                            'dimension' => 'Accommodations',
                            'memory_care' => 'Private Suites, Companion Units, and Jack & Jill formats with private bathroom access.',
                            'respite_care' => 'Comfortable furnished suites with private bathroom access ready for move-in.',
                        ],
                        [
                            'dimension' => 'Planning & Pricing',
                            'memory_care' => 'Assessment-based monthly pricing tailored to care level and chosen suite format.',
                            'respite_care' => 'Flexible short-term rates based on stay duration, suite availability, and care needs.',
                        ],
                    ],
                    'shared_foundation' => 'Both programs include 24-hour on-site staff, private bathroom access, three chef-prepared meals daily, life enrichment, housekeeping, and CA RCFE License #415601046.',
                ],
            ],
        ],

        [
            'key' => 'lo-suites',
            'type' => 'living-options.suites',
            'enabled' => true,
            'order' => 30,
            'data' => [
                'eyebrow' => 'RESIDENTIAL ACCOMMODATIONS',
                'heading' => 'Our Suite & <em>Floor-Plan Options</em>',
                'intro' => 'Every suite at Mission Villa is designed with comfort, safety, and personal dignity in mind. Choose from three thoughtfully arranged residential configurations—each featuring private bathroom access.',
                'suites' => [
                    [
                        'id' => 'private-suite',
                        'code' => 'FORMAT 01',
                        'cutout_label' => 'FORMAT 01 · PRIVATE',
                        'title' => 'Private Suite with Private Bath',
                        'badge' => 'Memory Care & Respite Care',
                        'bathroom' => 'Dedicated en-suite private bathroom designed for accessibility and comfort.',
                        'summary' => 'A peaceful, individual residential suite offering dedicated sleeping and sitting space alongside an attached private bathroom—ideal for residents who value personal quiet and familiar surroundings.',
                        'features' => [
                            'Private living and sleeping quarters with natural light',
                            'Attached private bathroom with supportive fixtures',
                            'Individual thermostat control, utilities, housekeeping, and laundry',
                            'Emergency alert system and 24-hour staff availability',
                        ],
                        'inquiry_suite' => 'private',
                        'image' => [
                            'src' => '/images/suites/suite-bedroom-facility-899.webp',
                            'width' => 899,
                            'height' => 601,
                            'alt' => 'A furnished bedroom at Mission Villa with a made bed, armchair and a bright window',
                            'caption' => 'Private Suites offer quiet sanctuary ready for treasured family photographs and keepsakes',
                            'provenance' => 'facility',
                            'rights' => 'cleared',
                            'label' => 'Mission Villa property photograph',
                        ],
                    ],
                    [
                        'id' => 'companion-unit',
                        'code' => 'FORMAT 02',
                        'cutout_label' => 'FORMAT 02 · COMPANION',
                        'title' => 'Companion Unit (Shared Suite)',
                        'badge' => 'Memory Care & Respite Care',
                        'bathroom' => 'Private en-suite bathroom shared exclusively between the two suite companions.',
                        'summary' => 'Pairs two residents in a thoughtfully arranged shared suite with a private bathroom—fostering companionship, natural socialization, and mutual reassurance.',
                        'features' => [
                            'Distinct personal sleeping areas within a welcoming shared suite',
                            'Space for each resident’s favorite bedding, photos, and personal mementos',
                            'Private bathroom shared exclusively within the suite',
                            'Full housekeeping, linen service, utilities, and emergency alert features',
                        ],
                        'inquiry_suite' => 'shared',
                        'image' => [
                            'src' => '/images/suites/companion-suite-floorplan-1000.webp',
                            'width' => 1000,
                            'height' => 660,
                            'alt' => 'Companion suite floor plan at Mission Villa showing two sleeping areas and private bathroom',
                            'caption' => 'Companion Units balance friendly camaraderie with personal dignity and comfort',
                            'provenance' => 'facility',
                            'rights' => 'cleared',
                            'label' => 'Mission Villa architectural plan',
                        ],
                    ],
                    [
                        'id' => 'jack-and-jill',
                        'code' => 'FORMAT 03',
                        'cutout_label' => 'FORMAT 03 · JACK & JILL',
                        'title' => 'Jack & Jill Suite Format',
                        'badge' => 'Memory Care Only',
                        'bathroom' => 'Adjoining private bathroom connecting two individual sleeping rooms.',
                        'summary' => 'Separate individual sleeping rooms connected by an adjoining private bathroom—combining personal privacy with homelike convenience and proximity to care.',
                        'features' => [
                            'Individual sleeping quarters connected by an adjoining private bathroom',
                            'Room to personalize walls, nightstands, and seating with familiar items',
                            'Individual comfort controls, utilities, housekeeping, and personal laundry',
                            'Easy access to dining, lounges, and enclosed courtyard spaces',
                        ],
                        'inquiry_suite' => 'shared',
                        'image' => [
                            'src' => '/images/suites/community-lounge-facility-899.webp',
                            'width' => 899,
                            'height' => 601,
                            'alt' => 'Mission Villa community lounge with comfortable armchairs, a sofa, and natural light',
                            'caption' => 'Jack & Jill suites offer defined personal sleeping quarters with an adjoining private bath',
                            'provenance' => 'facility',
                            'rights' => 'cleared',
                            'label' => 'Mission Villa property photograph',
                        ],
                    ],
                ],
                'cta' => [
                    'label' => 'View Floor-Plan Details',
                    'href' => '/suites-and-floor-plans',
                    'fallback_inquiry' => 'request_availability',
                    'note' => 'Ask our Daly City team about current suite openings and floor plans during your visit.',
                ],
            ],
        ],

        [
            'key' => 'lo-setting',
            'type' => 'living-options.setting',
            'enabled' => true,
            'order' => 40,
            'data' => [
                'eyebrow' => 'COMMUNITY LIFE',
                'heading' => 'A Welcoming, <em>Homelike Setting.</em>',
                'intro' => 'Whether living at Mission Villa full-time or joining us for a temporary stay, every resident and guest shares in the warmth, connection, and attentive rhythm of our community.',
                'features' => [
                    [
                        'icon' => 'utensils',
                        'title' => 'Chef-Prepared Dining',
                        'lead' => 'Nutritious & Delicious',
                        'body' => 'Three wholesome, chef-prepared meals daily served family-style in our dining room, with adaptive tableware, snacks, and personalized dietary support.',
                    ],
                    [
                        'icon' => 'sparkles',
                        'title' => 'Meaningful Engagement',
                        'lead' => 'Legacies™ Activities',
                        'body' => 'Daily life-enrichment that stimulates memory and fosters joy: music therapy, art projects, gentle fitness, reminiscence discussions, and garden time.',
                    ],
                    [
                        'icon' => 'sprout',
                        'title' => 'Enclosed Courtyard & Patio',
                        'lead' => 'Secure Outdoor Living',
                        'body' => 'A secure, beautifully landscaped outdoor courtyard where residents can stroll safely, enjoy coastal sunshine, and relax in comfortable patio seating.',
                    ],
                    [
                        'icon' => 'shield',
                        'title' => '24-Hour Attentive Support',
                        'lead' => 'Around-the-Clock Care',
                        'body' => 'Continuous on-site staff presence, emergency response systems, personal assistance with dressing and grooming, and routine wellness assessments.',
                    ],
                ],
            ],
        ],

        [
            'key' => 'lo-faq',
            'type' => 'living-options.faq',
            'enabled' => true,
            'order' => 50,
            'data' => [
                'eyebrow' => 'FREQUENTLY ASKED QUESTIONS',
                'heading' => 'Your Questions, <em>Answered.</em>',
                'intro' => 'Helpful answers to common questions about our Memory Care and Respite Care programs, suite options, and admission steps.',
                'help_card' => [
                    'title' => 'Have a question about living options?',
                    'text' => 'Our Daly City team is happy to discuss your family’s situation, check suite openings, and arrange a private tour.',
                    'phone_label' => 'Call (650) 756-1995',
                    'cta_label' => 'Request a Call',
                    'cta_intent' => 'request_callback',
                ],
                'faqs' => [
                    [
                        'id' => 'lo-faq-offerings',
                        'question' => 'Which care options does Mission Villa offer?',
                        'answer' => 'Mission Villa provides two dedicated programs: ongoing Legacies™ Memory Care for residents with Alzheimer’s or dementia, and Short-Term Respite Care for temporary stays. We do not operate standalone independent living or traditional assisted living, which allows our team to focus 100% of our attention and expertise on memory and respite support.',
                    ],
                    [
                        'id' => 'lo-faq-difference',
                        'question' => 'What is the difference between Memory Care and Respite Care?',
                        'answer' => 'Memory Care is an ongoing, long-term residential program with 24-hour assistance, predictable daily rhythms, and life-story enrichment. Respite Care offers temporary stays ranging from a few days to several weeks—giving family caregivers dependable relief or providing recovery support after illness or rehabilitation.',
                    ],
                    [
                        'id' => 'lo-faq-suites',
                        'question' => 'What suite configurations are available?',
                        'answer' => 'Mission Villa offers Private Suites, Companion Units (shared suites), and Jack & Jill suite layouts. Every suite includes private bathroom access, individual thermostat control, utilities, housekeeping, linen service, and emergency call systems. Jack & Jill suites are specifically arranged for Memory Care residents.',
                    ],
                    [
                        'id' => 'lo-faq-choice',
                        'question' => 'How do families choose the appropriate care option?',
                        'answer' => 'Our Daly City care team conducts a comprehensive pre-admission conversation and assessment to understand your loved one’s daily routine, medical history, and care needs. If you are uncertain about long-term care, a short-term respite stay is often an ideal, low-pressure way to experience our community firsthand.',
                    ],
                    [
                        'id' => 'lo-faq-tour',
                        'question' => 'Can families tour Mission Villa and inquire about accommodations?',
                        'answer' => 'Yes, we warmly encourage families to tour our community at 995 East Market Street in Daly City. You can walk through our suites, visit the dining room and secure courtyard, and meet our care team. Call (650) 756-1995 or schedule a visit online to arrange a convenient time.',
                    ],
                ],
            ],
        ],

        [
            'key' => 'lo-cta',
            'type' => 'visit.cta',
            'enabled' => true,
            'order' => 60,
            'data' => [
                'script' => 'Let’s Connect',
                'heading' => 'Talk With Our Care Team',
                'body' => 'Explore living options, understand care choices, and schedule a tour of our welcoming Daly City community.',
                'care' => 'exploring',
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
                    'heading' => 'Living Options Inquiry',
                    'lede' => 'A member of our Daly City care team will be in touch soon to answer your questions.',
                ],
            ],
        ],
    ],
];
