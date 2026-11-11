<?php

/*
|--------------------------------------------------------------------------
| Page #13: Contact, Tour Scheduling & Directions Hub (/contact)
|--------------------------------------------------------------------------
| Source-grounded content file reflecting app/contact/page.tsx from the
| React reference. Contains 6 approved sections:
| 1. contact-hero        (Direct hospitality desk, verified trio & arrival monograph)
| 2. contact-studio      (Editorial contact studio & guided inquiry / visit request form)
| 3. contact-directions  (Grounded map, Peninsula corridors & accessible arrival)
| 4. contact-workflow    (What happens after submitting / production vs prototype)
| 5. contact-referral    (Family/friend and professional care referral pathways)
| 6. contact-faq         (Contact, visit & accessibility FAQs with contextual bridges)
|
| Note: VisitAndFooterSection on /contact sets hideVisitSection=true because
| Section 2 is already the full visit request studio. Standard footer follows.
*/

return [
    'slug' => 'contact',
    'title' => 'Contact Us & Schedule a Visit | Mission Villa Senior Living',
    'status' => 'published',
    'header_variant' => 'solid',
    'seo' => [
        'title' => 'Contact Us & Schedule a Visit | Mission Villa Daly City',
        'description' => 'Connect with Mission Villa Senior Living in Daly City. Call 650-756-1995, explore directions via I-280 and BART, or preview a personal visit request.',
        'og_image' => '/images/property/courtyard-patio.webp',
    ],
    'sections' => [
        // ====================================================================
        // Section 1: Contact Hero & Quick Connect Bar
        // ====================================================================
        [
            'key' => 'contact-hero',
            'type' => 'contact.hero',
            'enabled' => true,
            'order' => 10,
            'data' => [
                'eyebrow' => 'Direct Community Desk · Phone, Guided Inquiry & Arrival Guide',
                'license' => 'CA License #415601046',
                'script_title' => 'A Warm Welcome in Daly City',
                'heading' => 'Reach Out to Our Team or Schedule an Unhurried Personal Visit.',
                'lead' => 'Whether you are exploring <a href="/memory-care" class="underline decoration-[#C98268] underline-offset-4 font-semibold text-[#3B2348] hover:text-[#C98268] transition">Legacies™ Memory Care</a> for a loved one living with Alzheimer’s or dementia, planning a short-term <a href="/respite-care" class="underline decoration-[#C98268] underline-offset-4 font-semibold text-[#3B2348] hover:text-[#C98268] transition">Respite Care</a> stay, or simply want to walk through our suites and dining room in person, our team at <strong class="text-[#3B2348]">995 East Market Street, Daly City, CA 94014</strong> is here to listen and help without pressure.',
                'phone' => [
                    'raw' => '650-756-1995',
                    'formatted' => '(650) 756-1995',
                    'href' => 'tel:16507561995',
                ],
                'email' => [
                    'address' => 'mktg.missionvilla@missionvillaseniorliving.com',
                    'href' => 'mailto:mktg.missionvilla@missionvillaseniorliving.com',
                ],
                'address' => [
                    'street' => '995 East Market Street',
                    'city' => 'Daly City',
                    'state' => 'CA',
                    'zip' => '94014',
                    'full' => '995 East Market Street, Daly City, CA 94014',
                ],
                'arrival_plate' => [
                    'image' => '/images/property/courtyard-patio.webp',
                    'alt' => 'Mission Villa courtyard patio with umbrella tables and garden seating',
                    'badge' => 'MISSION VILLA · PROPERTY PHOTO',
                    'caption_tag' => 'San Bruno Mountain Foothills',
                    'caption_text' => 'A calm, residential setting at 995 East Market Street in Daly City.',
                ],
                'directory_card' => [
                    'badge' => 'Verified Community Directory',
                    'title' => 'Direct Hospitality & Family Inquiries',
                    'description' => 'Every call and visit request is handled by our compassionate local team—never an automated call center.',
                    'care_programs' => 'Legacies™ Memory Care & Short-Term Respite Care',
                    'suite_formats' => 'Private Suites, Companion Units & Jack & Jill Formats (All with Private Baths)',
                    'licensing_info' => 'CA RCFE License #415601046 · Daly City, CA 94014',
                    'maps_label' => 'Open 995 East Market St in Google Maps',
                    'maps_url' => 'https://www.google.com/maps/search/?api=1&query=995+East+Market+Street+Daly+City+CA+94014',
                ],
                'actions' => [
                    [
                        'label' => 'Schedule a Visit or Request Info ↓',
                        'style' => 'primary',
                        'icon' => 'calendar',
                        'target' => 'schedule-visit',
                    ],
                    [
                        'label' => 'Call 650-756-1995',
                        'style' => 'phone',
                        'icon' => 'phone',
                        'href' => 'tel:16507561995',
                    ],
                    [
                        'label' => 'Map & Directions',
                        'style' => 'secondary',
                        'icon' => 'compass',
                        'target' => 'map-and-directions',
                    ],
                ],
                'quick_sections' => [
                    [
                        'id' => 'schedule-visit',
                        'index' => '01',
                        'title' => 'Guided Visit & Inquiry Form',
                        'subtitle' => 'Local validation · Demo-only state',
                    ],
                    [
                        'id' => 'map-and-directions',
                        'index' => '02',
                        'title' => 'Grounded Map & Directions',
                        'subtitle' => 'I-280, SF, BART & accessible entry',
                    ],
                    [
                        'id' => 'what-happens-next',
                        'index' => '03',
                        'title' => 'What Happens After Submitting',
                        'subtitle' => 'Production workflow vs. demo stage',
                    ],
                    [
                        'id' => 'referral-interest',
                        'index' => '04',
                        'title' => 'Referral Interest & FAQs',
                        'subtitle' => 'Family/partner referrals & answers',
                    ],
                ],
            ],
        ],

        // ====================================================================
        // Section 2: Split Editorial Contact Studio & Guided Inquiry Form
        // ====================================================================
        [
            'key' => 'contact-studio',
            'type' => 'contact.studio',
            'enabled' => true,
            'order' => 20,
            'data' => [
                'eyebrow' => '01 · Split Editorial Contact Studio',
                'heading' => 'Connect By Phone, Email, or Guided Visit Request.',
                'intro' => 'Choose the way you feel most comfortable reaching out. Call our Daly City desk directly for an immediate conversation, or use the guided form to outline your preferred contact method, care interest, and time window.',
                'primary_contact' => [
                    'badge' => 'Verified Primary Contact',
                    'community_name' => 'Mission Villa Senior Living',
                    'license_label' => 'CA License #415601046',
                    'phone_label' => 'Main Community Telephone (Verified)',
                    'phone_raw' => '650-756-1995',
                    'phone_href' => 'tel:16507561995',
                    'phone_note' => 'Also formatted as (650) 756-1995. (CLIENT CONFIRMATION REQUIRED: Legacy Contact page also listed (650) 534-2859; use 650-756-1995 as primary.)',
                    'email_label' => 'Direct Marketing & Tour Email',
                    'email_address' => 'mktg.missionvilla@missionvillaseniorliving.com',
                    'email_href' => 'mailto:mktg.missionvilla@missionvillaseniorliving.com',
                    'address_label' => 'Community Street Address',
                    'address_full' => '995 East Market Street, Daly City, CA 94014',
                    'maps_url' => 'https://www.google.com/maps/search/?api=1&query=995+East+Market+Street+Daly+City+CA+94014',
                ],
                'presets' => [
                    [
                        'label' => 'Tour Memory Care Suites',
                        'inquiry_intent' => 'Schedule a Personal Visit',
                        'care_interest' => 'Memory Care (Legacies™ Program)',
                        'suite_preference' => 'Open / Compare on Tour',
                        'message' => 'Would like to schedule a personal walkthrough of Legacies™ Memory Care and compare Private, Companion Unit, and Jack & Jill suites.',
                        'referral_note' => null,
                    ],
                    [
                        'label' => 'Short-Term Respite Stay',
                        'inquiry_intent' => 'Request Pricing & Program Info',
                        'care_interest' => 'Short-Term Respite Care',
                        'suite_preference' => 'Private Suite',
                        'message' => 'Exploring a short-term Respite Care stay in Daly City and would like to ask about availability and what is included.',
                        'referral_note' => null,
                    ],
                    [
                        'label' => 'Pricing & Paper-Ledger Chat',
                        'inquiry_intent' => 'Request Pricing & Program Info',
                        'care_interest' => 'Both / Exploring Options',
                        'suite_preference' => 'Open / Compare on Tour',
                        'message' => 'Would like to discuss assessment-informed pricing and monthly inclusions for our family.',
                        'referral_note' => null,
                    ],
                    [
                        'label' => 'First Family Phone Call',
                        'inquiry_intent' => 'Request a Team Phone Call',
                        'care_interest' => 'Memory Care (Legacies™ Program)',
                        'suite_preference' => 'Open / Compare on Tour',
                        'message' => 'We are beginning our family conversation and would appreciate an unhurried phone call with your team.',
                        'referral_note' => null,
                    ],
                ],
                'privacy_guardrail' => [
                    'title' => 'Privacy & Non-Clinical Form Guardrail',
                    'text' => 'For your family’s privacy, this inquiry form never asks for medical diagnoses, medication lists, or clinical health histories. Personal support needs are discussed privately with our care team.',
                ],
                'form_config' => [
                    'badge' => 'Guided Inquiry & Request-Visit Studio',
                    'title' => 'Schedule a Visit or Request Information',
                    'demo_pill' => 'Demo only — no inquiry sent',
                    'intent_label' => '1. How Can Our Team Help You Today?',
                    'intents' => [
                        'Schedule a Personal Visit',
                        'Request Pricing & Program Info',
                        'Request a Team Phone Call',
                        'Referral or Professional Introduction',
                    ],
                    'name_label' => '2. Your Full Name *',
                    'method_label' => '3. Preferred Contact Method *',
                    'methods' => [
                        'Either Phone or Email',
                        'Phone Call',
                        'Email',
                    ],
                    'phone_label' => 'Telephone Number',
                    'email_label' => 'Email Address',
                    'care_label' => '4. Care Program Interest *',
                    'care_options' => [
                        'Memory Care (Legacies™ Program)',
                        'Short-Term Respite Care',
                        'Both / Exploring Options',
                    ],
                    'suite_label' => 'Suite Format to Discuss or View',
                    'suite_options' => [
                        'Private Suite',
                        'Companion Unit (Shared)',
                        'Jack & Jill Format',
                        'Open / Compare on Tour',
                    ],
                    'window_label' => '5. Preferred Contact Window *',
                    'windows' => [
                        'Morning (9:00 AM – 12:00 PM)',
                        'Afternoon (12:00 PM – 4:00 PM)',
                        'Late Afternoon / Early Evening (4:00 PM – 6:00 PM)',
                        'Flexible / Any Convenient Time',
                    ],
                    'timing_label' => 'Preferred Visit Day or Timing (Optional)',
                    'timing_placeholder' => 'e.g., This Thursday afternoon or weekend',
                    'message_label' => '6. Questions or Notes for Our Team (Optional)',
                    'message_disclaimer' => 'Please do not include medical diagnoses or health records',
                    'message_placeholder' => 'Share any questions about Legacies™ Memory Care, short-term Respite Care, suites, or visiting with family...',
                    'consent_text' => 'Consent & Privacy Notice *: I request that Mission Villa Senior Living contact me via my selected preference regarding community information, pricing, or scheduling a visit. I understand that this prototype form is for general inquiry purposes only (not medical history), and final consent wording is subject to legal/privacy review prior to production launch.',
                    'submit_label' => 'Preview Guided Inquiry (Demo only — no inquiry sent)',
                    'demo_explainer' => 'Demo only — no inquiry sent. Submitting validates fields locally without transmitting personal data.',
                ],
            ],
        ],

        // ====================================================================
        // Section 3: Grounded Map & Peninsula Directions
        // ====================================================================
        [
            'key' => 'contact-directions',
            'type' => 'contact.directions',
            'enabled' => true,
            'order' => 30,
            'data' => [
                'script_title' => 'Reaching 995 East Market Street',
                'heading' => 'Grounded Map, Peninsula Directions & Accessible Arrival.',
                'intro' => 'Mission Villa Senior Living sits in an established Daly City neighborhood near the western foothills of San Bruno Mountain—offering straightforward access from I-280, southern San Francisco neighborhoods, and Peninsula transit.',
                'maps_url' => 'https://www.google.com/maps/search/?api=1&query=995+East+Market+Street+Daly+City+CA+94014',
                'maps_embed_url' => 'https://www.google.com/maps?q=995+East+Market+Street,+Daly+City,+CA+94014&output=embed',
                'orientation_image' => [
                    'src' => '/images/property/community-lounge.webp',
                    'alt' => 'Mission Villa community lounge with armchairs, a sofa and natural light',
                    'badge' => 'MISSION VILLA · PROPERTY PHOTO',
                    'subtitle' => 'Northern San Mateo County · Peninsula',
                    'title' => 'Mission Villa Senior Living · 995 East Market St',
                    'phone' => '650-756-1995',
                ],
                'categories' => [
                    'All Routes',
                    'Highway & Peninsula',
                    'San Francisco & Local Streets',
                    'BART & Public Transit',
                    'Parking & Accessibility',
                ],
                'corridors' => [
                    [
                        'id' => 'corridor-i280-peninsula',
                        'code' => 'ROUTE 01',
                        'category' => 'Highway & Peninsula',
                        'title' => 'Approaching From I-280 North or South (San Mateo County & Peninsula)',
                        'subtitle' => 'Direct freeway access from Burlingame, San Bruno, South San Francisco, and Colma',
                        'route_summary' => 'Mission Villa Senior Living is located at 995 East Market Street in Daly City, just east of the I-280 corridor toward the residential foothills of San Bruno Mountain.',
                        'landmarks_and_streets' => [
                            'Connect via I-280 toward Mission Street / Junipero Serra Boulevard in Daly City',
                            'Head east along Market Street / East Market Street into the quiet residential neighborhood',
                            'Convenient regional access for relatives visiting from across the San Francisco Peninsula',
                        ],
                        'arrival_tip' => 'Call our front desk at 650-756-1995 if you would like live turn-by-turn landmarks before setting out.',
                    ],
                    [
                        'id' => 'corridor-sf-mission',
                        'code' => 'ROUTE 02',
                        'category' => 'San Francisco & Local Streets',
                        'title' => 'Approaching From San Francisco, Excelsior, Glen Park & Sunset',
                        'subtitle' => 'Minutes south of the San Francisco county border along Mission Street or Geneva Avenue',
                        'route_summary' => 'For families living in southern San Francisco neighborhoods, 995 East Market Street offers a straightforward neighborhood drive without needing to cross bridges or major toll corridors.',
                        'landmarks_and_streets' => [
                            'Travel south via Mission Street or San Jose Avenue into northern Daly City',
                            'Turn east onto Market Street / East Market Street toward San Bruno Mountain State & County Park',
                            'Situated in an established residential setting close to local dining and community parks',
                        ],
                        'arrival_tip' => 'Many San Francisco spouses and adult children find East Market Street easy to reach for regular afternoon or dining visits.',
                    ],
                    [
                        'id' => 'corridor-bart-transit',
                        'code' => 'ROUTE 03',
                        'category' => 'BART & Public Transit',
                        'title' => 'BART & SamTrans Connections in Daly City',
                        'subtitle' => 'Public transit proximity via Daly City BART and Colma BART stations',
                        'route_summary' => 'Visiting family members and friends arriving without a car can connect through the Daly City or Colma BART stations and local SamTrans bus routes serving Mission Street and East Market Street.',
                        'landmarks_and_streets' => [
                            'Short taxi, rideshare, or local bus connection from Daly City BART or Colma BART',
                            'Served by local SamTrans corridors along Mission Street in Daly City',
                            'Ask our concierge team for local transportation pointers when planning your visit',
                        ],
                        'arrival_tip' => 'When scheduling your visit, let our team know your arrival window so we are ready to greet you at the main entrance.',
                    ],
                    [
                        'id' => 'corridor-parking-accessibility',
                        'code' => 'ACCESS 04',
                        'category' => 'Parking & Accessibility',
                        'title' => 'On-Site Visitor Parking & Accessible Community Entry',
                        'subtitle' => 'Thoughtful arrival experience for older adults, walkers, and wheelchairs',
                        'route_summary' => 'Whether you are visiting solo for a first conversation or bringing an older loved one to see our dining room and suites, our community entrance is arranged for calm, unhurried arrival.',
                        'landmarks_and_streets' => [
                            'On-site parking available at 995 East Market Street (confirm specific visitor stall and drop-off instructions with our team)',
                            'Step-free, mobility-supportive entry pathways and residential common areas',
                            'Staff greeting at the front desk to assist with escorting or mobility devices',
                        ],
                        'arrival_tip' => 'If you are bringing a loved one who uses a walker or wheelchair, call 650-756-1995 upon arrival so a team member can meet you right at the entrance.',
                    ],
                ],
                'neighborhood_anchors' => [
                    [
                        'title' => 'Primary Road Corridors',
                        'description' => 'East Market Street connects directly with Mission Street and the I-280 freeway corridor in Daly City.',
                        'icon' => 'car',
                    ],
                    [
                        'title' => 'Nearby Natural & Transit Anchors',
                        'description' => 'Minutes from San Bruno Mountain State & County Park, Daly City BART, and Colma BART.',
                        'icon' => 'train',
                    ],
                ],
            ],
        ],

        // ====================================================================
        // Section 4: What Happens After Submitting
        // ====================================================================
        [
            'key' => 'contact-workflow',
            'type' => 'contact.workflow',
            'enabled' => true,
            'order' => 40,
            'data' => [
                'script_title' => 'Unhurried Follow-Through',
                'heading' => 'What Happens After Submitting (Once Live Backend Is Connected).',
                'intro' => 'Until production backend integration is connected in a later phase, this page’s inquiry form operates strictly in Demo only — no inquiry sent mode. Here is how your inquiry flows once connected—and how to reach us today.',
                'steps' => [
                    [
                        'id' => 'post-step-01-acknowledgment',
                        'step_number' => 'Step 01',
                        'timing_badge' => 'Immediate · Production Handoff',
                        'title' => 'Clear Inquiry Receipt & Direct Team Routing',
                        'subtitle' => 'Your request goes straight to our Daly City community desk—never a high-pressure call center',
                        'what_happens_in_production' => 'Once backend integration is connected at launch, submitting the form securely delivers your contact preferences, care interest (Memory Care or Respite Care), and preferred time window directly to the Mission Villa team.',
                        'current_prototype_behavior' => 'In this frontend design prototype, clicking Submit validates your inputs locally in the browser and displays an explicit "Demo only — no inquiry sent" preview card without transmitting personal data.',
                        'family_reassurance' => 'Need to reach us today during the prototype phase? Call 650-756-1995 or email mktg.missionvilla@missionvillaseniorliving.com directly.',
                    ],
                    [
                        'id' => 'post-step-02-listening-call',
                        'step_number' => 'Step 02',
                        'timing_badge' => 'In Your Preferred Contact Window',
                        'title' => 'An Unhurried First Conversation by Phone or Email',
                        'subtitle' => 'Listening to your family’s situation before suggesting next steps',
                        'what_happens_in_production' => 'A Mission Villa team member reaches out during the contact window you selected (Morning, Afternoon, or Early Evening) using your preferred method to answer initial questions about Legacies™ Memory Care, short-term Respite Care, or suite formats.',
                        'current_prototype_behavior' => 'You can preview how preferred contact method and time window selections are captured in the guided inquiry form above.',
                        'family_reassurance' => 'There is never any obligation or sales pressure—only straightforward answers tailored to your timeline.',
                    ],
                    [
                        'id' => 'post-step-03-personal-walkthrough',
                        'step_number' => 'Step 03',
                        'timing_badge' => 'At 995 East Market Street',
                        'title' => 'A Personal Visit & Guided Community Walkthrough',
                        'subtitle' => 'See our dining room, lounges, enclosed courtyard, and suites in person',
                        'what_happens_in_production' => 'We confirm a convenient day and time for you (and your loved one, if you wish) to visit 995 East Market Street in Daly City, meet our 24-hour care staff, and compare Private, Companion Unit, and Jack & Jill suite layouts.',
                        'current_prototype_behavior' => 'Use the Guided Inquiry form’s "Preferred Visit Day or Timing" field to test how tour scheduling notes are structured.',
                        'family_reassurance' => 'Many spouses and adult children visit solo first to ask candid questions, then return with their loved one for a second visit.',
                    ],
                    [
                        'id' => 'post-step-04-care-and-pricing-plan',
                        'step_number' => 'Step 04',
                        'timing_badge' => 'Personalized Follow-Up',
                        'title' => 'Assessment-Informed Care & Financial Planning Clarity',
                        'subtitle' => 'Written inclusions and care recommendations grounded in your loved one’s needs',
                        'what_happens_in_production' => 'Following your conversation and walkthrough, our team outlines assessment-informed pricing, monthly inclusions, and—when moving forward—schedules a collaborative care assessment.',
                        'current_prototype_behavior' => 'Explore our interactive Paper-Ledger Worksheet on /financial-planning or bring questions from /for-families right into your visit.',
                        'family_reassurance' => 'Every step respects your family’s pace, privacy, and peace of mind.',
                    ],
                ],
            ],
        ],

        // ====================================================================
        // Section 5: Referral Interest Pathways
        // ====================================================================
        [
            'key' => 'contact-referral',
            'type' => 'contact.referral',
            'enabled' => true,
            'order' => 50,
            'data' => [
                'script_title' => 'Community & Partner Introductions',
                'heading' => 'Introducing a Family Friend or Professional Care Referral.',
                'pathways' => [
                    [
                        'id' => 'family-friend-referral',
                        'badge' => 'Original Contact Page Topic · Family & Resident Referrals',
                        'verification_status' => 'CLIENT CONFIRMATION REQUIRED',
                        'title' => 'Referring a Friend or Relative to Mission Villa',
                        'subtitle' => 'Sharing a trusted Daly City Memory Care or Respite Care community with another family',
                        'description' => 'The original Mission Villa Contact Us and Financial Planning pages include a dedicated area for families and current community friends who wish to introduce another family exploring Memory Care or short-term Respite Care in Daly City.',
                        'highlights' => [
                            'Introduce a friend, neighbor, or relative who is searching for compassionate dementia or respite support',
                            'Our team reaches out with the same unhurried warmth, privacy, and respect',
                            'Legacy site materials mention a resident referral credit; specific eligibility and credit terms must be confirmed directly with Mission Villa leadership',
                        ],
                        'verification_disclosure' => 'CLIENT CONFIRMATION REQUIRED: The historical Mission Villa website mentions a resident referral credit program. Please confirm current program status, dollar amounts, and eligibility terms with leadership before launch.',
                        'preset_inquiry_note' => 'Referral Interest (Family / Friend Introduction): I would like to ask about introducing a family friend or relative to Mission Villa and confirm current referral program details.',
                    ],
                    [
                        'id' => 'professional-care-referral',
                        'badge' => 'Community Partners · Senior Care Professionals',
                        'verification_status' => 'CLIENT CONFIRMATION REQUIRED',
                        'title' => 'Discharge Planners, Care Managers & Peninsula Senior Advisors',
                        'subtitle' => 'Coordinating Memory Care transitions or post-rehabilitation Respite Care stays',
                        'description' => 'Social workers, hospital discharge planners, geriatric care managers, and fiduciaries across San Mateo and San Francisco Counties can connect directly with our Daly City team regarding suite availability and care assessments.',
                        'highlights' => [
                            'Direct coordination for Legacies™ Memory Care or short-term Respite Care inquiries',
                            'Licensed California RCFE (#415601046) at 995 East Market Street, Daly City, CA 94014',
                            'Please do not transmit protected medical records or clinical diagnoses through the public website form; call 650-756-1995 to coordinate directly',
                        ],
                        'verification_disclosure' => 'CLIENT CONFIRMATION REQUIRED: Confirm preferred professional referral intake contact protocol and whether secondary telephone (650) 534-2859 is active for partner inquiries.',
                        'preset_inquiry_note' => 'Professional Referral / Care Coordination Inquiry: Reaching out to connect with the Mission Villa team regarding current Memory Care or Respite Care suite availability.',
                    ],
                ],
            ],
        ],

        // ====================================================================
        // Section 6: Contact & Accessibility FAQs
        // ====================================================================
        [
            'key' => 'contact-faq',
            'type' => 'contact.faq',
            'enabled' => true,
            'order' => 60,
            'data' => [
                'script_title' => 'Practical Answers Before You Visit',
                'heading' => 'Contact, Visit & Accessibility Directions FAQs.',
                'search_placeholder' => 'Search phone, parking, wheelchair, medical privacy...',
                'categories' => [
                    'All Questions',
                    'Scheduling & Visits',
                    'Directions & Accessibility',
                    'Contact & Phone Numbers',
                    'Privacy & Prototype Form',
                ],
                'faqs' => [
                    [
                        'id' => 'contact-faq-schedule-tour',
                        'code' => 'VISIT 01',
                        'category' => 'Scheduling & Visits',
                        'question' => 'What is the fastest way to schedule a visit or speak with the Mission Villa team?',
                        'answer' => 'You can call our main community telephone directly at 650-756-1995, email mktg.missionvilla@missionvillaseniorliving.com, or use the Guided Inquiry & Visit Request form on this page (note: while this website is in its frontend design prototype stage, the form demonstrates validation locally—please call or email us directly for immediate assistance).',
                        'confirmation_note' => null,
                    ],
                    [
                        'id' => 'contact-faq-what-to-expect-on-tour',
                        'code' => 'VISIT 02',
                        'category' => 'Scheduling & Visits',
                        'question' => 'What happens during an in-person visit at 995 East Market Street?',
                        'answer' => 'During a personal visit in Daly City, a member of our team will welcome you, listen to your family’s questions, and walk you through our dining room, communal lounges, enclosed courtyard/patio, and available Private, Companion Unit, or Jack & Jill suites. We can also discuss Legacies™ Memory Care, short-term Respite Care, and personalized pricing at your pace.',
                        'confirmation_note' => null,
                    ],
                    [
                        'id' => 'contact-faq-parking-and-mobility',
                        'code' => 'ACCESS 01',
                        'category' => 'Directions & Accessibility',
                        'question' => 'Where is Mission Villa located, and is the entrance accessible for seniors with mobility needs?',
                        'answer' => 'Mission Villa Senior Living is located at 995 East Market Street, Daly City, CA 94014, near the San Bruno Mountain foothills with convenient access from I-280 and Mission Street. On-site parking is available, and our community features step-free, wheelchair- and walker-friendly pathways. If you are arriving with a loved one who needs escort or transfer assistance from the car, call 650-756-1995 when you pull up.',
                        'confirmation_note' => 'Confirm specific visitor parking stall locations and arrival gate/door buzz procedures when booking your tour.',
                    ],
                    [
                        'id' => 'contact-faq-phone-numbers',
                        'code' => 'CONTACT 01',
                        'category' => 'Contact & Phone Numbers',
                        'question' => 'Which telephone number and email address should families use to reach Mission Villa?',
                        'answer' => 'Please use our primary verified telephone number, 650-756-1995, and our marketing email, mktg.missionvilla@missionvillaseniorliving.com, for all family inquiries, tour requests, and general questions. (Note: While the legacy Contact page also displayed a secondary number, (650) 534-2859, 650-756-1995 is the primary verified community line across Mission Villa.)',
                        'confirmation_note' => 'CLIENT CONFIRMATION REQUIRED: Confirm whether secondary number (650) 534-2859 from the legacy Contact page remains active for specific inquiries or should be retired.',
                    ],
                    [
                        'id' => 'contact-faq-no-medical-history',
                        'code' => 'PRIVACY 01',
                        'category' => 'Privacy & Prototype Form',
                        'question' => 'Should I include my loved one’s medical diagnoses or health records in the online contact form?',
                        'answer' => 'No. For your family’s privacy and security, please do not enter medical diagnoses, medication lists, or detailed health histories into the website inquiry form. You only need to share your contact details, whether you are exploring Memory Care or Respite Care, and when you would like to talk. Personal care needs are discussed privately with our team during your consultation and routine assessment.',
                        'confirmation_note' => null,
                    ],
                    [
                        'id' => 'contact-faq-digital-accessibility',
                        'code' => 'ACCESS 02',
                        'category' => 'Directions & Accessibility',
                        'question' => 'What digital accessibility features are built into this website for older adults and relatives?',
                        'answer' => 'Every page includes a "Text Comfort" reading scale selector (A, A+, A++) in the top utility bar, high-contrast editorial typography, keyboard-navigable menus and accordions, visible focus rings, and support for reduced-motion preferences. If you need assistance accessing any information on our site, please call us at 650-756-1995.',
                        'confirmation_note' => null,
                    ],
                ],
                'bridges' => [
                    [
                        'eyebrow' => 'Prepare for Your Tour',
                        'title' => 'For Families & Visit Questions Guide',
                        'description' => 'Compare Memory Care vs. short-term Respite Care and review our 8-question checklist before your visit.',
                        'icon' => 'heart-handshake',
                        'links' => [
                            [
                                'label' => 'Open For Families & FAQs',
                                'href' => '/for-families',
                                'style' => 'primary',
                            ],
                        ],
                    ],
                    [
                        'eyebrow' => 'Compare Monthly Inclusions',
                        'title' => 'Financial Planning & Paper Ledger',
                        'description' => 'Use our editable blank Paper-Ledger Worksheet to organize your current household costs before speaking with our team.',
                        'icon' => 'file-spreadsheet',
                        'links' => [
                            [
                                'label' => 'Open Financial Planning',
                                'href' => '/financial-planning',
                                'style' => 'primary',
                            ],
                        ],
                    ],
                    [
                        'eyebrow' => 'Preview Living Spaces',
                        'title' => 'Suites, Floor Plans & Gallery',
                        'description' => 'Explore Private Suites, Companion Units, and Jack & Jill formats or browse our community photo gallery.',
                        'icon' => 'sparkles',
                        'links' => [
                            [
                                'label' => 'Suites & Plans →',
                                'href' => '/suites-and-floor-plans',
                                'style' => 'primary',
                            ],
                            [
                                'label' => 'Gallery →',
                                'href' => '/gallery',
                                'style' => 'outline',
                            ],
                        ],
                    ],
                ],
            ],
        ],

        [
            'key' => 'contact-cta',
            'type' => 'visit.cta',
            'enabled' => true,
            'order' => 70,
            'data' => [
                'script' => 'Experience Mission Villa',
                'heading' => 'Schedule Your Personal Visit in Daly City',
                'body' => 'Meet our compassionate care team, walk through our suites, dining room, and courtyard gardens at 995 East Market Street, and ask any questions at your own pace.',
                'show_contact' => true,
                'care' => 'exploring',
                'actions' => [
                    [
                        'intent' => 'schedule_visit',
                        'label' => 'Schedule a Tour Visit',
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
                'form' => [
                    'enabled' => true,
                    'heading' => 'Schedule a Visit or Send an Inquiry',
                    'lede' => 'Our Daly City community director will reach out promptly to confirm your visit time or answer questions.',
                ],
            ],
        ],
    ],
];
