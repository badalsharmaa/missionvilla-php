# Content Update Guide: Living Options Page (`living-options`)

**Route:** `/living-options`
**PHP Source File:** `content/pages/living-options.php`
**Current Content Spec:** `docs/pages/living-options.md`
**Editorial V2 Source:** `docs/Mission_Villa_Website_Content_Editorial_V2/pages/living-options.md`

---

## Executive Summary of Changes
- **Total Sections in PHP:** 6 (`lo-hero`, `lo-care`, `lo-suites`, `lo-setting`, `lo-faq`, `lo-cta`)
- **Sections Modified:** 5 (`lo-hero`, `lo-care`, `lo-suites`, `lo-faq`, `lo-cta`)
- **Sections Retired / Removed:** 1 (`lo-setting` moved to Life & Services; recommend `'enabled' => false`)
- **Key Editorial Directions:**
  - Clear focus on two distinct care paths (Memory Care vs Respite Care).
  - Streamlined suite snapshot rather than duplicative deep dives.
  - Quick Comparison table updated with 3 concise comparative rows.
  - FAQs condensed from 5 entries to 2 core questions.

---

## SEO & Page Metadata

### Field: `title`
- **PHP Key Path:** `title`
- **OLD CONTENT:**
```text
Living Options: Memory Care & Respite Care | Mission Villa Senior Living
```
- **NEW CONTENT:**
```text
Living Options | Memory Care & Respite Care at Mission Villa
```

### Field: `seo['title']`
- **PHP Key Path:** `seo['title']`
- **OLD CONTENT:**
```text
Living Options: Memory Care & Respite Care in Daly City | Mission Villa
```
- **NEW CONTENT:**
```text
Living Options | Memory Care & Respite Care at Mission Villa
```

### Field: `seo['description']`
- **PHP Key Path:** `seo['description']`
- **OLD CONTENT:**
```text
Explore living options at Mission Villa in Daly City. Dedicated Legacies™ Memory Care and short-term Respite Care with private, companion, and Jack & Jill suites.
```
- **NEW CONTENT:**
```text
Compare Legacies™ Memory Care and short-term Respite Care at Mission Villa in Daly City and explore suite formats.
```

---

## Section 01: Hero (`living-options.hero`)
**Section Key:** `lo-hero`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[0]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Living Options at Mission Villa
```
- **NEW CONTENT:**
```text
Living Options
```

### Field: `heading`
- **PHP Key Path:** `sections[0]['data']['heading']`
- **OLD CONTENT:**
```text
Comfortable Living, <em>Personalized Support.</em>
```
- **NEW CONTENT:**
```text
Two care options. One welcoming community.
```

### Field: `intro`
- **PHP Key Path:** `sections[0]['data']['intro']`
- **OLD CONTENT:**
```text
Mission Villa provides ongoing Legacies™ Memory Care and flexible Short-Term Respite Care—delivering personalized daily support, private and companion suites, and peace of mind for Bay Area families.
```
- **NEW CONTENT:**
```text
Mission Villa focuses on ongoing Memory Care and short-term Respite Care in Daly City. Explore the difference and talk with our team about what your family needs.
```

---

## Section 02: Compare Care Options (`living-options.care`)
**Section Key:** `lo-care`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[1]['data']['eyebrow']`
- **OLD CONTENT:**
```text
CARE OPTIONS AT MISSION VILLA
```
- **NEW CONTENT:**
```text
Finding the Right Fit
```

### Field: `heading`
- **PHP Key Path:** `sections[1]['data']['heading']`
- **OLD CONTENT:**
```text
Choose the Care That <em>Fits Your Needs.</em>
```
- **NEW CONTENT:**
```text
What kind of support are you looking for?
```

### Option 1: Memory Care
#### Field: `options[0]['key_distinction']`
- **PHP Key Path:** `sections[1]['data']['options'][0]['key_distinction']`
- **OLD CONTENT:**
```text
Best suited for older adults seeking an ongoing, supportive home where 24-hour staff know their personal history and provide steady daily assistance.
```
- **NEW CONTENT:**
```text
Ongoing residential care for someone living with Alzheimer's disease or another form of dementia.
```

