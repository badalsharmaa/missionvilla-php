<?php

/*
|--------------------------------------------------------------------------
| Life at Mission Villa page content definition (slug: "life-at-mission-villa")
|--------------------------------------------------------------------------
| Verified against the React reference (app/life-at-mission-villa/page.tsx
| and lib/mission-villa-data.ts), the Mission Villa design standard,
| and the developer handoff playbook.
|
| Business rule: every form CTA opens the shared inquiry modal with
| care interest preselected to "exploring" (or specific care program).
| Provenance rule: clarify authentic facility photos vs illustrative imagery.
*/

return [
    'slug' => 'life-at-mission-villa',
    'title' => 'Life at Mission Villa | Memory Care Community Culture & Dining',
    'seo' => [
        'title' => 'Life at Mission Villa: Dining, Routine & Connection in Daly City',
        'description' => 'Discover daily life at Mission Villa in Daly City. Chef-prepared dining, reassuring daily routines, music, creative enrichment, and sunny courtyard garden strolls.',
        'og_image' => '/images/life/dining-daily-life-illustrative-1672.webp',
    ],
    'sections' => [
        [
            'key' => 'lmv-hero',
            'type' => 'life-at-mission-villa.hero',
            'enabled' => true,
            'order' => 10,
            'data' => [
                'eyebrow' => 'Community Culture & Daily Life',
                'heading' => 'Where Every Day Feels <em>Familiar, Connected & Warm.</em>',
                'editorial' => 'Nourishing meals, unhurried routines, and purposeful engagement in Daly City.',
                'intro' => 'Life at Mission Villa is shaped around what brings each resident comfort and joy—from the aroma of morning coffee and chef-prepared meals to gentle music, creative workshops, and peaceful courtyard garden walks.',
                'image' => [
                    'src' => '/images/life/dining-daily-life-illustrative-1672.webp',
                    'src_mobile' => '/images/life/dining-daily-life-illustrative-960.webp',
                    'width' => 1672,
                    'height' => 1115,
                    'alt' => 'Older adults sharing a pleasant meal at a dining table with smiling table service',
                    'provenance' => 'illustrative',
                    'rights' => 'cleared',
                    'label' => 'Illustrative community life photograph',
                ],
                'strip' => [
                    [
                        'icon' => 'utensils',
                        'kicker' => 'Chef-Prepared',
                        'title' => 'Full-Table Dining',
                        'desc' => 'Three freshly prepared daily meals with restaurant-style table service.',
                    ],
                    [
                        'icon' => 'sparkles',
                        'kicker' => 'Purposeful Routine',
                        'title' => 'Gentle Enrichment',
                        'desc' => 'Music, sensory engagement, and creative art workshops led with dignity.',
                    ],
                    [
                        'icon' => 'heart',
                        'kicker' => 'Outdoor Living',
                        'title' => 'Courtyard Gardens',
                        'desc' => 'Secure outdoor patio and raised garden beds for fresh coastal air.',
                    ],
                ],
                'actions' => [
                    [
                        'label' => 'Experience Daily Life on Tour',
                        'style' => 'primary',
                        'icon' => 'calendar',
                        'intent' => 'schedule_visit',
                        'care' => 'exploring',
                    ],
                    [
                        'label' => 'Request Life & Care Guide',
                        'style' => 'secondary',
                        'icon' => 'arrow',
                        'intent' => 'general_inquiry',
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
            'key' => 'lmv-pillars',
            'type' => 'life-at-mission-villa.pillars',
            'enabled' => true,
            'order' => 20,
            'data' => [
                'eyebrow' => 'Core Lifestyle Pillars',
                'heading' => 'A Culture of <em>Nourishment, Sanctuary & Friendship.</em>',
                'intro' => 'Three central pillars shape each day at Mission Villa, blending homelike comfort with personalized memory support.',
                'pillars' => [
                    [
                        'id' => 'pillar-dining',
                        'code' => 'PILLAR 01 · CULINARY WARMTH',
                        'cutout_label' => 'Dining & Hospitality',
                        'title' => 'Chef-Prepared Daily Meals',
                        'subtitle' => 'Restaurant-style table hospitality and comforting recipes',
                        'summary' => 'Our dining room is the social heart of the house. Residents gather three times daily for chef-crafted meals served with attentive table hospitality—turning mealtime into an unhurried celebration of flavor and connection.',
                        'highlights' => [
                            'Freshly prepared menus crafted for nutritional balance and flavor',
                            'Restaurant-style table service encouraging appetite and unhurried conversation',
                            'Dietary accommodations, texture modifications, and hydration stations',
                            'Private family dining room available for birthdays and family celebrations',
                        ],
                        'image' => [
                            'src' => '/images/life/dining-daily-life-illustrative-1672.webp',
                            'width' => 1672,
                            'height' => 1115,
                            'alt' => 'Residents gathered around an inviting community dining table',
                            'provenance' => 'illustrative',
                            'rights' => 'cleared',
                            'label' => 'Dining hospitality illustration',
                        ],
                    ],
                    [
                        'id' => 'pillar-enrichment',
                        'code' => 'PILLAR 02 · CREATIVE VITALITY',
                        'cutout_label' => 'Music & Engagement',
                        'title' => 'Thoughtful Daily Engagement',
                        'subtitle' => 'Music, creative expression, and reminiscence',
                        'summary' => 'Meaningful engagement sparks joy and self-expression. Guided by our activities team, residents take part in music therapy, creative art workshops, gentle exercise, and trivia that celebrate lifelong passions.',
                        'highlights' => [
                            'Daily scheduled activities tailored to varied cognitive abilities',
                            'Music programs and playlist therapy that stimulate memory recall',
                            'Gentle chair yoga and physical wellness sessions',
                            'Scenic drives and supervised outings throughout the Bay Area',
                        ],
                        'image' => [
                            'src' => '/images/life/meaningful-connection-illustrative-1402.webp',
                            'width' => 1402,
                            'height' => 935,
                            'alt' => 'Resident and companion laughing together during a creative activity',
                            'provenance' => 'illustrative',
                            'rights' => 'cleared',
                            'label' => 'Creative engagement illustration',
                        ],
                    ],
                    [
                        'id' => 'pillar-courtyard',
                        'code' => 'PILLAR 03 · SANCTUARY & OUTDOORS',
                        'cutout_label' => 'Courtyard & Patio',
                        'title' => 'Sunlit Courtyard & Gardens',
                        'subtitle' => 'Secure outdoor patio and peaceful coastal breezes',
                        'summary' => 'Our secure central courtyard allows residents to step outside freely into fresh coastal air. Shaded umbrella seating, raised flower beds, and walking pathways provide a peaceful connection to nature.',
                        'highlights' => [
                            'Enclosed, secure courtyard designed specifically for memory care safety',
                            'Comfortable patio tables with umbrellas for alfresco visits with loved ones',
                            'Raised garden beds and seasonal flowers that engage touch and scent',
                            'Fireside indoor lounges right beside patio garden exits',
                        ],
                        'image' => [
                            'src' => '/images/why-families/courtyard-patio-facility-1024.webp',
                            'width' => 1024,
                            'height' => 768,
                            'alt' => 'Mission Villa sunny outdoor courtyard with patio tables and flowering garden borders',
                            'provenance' => 'facility',
                            'rights' => 'cleared',
                            'label' => 'Mission Villa courtyard photograph',
                        ],
                    ],
                ],
            ],
        ],

        [
            'key' => 'lmv-rhythm',
            'type' => 'life-at-mission-villa.rhythm',
            'enabled' => true,
            'order' => 30,
            'data' => [
                'eyebrow' => 'A Day in the Life',
                'heading' => 'A Reassuring Daily Rhythm, <em>Never Rushed.</em>',
                'intro' => 'Rather than a rigid, stressful schedule, days at Mission Villa flow with gentle structure that fosters confidence, orientation, and peace.',
                'moments' => [
                    [
                        'time' => 'Morning · 7:30 AM – 10:00 AM',
                        'icon' => 'sun',
                        'title' => 'Unhurried Awakening & Breakfast',
                        'lead' => 'Gentle Awakening at Personal Pace',
                        'body' => 'Residents wake naturally without jarring bells. Caregivers provide respectful grooming and dressing support before escorting residents to a freshly prepared breakfast with warm coffee.',
                        'touchpoint' => 'Aroma of morning roast and warm bakery dishes in the dining room.',
                    ],
                    [
                        'time' => 'Midday · 10:30 AM – 1:30 PM',
                        'icon' => 'utensils',
                        'title' => 'Active Engagement & Shared Lunch',
                        'lead' => 'Social Warmth and Lively Tables',
                        'body' => 'Morning chair fitness or music reminiscence transitions into a sociable, chef-prepared lunch. Full-table service and dietary modifications ensure enjoyable dining for all.',
                        'touchpoint' => 'Restaurant-style table hospitality fostering friendship.',
                    ],
                    [
                        'time' => 'Afternoon · 2:00 PM – 5:00 PM',
                        'icon' => 'sparkles',
                        'title' => 'Creative Expression & Garden Time',
                        'lead' => 'Courtyard Strolls & Artistic Projects',
                        'body' => 'Afternoons offer quiet rest or lively pursuits—painting workshops, scenic van drives through local Daly City coastal landmarks, and leisurely garden strolls.',
                        'touchpoint' => 'Secure outdoor patio with fresh breezes and shaded seating.',
                    ],
                    [
                        'time' => 'Evening · 5:30 PM – 8:00 PM',
                        'icon' => 'moon',
                        'title' => 'Comforting Dinner & Wind-Down',
                        'lead' => 'Calming Transitions into Night',
                        'body' => 'An evening meal shared with friends is followed by soothing music, warm tea, and quiet bedtime rituals that minimize sundowning and promote restful sleep.',
                        'touchpoint' => 'Dimmed lighting and familiar bedtime reassurance in private suites.',
                    ],
                ],
                'disclaimer' => 'Daily rhythms adapt flexibly to each individual resident’s preferences, stamina, and wakefulness patterns rather than adhering to rigid institutional timetables.',
            ],
        ],

        [
            'key' => 'lmv-engagement',
            'type' => 'life-at-mission-villa.engagement',
            'enabled' => true,
            'order' => 40,
            'data' => [
                'eyebrow' => 'Programs & Activities',
                'heading' => 'Enrichment That Honors <em>Every Life Story.</em>',
                'intro' => 'Our activities director curates varied opportunities for residents to express creativity, celebrate heritage, and stay physically energized.',
                'activities' => [
                    [
                        'icon' => 'music',
                        'kicker' => 'Sensory & Memory',
                        'title' => 'Music & Reminiscence Therapy',
                        'desc' => 'Familiar melodies from early adulthood have a remarkable ability to spark vivid memories, ease anxiety, and bring genuine smiles.',
                        'bullets' => [
                            'Live acoustic and vocal musical performances',
                            'Personalized favorite-artist listening sessions',
                            'Group sing-alongs and rhythm circles',
                        ],
                    ],
                    [
                        'icon' => 'palette',
                        'kicker' => 'Hands-On Expression',
                        'title' => 'Creative Arts & Crafts',
                        'desc' => 'Engaging hands and minds through painting, floral arrangement, and seasonal baking projects adapted for dexterity and comfort.',
                        'bullets' => [
                            'Watercolor painting and sensory clay sculpting',
                            'Holiday and cultural festival crafting',
                            'Memory-book creation honoring personal careers',
                        ],
                    ],
                    [
                        'icon' => 'bus',
                        'kicker' => 'Community Connection',
                        'title' => 'Scenic Drives & Outings',
                        'desc' => 'Residents enjoy supervised coastal drives through the San Francisco Peninsula, scenic park visits, and ice cream outings.',
                        'bullets' => [
                            'Comfortable, accessible community van outings',
                            'Pacific coast scenic viewing drives',
                            'Caregiver-accompanied leisurely excursions',
                        ],
                    ],
                    [
                        'icon' => 'sprout',
                        'kicker' => 'Nature & Wellness',
                        'title' => 'Gardening & Gentle Movement',
                        'desc' => 'Connecting with earth, sunlight, and light physical movement helps maintain mobility, appetite, and circadian sleep rhythm.',
                        'bullets' => [
                            'Raised planter box gardening and herb planting',
                            'Morning chair stretching and balance exercises',
                            'Daily walking club along secure courtyard paths',
                        ],
                    ],
                ],
                'action' => [
                    'label' => 'Request Sample Activity Calendar',
                    'intent' => 'general_inquiry',
                    'note' => 'Our Daly City team is happy to send this month’s full activities and outing calendar.',
                ],
            ],
        ],

        [
            'key' => 'lmv-faq',
            'type' => 'life-at-mission-villa.faq',
            'enabled' => true,
            'order' => 50,
            'data' => [
                'eyebrow' => 'Community Life FAQs',
                'heading' => 'Frequently Asked <em>Lifestyle Questions.</em>',
                'intro' => 'Answers to common questions about dining, visiting hours, dietary needs, and activity participation.',
                'help_card' => [
                    'title' => 'Have Questions About Daily Life at Mission Villa?',
                    'text' => 'We invite you to join us for a meal or visit during an activity hour to see our warm, connected community firsthand.',
                    'phone_label' => 'Call (650) 756-1995',
                    'cta_label' => 'Schedule a Lunch Tour',
                    'cta_intent' => 'schedule_visit',
                ],
                'faqs' => [
                    [
                        'id' => 'faq-dining-family',
                        'question' => 'Can family members join residents for meals or celebrate special occasions?',
                        'answer' => 'Yes, absolutely! Families are always welcome to join loved ones for meals in our dining room, or reserve our private family dining room to celebrate birthdays, anniversaries, and holidays together with a customized chef-prepared meal.',
                    ],
                    [
                        'id' => 'faq-dietary-accommodations',
                        'question' => 'How does Mission Villa handle special dietary needs and preferences?',
                        'answer' => 'Our culinary and nursing teams accommodate low-sodium, diabetic, vegetarian, mechanical soft, and pureed diets. We also consult closely with families to prepare favorite comforting cultural dishes that residents have enjoyed all their lives.',
                    ],
                    [
                        'id' => 'faq-reluctant-activities',
                        'question' => 'What if my loved one is quiet or reluctant to participate in group activities?',
                        'answer' => 'Participation is always an invitation, never an obligation. Our care team introduces residents to gentle one-on-one activities, quiet reading time in the lounge, or simple garden walks until they feel naturally comfortable joining small groups.',
                    ],
                    [
                        'id' => 'faq-visiting-hours',
                        'question' => 'What are the community visiting hours for families?',
                        'answer' => 'Mission Villa welcomes family visits 7 days a week. We consider families essential partners in their loved one’s care and happiness, and there are comfortable indoor lounges and garden seating for peaceful visits.',
                    ],
                    [
                        'id' => 'faq-religious-cultural',
                        'question' => 'Are religious, spiritual, or cultural services offered?',
                        'answer' => 'Yes. We host volunteer chaplain visits, spiritual reading groups, and celebrate diverse cultural and faith-based holidays throughout the year to honor each resident’s personal background.',
                    ],
                    [
                        'id' => 'faq-leaving-for-outings',
                        'question' => 'Can families take their loved one out for day trips or doctor appointments?',
                        'answer' => 'Yes. Families may sign out their loved one for doctor appointments, family dinners, or weekend outings whenever clinically appropriate. Our care staff will ensure medications and travel instructions are prepared in advance.',
                    ],
                ],
            ],
        ],

        [
            'key' => 'lmv-cta',
            'type' => 'visit.cta',
            'enabled' => true,
            'order' => 60,
            'data' => [
                'script' => 'Experience Our Warmth',
                'heading' => 'Join Us for Lunch or a Community Tour',
                'body' => 'See our vibrant dining room, meet our engaging life enrichment team, and experience the warm fellowship of Mission Villa in Daly City.',
                'care' => 'exploring',
                'actions' => [
                    [
                        'intent' => 'schedule_visit',
                        'label' => 'Schedule a Lunch Visit',
                        'icon' => 'calendar',
                    ],
                    [
                        'intent' => 'request_pricing',
                        'label' => 'Request Pricing & Guide',
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
                    'heading' => 'Life at Mission Villa Inquiry',
                    'lede' => 'Submissions save locally while we finalize direct staff notifications. For immediate assistance or current availability, please call us directly at (650) 756-1995.',
                ],
            ],
        ],
    ],
];
