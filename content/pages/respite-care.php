<?php

/*
|--------------------------------------------------------------------------
| Respite Care page content definition (slug: "respite-care")
|--------------------------------------------------------------------------
| Verified against the React reference (app/respite-care/page.tsx and
| lib/mission-villa-data.ts), the approved design mockup, and the
| Mission Villa design standard (.agents/skills/missionvilla-design-standard/).
|
| Business rule: every form CTA opens the shared inquiry modal with
| care interest preselected to "respite_care".
*/

return [
    'slug' => 'respite-care',
    'title' => 'Short-Term Respite Care | Mission Villa Senior Living',
    'seo' => [
        'title' => 'Short-Term Respite Care in Daly City | Mission Villa Senior Living',
        'description' => 'Flexible short-term respite care stays in Daly City. Welcoming accommodations, 24/7 personalized care, chef-prepared meals, and peace of mind for family caregivers.',
        'og_image' => '/images/hero/respite-quiet-reading-2000.webp',
    ],
    'sections' => [
        [
            'key' => 'rc-hero',
            'type' => 'respite-care.hero',
            'enabled' => true,
            'order' => 10,
            'data' => [
                'eyebrow' => 'Short-Term Stays at Mission Villa',
                'heading' => 'Short-Term Respite Care',
                'editorial' => 'Flexible support, welcoming stays, and <em>peace of mind for families.</em>',
                'intro' => 'Temporary stays that provide compassionate care, a comfortable place to stay, and supportive daily routines—while caregivers rest, travel, or navigate recovery.',
                'image' => [
                    'src' => '/images/hero/respite-quiet-reading-2000.webp',
                    'src_mobile' => '/images/hero/respite-quiet-reading-1200.webp',
                    'width' => 2000,
                    'height' => 1333,
                    'alt' => 'Warm, sunlit room at Mission Villa with an older resident relaxing comfortably with a warm drink',
                    'provenance' => 'illustrative',
                    'rights' => 'cleared',
                    'label' => 'Illustrative image · not actual residents',
                ],
                'strip' => [
                    [
                        'icon' => 'calendar',
                        'kicker' => 'Stay Duration',
                        'title' => 'Flexible Short-Term Stays',
                        'desc' => 'From a few days to several weeks, based on your needs.',
                    ],
                    [
                        'icon' => 'bed',
                        'kicker' => 'Accommodations',
                        'title' => 'Private & Companion Suites',
                        'desc' => 'Comfortable, fully-furnished accommodations.',
                    ],
                    [
                        'icon' => 'pin',
                        'kicker' => 'Location',
                        'title' => 'Daly City, California',
                        'desc' => 'A welcoming, residential setting near home.',
                    ],
                ],
                'actions' => [
                    [
                        'label' => 'Inquire About Respite Availability',
                        'style' => 'primary',
                        'icon' => 'calendar',
                        'intent' => 'request_availability',
                        'care' => 'respite_care',
                    ],
                    [
                        'label' => 'See How a Short-Term Stay Works',
                        'style' => 'secondary',
                        'icon' => 'arrow',
                        'href' => '#respite-planning',
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
            'key' => 'rc-scenarios',
            'type' => 'respite-care.scenarios',
            'enabled' => true,
            'order' => 20,
            'data' => [
                'eyebrow' => 'Why Families Choose Respite Care',
                'heading' => 'Support When You Need It <em>Most.</em>',
                'intro' => 'A flexible, short-term care option that brings relief, support, and confidence—for both you and your loved one.',
                'scenarios' => [
                    [
                        'id' => 'caregiver-recharge',
                        'tab_label' => 'Caregiver Rest & Renewal',
                        'icon' => 'heart',
                        'kicker' => 'Featured Scenario',
                        'title' => 'Caregiver Rest & Renewal',
                        'subtitle' => 'A trusted place to stay while you take time for yourself.',
                        'narrative' => 'Caring for a loved one is meaningful—and at times, demanding. A short-term respite stay at Mission Villa gives you time to rest, recharge, and tend to your own well-being, knowing your loved one is in a safe, supportive environment with a caring team.',
                        'points' => [
                            'A comfortable, engaging stay with caring support',
                            'Consistent daily routines and meaningful activities',
                            'Peace of mind while you rest and renew',
                        ],
                        'image' => [
                            'src' => '/images/care/respite-care-welcome-1402.webp',
                            'src_mobile' => '/images/care/respite-care-welcome-900.webp',
                            'width' => 1402,
                            'height' => 1122,
                            'alt' => 'Warm caregiver welcoming a senior guest into Mission Villa with care and respect',
                            'provenance' => 'illustrative',
                            'rights' => 'cleared',
                            'label' => 'Illustrative image · not actual residents',
                            'caption' => 'Welcoming respite care environment designed for relaxation and comfort',
                        ],
                    ],
                    [
                        'id' => 'travel-commitments',
                        'tab_label' => 'Family Travel or Commitments',
                        'icon' => 'briefcase',
                        'kicker' => 'Featured Scenario',
                        'title' => 'Family Travel or Commitments',
                        'subtitle' => 'When work, travel, or family milestones call you away.',
                        'narrative' => 'Instead of piecing together rotating in-home coverage while you are away for travel, business, or family milestones, Respite Care provides a consistent, homelike environment. Your loved one enjoys furnished accommodations, dining, and attentive 24-hour support.',
                        'points' => [
                            'Short-term stays tailored to your family’s travel dates',
                            'Comfortable furnished suite accommodations with a private bathroom',
                            'Peace of mind knowing meals, activities, and daily care are handled',
                        ],
                        'image' => [
                            'src' => '/images/suites/community-lounge-facility-899.webp',
                            'src_mobile' => '/images/suites/community-lounge-facility-640.webp',
                            'width' => 899,
                            'height' => 601,
                            'alt' => 'Mission Villa community lounge with comfortable seating and natural daylight',
                            'provenance' => 'facility',
                            'rights' => 'cleared',
                            'label' => 'Mission Villa facility photograph · Daly City, CA',
                            'caption' => 'Welcoming community lounge space for conversation and relaxing',
                        ],
                    ],
                    [
                        'id' => 'recovery-support',
                        'tab_label' => 'Recovery & Transitional Support',
                        'icon' => 'check-circle',
                        'kicker' => 'Featured Scenario',
                        'title' => 'Recovery & Transitional Support',
                        'subtitle' => 'When extra daily assistance helps after an illness or hospital stay.',
                        'narrative' => 'Returning directly home after an illness or hospital stay can feel challenging without extra help. A temporary stay at Mission Villa offers a calm, supportive setting where daily living assistance, nutritious meals, and attentive staff help your loved one regain everyday comfort.',
                        'points' => [
                            'Pre-stay care review to understand daily assistance preferences',
                            'Respectful help with bathing, dressing, and daily routines',
                            'Housekeeping and freshly prepared meals so your loved one can rest',
                        ],
                        'image' => [
                            'src' => '/images/hero/family-connection-2000.webp',
                            'src_mobile' => '/images/hero/family-connection-1200.webp',
                            'width' => 2000,
                            'height' => 1333,
                            'alt' => 'Senior resident smiling warmly in a bright, homelike community room',
                            'provenance' => 'illustrative',
                            'rights' => 'cleared',
                            'label' => 'Illustrative image · not actual residents',
                            'caption' => 'Attentive, respectful daily assistance tailored to personal comfort',
                        ],
                    ],
                    [
                        'id' => 'community-introduction',
                        'tab_label' => 'Gentle Introduction to Community Life',
                        'icon' => 'people',
                        'kicker' => 'Featured Scenario',
                        'title' => 'Gentle Introduction to Community Life',
                        'subtitle' => 'Experience Mission Villa firsthand before making longer-term plans.',
                        'narrative' => 'A Respite Care stay can serve as a gentle, reassuring introduction to life at Mission Villa. Guests experience our homelike setting, meet staff and neighbors, and participate in daily activities—helping families make longer-term care decisions with confidence.',
                        'points' => [
                            'Full participation in community dining and social gatherings',
                            'Opportunity to become familiar with staff and routines at an unhurried pace',
                            'Open, pressure-free conversations if your family later explores permanent care',
                        ],
                        'image' => [
                            'src' => '/images/life/meaningful-connection-illustrative-1402.webp',
                            'src_mobile' => '/images/life/meaningful-connection-illustrative-960.webp',
                            'width' => 1402,
                            'height' => 789,
                            'alt' => 'Senior residents enjoying a warm creative activity together',
                            'provenance' => 'illustrative',
                            'rights' => 'cleared',
                            'label' => 'Illustrative image · not actual residents',
                            'caption' => 'Warm social engagement and daily connection in our community',
                        ],
                    ],
                ],
            ],
        ],

        [
            'key' => 'rc-inclusions',
            'type' => 'respite-care.inclusions',
            'enabled' => true,
            'order' => 30,
            'data' => [
                'eyebrow' => 'What’s Included in a Stay',
                'heading' => 'Comfort, Care & <em>Everyday Support.</em>',
                'intro' => 'A complete, worry-free stay with the comforts of home, personalized care, and a welcoming community experience.',
                'note' => 'Availability and specific inclusions are confirmed with our team for each stay.',
                'items' => [
                    [
                        'id' => 'meals',
                        'title' => 'Chef-Prepared Meals',
                        'icon' => 'utensils',
                        'description' => 'Nutritious, flavorful meals served fresh daily, with preferences and dietary needs in mind.',
                        'theme' => 'media_lead',
                        'image' => [
                            'src' => '/images/life/dining-daily-life-illustrative-1672.webp',
                            'width' => 1672,
                            'height' => 940,
                            'alt' => 'Chef-prepared nutritious dining served in a bright community dining room',
                            'provenance' => 'illustrative',
                            'rights' => 'cleared',
                            'label' => 'Illustrative dining image',
                        ],
                    ],
                    [
                        'id' => 'accommodations',
                        'title' => 'Furnished Accommodations',
                        'icon' => 'bed',
                        'description' => 'A comfortable, move-in ready space with the essentials for a relaxed stay.',
                        'theme' => 'media_card',
                        'image' => [
                            'src' => '/images/suites/suite-bedroom-facility-899.webp',
                            'width' => 899,
                            'height' => 601,
                            'alt' => 'Authentic furnished suite bedroom at Mission Villa Senior Living with comfortable bed and private bath',
                            'provenance' => 'facility',
                            'rights' => 'cleared',
                            'label' => 'Mission Villa facility suite',
                        ],
                    ],
                    [
                        'id' => 'assistance',
                        'title' => 'Thoughtful Daily Assistance',
                        'icon' => 'heart-handshake',
                        'description' => 'Respectful support with daily routines, as needed, from a caring and attentive team.',
                        'theme' => 'cream',
                    ],
                    [
                        'id' => 'daily_life',
                        'title' => 'Engaging Daily Life',
                        'icon' => 'people',
                        'description' => 'Opportunities to socialize, stay active, and enjoy enriching experiences.',
                        'theme' => 'cream',
                    ],
                    [
                        'id' => 'hospitality',
                        'title' => 'Housekeeping & Hospitality',
                        'icon' => 'sparkles',
                        'description' => 'A clean, comfortable space with daily housekeeping and linen service.',
                        'theme' => 'cream',
                    ],
                    [
                        'id' => 'coordination',
                        'title' => 'Care Coordination & Assessment',
                        'icon' => 'file-text',
                        'description' => 'A personalized approach with a care review to ensure a safe, supportive, and successful stay.',
                        'theme' => 'plum',
                    ],
                ],
            ],
        ],

        [
            'key' => 'rc-story',
            'type' => 'respite-care.story',
            'enabled' => true,
            'order' => 40,
            'data' => [
                'eyebrow' => 'What a Short-Term Stay Can Look Like',
                'heading' => 'A Welcoming Stay, <em>From Start to Finish.</em>',
                'intro' => 'A simple, comfortable rhythm that helps your loved one feel at home—even for a short stay.',
                'moments' => [
                    [
                        'id' => 'arrival',
                        'title' => 'Arrival & Settling In',
                        'icon' => 'calendar',
                        'description' => 'A warm welcome, time to settle into a private or companion suite, unpack, and get comfortable with friendly faces.',
                        'image' => [
                            'src' => '/images/care/respite-care-welcome-1402.webp',
                            'src_mobile' => '/images/care/respite-care-welcome-900.webp',
                            'width' => 1402,
                            'height' => 1122,
                            'alt' => 'New guest arriving warmly at Mission Villa with staff assistance',
                            'provenance' => 'illustrative',
                            'rights' => 'cleared',
                            'label' => 'Illustrative image · not actual residents',
                        ],
                    ],
                    [
                        'id' => 'meals-activities',
                        'title' => 'Shared Meals & Gentle Activity',
                        'icon' => 'utensils',
                        'description' => 'Enjoy delicious meals, friendly conversation, and a variety of low-key, enriching activities.',
                        'image' => [
                            'src' => '/images/life/dining-daily-life-illustrative-1672.webp',
                            'src_mobile' => '/images/life/dining-daily-life-illustrative-960.webp',
                            'width' => 1672,
                            'height' => 940,
                            'alt' => 'Seniors sharing conversation over a warm meal in the dining room',
                            'provenance' => 'illustrative',
                            'rights' => 'cleared',
                            'label' => 'Illustrative image · not actual residents',
                        ],
                    ],
                    [
                        'id' => 'evenings',
                        'title' => 'Restful Evenings & Reassurance',
                        'icon' => 'moon',
                        'description' => 'A calm, comfortable environment and a caring team nearby for added peace of mind.',
                        'image' => [
                            'src' => '/images/hero/respite-quiet-reading-2000.webp',
                            'src_mobile' => '/images/hero/respite-quiet-reading-1200.webp',
                            'width' => 2000,
                            'height' => 1333,
                            'alt' => 'Senior resident relaxing in a cozy, quiet corner with warm reading light',
                            'provenance' => 'illustrative',
                            'rights' => 'cleared',
                            'label' => 'Illustrative image · not actual residents',
                        ],
                    ],
                ],
            ],
        ],

        [
            'key' => 'rc-caregiver',
            'type' => 'respite-care.caregiver',
            'enabled' => true,
            'order' => 50,
            'data' => [
                'eyebrow' => 'Caregiver Support',
                'heading' => 'Caring for the Caregiver.',
                'subtitle' => 'Take Time to Rest.',
                'narrative' => 'A short-term stay at Mission Villa gives you the space to rest, travel, or focus on your own needs—knowing your loved one is in a safe, familiar, and compassionate environment. Our team is experienced in supporting older adults, including those living with memory loss, with patience, respect, and personalized care.',
                'actions' => [
                    [
                        'label' => 'Inquire About Respite Availability',
                        'style' => 'primary',
                        'icon' => 'calendar',
                        'intent' => 'request_availability',
                        'care' => 'respite_care',
                    ],
                    [
                        'label' => 'Learn About Memory Care',
                        'style' => 'secondary',
                        'icon' => 'arrow',
                        'href' => '/memory-care',
                    ],
                ],
                'concepts' => [
                    [
                        'title' => 'Peace of Mind',
                        'desc' => 'Trusted, around-the-clock support in a secure, welcoming setting.',
                        'icon' => 'shield',
                    ],
                    [
                        'title' => 'Memory-Loss Familiarity',
                        'desc' => 'A team experienced in caring for individuals living with Alzheimer’s and other forms of dementia.',
                        'icon' => 'heart',
                    ],
                    [
                        'title' => 'Compassionate, Temporary Support',
                        'desc' => 'Person-centered care and a warm, respectful approach throughout the stay.',
                        'icon' => 'sprout',
                    ],
                ],
            ],
        ],

        [
            'key' => 'rc-timeline',
            'type' => 'respite-care.timeline',
            'enabled' => true,
            'order' => 60,
            'data' => [
                'eyebrow' => 'A Simple, Supportive Process',
                'heading' => 'A Simple Stay-Planning <em>Timeline.</em>',
                'intro' => 'Getting started is straightforward. Our team is here to guide you at every step.',
                'note' => 'Arrangements, dates, and stay guidelines are confirmed with our team.',
                'steps' => [
                    [
                        'step' => '1',
                        'title' => 'Reach Out',
                        'icon' => 'phone',
                        'summary' => 'Contact our team to talk about your needs and ask questions.',
                        'detail' => 'Call our Daly City team at (650) 756-1995 or send an inquiry. We’ll discuss your timeline, care goals, and current availability.',
                    ],
                    [
                        'step' => '2',
                        'title' => 'Care Review',
                        'icon' => 'file-text',
                        'summary' => 'We’ll learn about your loved one’s preferences, routines, and any care needs.',
                        'detail' => 'A relaxed conversation to understand daily habits, favorite foods, mobility support, and any memory-loss considerations.',
                    ],
                    [
                        'step' => '3',
                        'title' => 'Choose Dates',
                        'icon' => 'calendar',
                        'summary' => 'Select a stay length that works for your family (from days to weeks).',
                        'detail' => 'Coordinate dates that match your travel schedule or recovery window, based on available furnished suites.',
                    ],
                    [
                        'step' => '4',
                        'title' => 'Prepare for Arrival',
                        'icon' => 'briefcase',
                        'summary' => 'We’ll share what to bring and help you get ready for a smooth stay.',
                        'detail' => 'We’ll provide simple packing recommendations, paperwork guidance, and coordinate arrival timing with your family.',
                    ],
                    [
                        'step' => '5',
                        'title' => 'Welcome to Mission Villa',
                        'icon' => 'heart',
                        'summary' => 'Your loved one is greeted by our caring team and supported from day one.',
                        'detail' => 'Our staff greets your loved one warmly, helps them unpack familiar belongings, and introduces them to dining and neighbors.',
                    ],
                ],
            ],
        ],

        [
            'key' => 'rc-faq',
            'type' => 'respite-care.faq',
            'enabled' => true,
            'order' => 70,
            'data' => [
                'eyebrow' => 'Respite Care FAQ',
                'heading' => 'Your Questions, <em>Answered.</em>',
                'intro' => 'Helpful information to support your planning, plus a few key questions to consider as you explore short-term respite care at Mission Villa.',
                'guide' => [
                    'title' => 'Respite Stay Planning Guide',
                    'kicker' => 'Helpful Considerations',
                    'checklist' => [
                        'How long of a stay would be helpful?',
                        'What level of daily support is needed?',
                        'Are there any health or memory considerations?',
                    ],
                    'action' => [
                        'label' => 'Inquire About Planning',
                        'intent' => 'request_availability',
                        'care' => 'respite_care',
                    ],
                ],
                'faqs' => [
                    [
                        'id' => 'rc-faq-duration',
                        'question' => 'How long can a respite stay be?',
                        'answer' => 'Respite Care at Mission Villa is designed for flexible short-term stays—often ranging from a few days to several weeks depending on your family’s needs and current suite availability. Contact our Daly City team at (650) 756-1995 to check current openings for your desired dates.',
                    ],
                    [
                        'id' => 'rc-faq-included',
                        'question' => 'What’s included in a short-term stay?',
                        'answer' => 'A Respite Care stay includes comfortable furnished accommodations with a private bathroom, 24-hour on-site staff support, personalized assistance with daily routines (such as bathing, dressing, and grooming), three chef-prepared meals and snacks daily, engaging community activities, housekeeping, and linen service.',
                    ],
                    [
                        'id' => 'rc-faq-memory',
                        'question' => 'Can you support someone with memory loss during a respite stay?',
                        'answer' => 'Yes. Because Mission Villa specializes in compassionate Memory Care through our Legacies™ program, our staff and homelike setting are well suited to welcoming short-term guests living with memory loss—provided our pre-stay care review confirms we can safely meet their individual needs.',
                    ],
                    [
                        'id' => 'rc-faq-choice',
                        'question' => 'How do we know if respite care is the right choice?',
                        'answer' => 'Respite Care is ideal when family caregivers need time to rest, when upcoming travel requires temporary support, during recovery after illness, or when families want to gently experience Mission Villa before making a longer-term memory care decision.',
                    ],
                    [
                        'id' => 'rc-faq-start',
                        'question' => 'How do I check availability and get started?',
                        'answer' => 'Getting started is as simple as calling our Daly City team at (650) 756-1995 or submitting an availability inquiry online. We will discuss your dates, care needs, and guide you through each planning step.',
                    ],
                ],
            ],
        ],

        [
            'key' => 'rc-cta',
            'type' => 'visit.cta',
            'enabled' => true,
            'order' => 80,
            'data' => [
                'script' => 'Let’s Connect',
                'heading' => 'Talk With Our Respite Care Team',
                'body' => 'Explore short-term stay options, get answers to your questions, and see how Mission Villa can provide the support you need—for your loved one and for you.',
                'care' => 'respite_care',
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
                    'heading' => 'Respite Care Inquiry',
                    'lede' => 'A member of our team will be in touch soon to discuss availability and next steps.',
                ],
            ],
        ],
    ],
];