#### Field: `options[0]['lead']`
- **PHP Key Path:** `sections[1]['data']['options'][0]['lead']`
- **OLD CONTENT:**
```text
At Mission Villa, Memory Care is not a side wing—it is the heart of our community. Through our Legacies™ Memory Care program, we honor each resident’s life story, daily rhythms, and personal dignity in a calm, homelike environment.
```
- **NEW CONTENT:**
```text
Personal care, familiar routines, and daily opportunities for connection.
```

#### Field: `options[0]['route_label']`
- **PHP Key Path:** `sections[1]['data']['options'][0]['route_label']`
- **OLD CONTENT:**
```text
Explore Full Memory Care Details
```
- **NEW CONTENT:**
```text
Explore Memory Care
```

### Option 2: Respite Care
#### Field: `options[1]['key_distinction']`
- **PHP Key Path:** `sections[1]['data']['options'][1]['key_distinction']`
- **OLD CONTENT:**
```text
Best suited for temporary stays when a family caregiver needs dependable relief, during post-rehabilitation transitions, or as a gentle introduction to community life.
```
- **NEW CONTENT:**
```text
Temporary support while a family caregiver rests, travels, or manages responsibilities.
```

#### Field: `options[1]['lead']`
- **PHP Key Path:** `sections[1]['data']['options'][1]['lead']`
- **OLD CONTENT:**
```text
Caring for a loved one at home takes deep devotion. Our Respite Care program offers short-term stays of a few days to several weeks—welcoming guests into the full warmth, dining, and attentive support of Mission Villa while family caregivers rest, travel, or recharge.
```
- **NEW CONTENT:**
```text
A short stay with daily assistance, meals, and community life, subject to assessment and availability.
```

#### Field: `options[1]['route_label']`
- **PHP Key Path:** `sections[1]['data']['options'][1]['route_label']`
- **OLD CONTENT:**
```text
Explore Full Respite Care Details
```
- **NEW CONTENT:**
```text
Explore Respite Care
```

### Comparison Table
#### Row 1: Stay Duration / Purpose
##### Field: `comparison['rows'][0]['dimension']`
- **PHP Key Path:** `sections[1]['data']['comparison']['rows'][0]['dimension']`
- **OLD CONTENT:**
```text
Primary Purpose
```
- **NEW CONTENT:**
```text
Stay
```

##### Field: `comparison['rows'][0]['memory_care']`
- **PHP Key Path:** `sections[1]['data']['comparison']['rows'][0]['memory_care']`
- **OLD CONTENT:**
```text
Ongoing, long-term residential support with steady daily routines for Alzheimer’s or dementia.
```
- **NEW CONTENT:**
```text
Ongoing
```

##### Field: `comparison['rows'][0]['respite_care']`
- **PHP Key Path:** `sections[1]['data']['comparison']['rows'][0]['respite_care']`
- **OLD CONTENT:**
```text
Short-term stays (days to weeks) for caregiver relief, recovery, or trial experience.
```
- **NEW CONTENT:**
```text
Temporary
```

#### Row 2: Main Purpose
##### Field: `comparison['rows'][1]['dimension']`
- **PHP Key Path:** `sections[1]['data']['comparison']['rows'][1]['dimension']`
- **OLD CONTENT:**
```text
Who It Supports
```
- **NEW CONTENT:**
```text
Main purpose
```

##### Field: `comparison['rows'][1]['memory_care']`
- **PHP Key Path:** `sections[1]['data']['comparison']['rows'][1]['memory_care']`
- **OLD CONTENT:**
```text
Seniors with memory loss who benefit from 24-hour specialized care in a nurturing setting.
```
- **NEW CONTENT:**
```text
Consistent memory support
```

##### Field: `comparison['rows'][1]['respite_care']`
- **PHP Key Path:** `sections[1]['data']['comparison']['rows'][1]['respite_care']`
- **OLD CONTENT:**
```text
Seniors cared for at home whose caregivers need relief or seniors post-rehab.
```
- **NEW CONTENT:**
```text
Short-term family support
```

#### Row 3: Getting Started
##### Field: `comparison['rows'][4]['dimension']`
- **PHP Key Path:** `sections[1]['data']['comparison']['rows'][4]['dimension']`
- **OLD CONTENT:**
```text
Planning & Pricing
```
- **NEW CONTENT:**
```text
Getting started
```

##### Field: `comparison['rows'][4]['memory_care']`
- **PHP Key Path:** `sections[1]['data']['comparison']['rows'][4]['memory_care']`
- **OLD CONTENT:**
```text
Assessment-based monthly pricing tailored to care level and chosen suite format.
```
- **NEW CONTENT:**
```text
Care assessment
```

##### Field: `comparison['rows'][4]['respite_care']`
- **PHP Key Path:** `sections[1]['data']['comparison']['rows'][4]['respite_care']`
- **OLD CONTENT:**
```text
Flexible short-term rates based on stay duration, suite availability, and care needs.
```
- **NEW CONTENT:**
```text
Care review and date availability
```

*(Note: In PHP `comparison['rows']`, rows 2 (`Daily Support`) and 3 (`Accommodations`) can be pruned or retired, leaving the 3 core rows above).*

---

## Section 03: Suite Options (`living-options.suites`)
**Section Key:** `lo-suites`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[2]['data']['eyebrow']`
- **OLD CONTENT:**
```text
RESIDENTIAL ACCOMMODATIONS
```
- **NEW CONTENT:**
```text
Accommodations
```

### Field: `heading`
- **PHP Key Path:** `sections[2]['data']['heading']`
- **OLD CONTENT:**
```text
Our Suite & <em>Floor-Plan Options</em>
```
- **NEW CONTENT:**
```text
Space to settle in.
```

### Field: `intro`
- **PHP Key Path:** `sections[2]['data']['intro']`
- **OLD CONTENT:**
```text
Every suite at Mission Villa is designed with comfort, safety, and personal dignity in mind. Choose from three thoughtfully arranged residential configurations—each featuring private bathroom access.
```
- **NEW CONTENT:**
```text
Ask about private suites, companion units, and Jack & Jill arrangements. All three formats are described in the source materials as offering an attached bathroom; the team can confirm the details of available rooms.
```

### Suite 1: Private Suite
#### Field: `suites[0]['summary']`
- **PHP Key Path:** `sections[2]['data']['suites'][0]['summary']`
- **OLD CONTENT:**
```text
A peaceful, individual residential suite offering dedicated sleeping and sitting space alongside an attached private bathroom—ideal for residents who value personal quiet and familiar surroundings.
```
- **NEW CONTENT:**
```text
An individual room and attached bathroom.
```

### Suite 2: Companion Unit
#### Field: `suites[1]['summary']`
- **PHP Key Path:** `sections[2]['data']['suites'][1]['summary']`
- **OLD CONTENT:**
```text
Pairs two residents in a thoughtfully arranged shared suite with a private bathroom—fostering companionship, natural socialization, and mutual reassurance.
```
- **NEW CONTENT:**
```text
Shared accommodation with a bathroom within the suite.
```

### Suite 3: Jack & Jill
#### Field: `suites[2]['summary']`
- **PHP Key Path:** `sections[2]['data']['suites'][2]['summary']`
- **OLD CONTENT:**
```text
Separate individual sleeping rooms connected by an adjoining private bathroom—combining personal privacy with homelike convenience and proximity to care.
```
- **NEW CONTENT:**
```text
Separate rooms connected by a shared bathroom; described in the source as a Memory Care format.
```

#### Field: `cta['label']`
- **PHP Key Path:** `sections[2]['data']['cta']['label']`
- **OLD CONTENT:**
```text
View Floor-Plan Details
```
- **NEW CONTENT:**
```text
View Suites
```

---

## Section 04: Setting (`living-options.setting`)
**Section Key:** `lo-setting`
**Status:** RETIRED / REMOVED IN V2

### Editorial Action:
- Per `CONTENT_MAP.md`, `lo-setting` has been moved to Life and Services.
- **Recommended PHP Action:** Set `'enabled' => false` for `lo-setting`.

### Field: `heading` (Retired Section)
- **PHP Key Path:** `sections[3]['data']['heading']`
- **OLD CONTENT:**
```text
A Welcoming, <em>Homelike Setting.</em>
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

### Field: `intro` (Retired Section)
- **PHP Key Path:** `sections[3]['data']['intro']`
- **OLD CONTENT:**
```text
Whether living at Mission Villa full-time or joining us for a temporary stay, every resident and guest shares in the warmth, connection, and attentive rhythm of our community.
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

---

## Section 05: FAQs (`living-options.faq`)
**Section Key:** `lo-faq`
**Status:** MODIFIED (Condensed from 5 FAQs to 2 core questions)

### FAQ 1: Care Offerings
#### Field: `faqs[0]['question']`
- **PHP Key Path:** `sections[4]['data']['faqs'][0]['question']`
- **OLD CONTENT:**
```text
Which care options does Mission Villa offer?
```
- **NEW CONTENT:**
```text
Does Mission Villa offer independent living or traditional assisted living?
```

#### Field: `faqs[0]['answer']`
- **PHP Key Path:** `sections[4]['data']['faqs'][0]['answer']`
- **OLD CONTENT:**
```text
Mission Villa provides two dedicated programs: ongoing Legacies™ Memory Care for residents with Alzheimer’s or dementia, and Short-Term Respite Care for temporary stays. We do not operate standalone independent living or traditional assisted living, which allows our team to focus 100% of our attention and expertise on memory and respite support.
```
- **NEW CONTENT:**
```text
The submitted materials describe Mission Villa as focused on Memory Care and Respite Care, not separate independent-living or assisted-living programs.
```

### FAQ 2: Choosing Appropriate Care
#### Field: `faqs[3]['question']`
- **PHP Key Path:** `sections[4]['data']['faqs'][3]['question']`
- **OLD CONTENT:**
```text
How do families choose the appropriate care option?
```
- **NEW CONTENT:**
```text
How do we know which option is appropriate?
```

#### Field: `faqs[3]['answer']`
- **PHP Key Path:** `sections[4]['data']['faqs'][3]['answer']`
- **OLD CONTENT:**
```text
Our Daly City care team conducts a comprehensive pre-admission conversation and assessment to understand your loved one’s daily routine, medical history, and care needs. If you are uncertain about long-term care, a short-term respite stay is often an ideal, low-pressure way to experience our community firsthand.
```
- **NEW CONTENT:**
```text
Talk with the team about the length of support needed and your loved one's daily care requirements. The team can explain its assessment process.
```

*(Note: Surplus FAQs in PHP `faqs[1]`, `faqs[2]`, `faqs[4]` are pruned or disabled).*

---

## Section 06: Closing CTA (`visit.cta`)
**Section Key:** `lo-cta`
**Status:** MODIFIED

### Field: `heading`
- **PHP Key Path:** `sections[5]['data']['heading']`
- **OLD CONTENT:**
```text
Talk With Our Care Team
```
- **NEW CONTENT:**
```text
Have questions about the options?
```

### Field: `body`
- **PHP Key Path:** `sections[5]['data']['body']`
- **OLD CONTENT:**
```text
Explore living options, understand care choices, and schedule a tour of our welcoming Daly City community.
```
- **NEW CONTENT:**
```text
We'll help you understand the differences and discuss current availability.
```

### Actions / Intents:
- Primary CTA: `Schedule a Visit` (`schedule_visit` modal, care: `exploring`)
- Secondary CTA: `Request Pricing` (`request_pricing` modal, care: `exploring`)
- Tertiary CTA: `Request a Call` (`request_callback` modal)
- Phone: `(650) 756-1995`
