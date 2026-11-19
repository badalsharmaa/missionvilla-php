# Content Update Guide: For Families Page (`for-families`)

**Route:** `/for-families`
**PHP Source File:** `content/pages/for-families.php`
**Current Content Spec:** `docs/pages/for-families.md`
**Editorial V2 Source:** `docs/Mission_Villa_Website_Content_Editorial_V2/pages/for-families.md`

---

## Executive Summary of Changes
- **Total Sections in PHP:** 7 (`ff-hero`, `ff-decision-guide`, `ff-checklist`, `ff-involvement`, `ff-faq`, `ff-bridge`, `ff-cta`)
- **Sections Modified:** 6 (`ff-hero`, `ff-decision-guide`, `ff-checklist`, `ff-involvement`, `ff-faq`, `ff-cta`)
- **Sections Retired / Removed:** 1 (`ff-bridge` retired; recommend `'enabled' => false`)
- **Key Editorial Directions:**
  - Supportive, non-judgmental tone: "You don't need every answer today."
  - 3 clear decision-making options (Ongoing memory support, Temporary support, Not sure yet).
  - 3 essential tour questions rather than an overwhelming 8-item checklist.
  - FAQs pruned from 12 dense entries across 4 categories down to 4 direct, high-value answers.

---

## SEO & Page Metadata

### Field: `title`
- **PHP Key Path:** `title`
- **OLD CONTENT:**
```text
For Families & FAQs | Mission Villa Senior Living in Daly City
```
- **NEW CONTENT:**
```text
For Families | Questions About Care at Mission Villa
```

### Field: `seo['title']`
- **PHP Key Path:** `seo['title']`
- **OLD CONTENT:**
```text
Family Guide & Grouped FAQs: Memory Care in Daly City | Mission Villa
```
- **NEW CONTENT:**
```text
For Families | Questions About Care at Mission Villa
```

### Field: `seo['description']`
- **PHP Key Path:** `seo['description']`
- **OLD CONTENT:**
```text
A calm companion for families considering Memory Care or Respite Care in Daly City. Review decision pathways, tour questions, transitions, and grouped FAQs.
```
- **NEW CONTENT:**
```text
Find simple answers about Memory Care, short-term Respite Care, tours, suites, and pricing at Mission Villa Senior Living in Daly City.
```

---

## Section 01: Hero (`for-families.hero`)
**Section Key:** `ff-hero`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[0]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Family Guidance Monograph · Decision Guide & FAQs
```
- **NEW CONTENT:**
```text
For Families
```

### Field: `heading`
- **PHP Key Path:** `sections[0]['data']['heading']`
- **OLD CONTENT:**
```text
A Calm, Honest Companion for Families <em>Navigating Care Decisions.</em>
```
- **NEW CONTENT:**
```text
You don't need every answer today.
```

### Field: `actions[0]['label']`
- **PHP Key Path:** `sections[0]['data']['actions'][0]['label']`
- **OLD CONTENT:**
```text
Schedule a Tour Visit
```
- **NEW CONTENT:**
```text
Talk With Our Team
```
*(Note: Action intent is `request_callback`, care: `exploring`).*

---

## Section 02: Where to Begin (`for-families.decision-guide`)
**Section Key:** `ff-decision-guide`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[1]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Family-Decision Guide
```
- **NEW CONTENT:**
```text
A Starting Point
```

### Field: `heading`
- **PHP Key Path:** `sections[1]['data']['heading']`
- **OLD CONTENT:**
```text
How to Consider Full-Time Memory Care vs. <em>Temporary Respite Care</em>
```
- **NEW CONTENT:**
```text
What does your family need right now?
```

### Option 1: Ongoing Memory Support
#### Field: `pathways[0]['kicker']`
- **PHP Key Path:** `sections[1]['data']['pathways'][0]['kicker']`
- **OLD CONTENT:**
```text
Ongoing Daily Living & Memory Support
```
- **NEW CONTENT:**
```text
Ongoing memory support
```

### Option 2: Temporary Support
#### Field: `pathways[1]['kicker']`
- **PHP Key Path:** `sections[1]['data']['pathways'][1]['kicker']`
- **OLD CONTENT:**
```text
Caregiver Rest, Travel or Family Obligations
```
- **NEW CONTENT:**
```text
Temporary support
```

---

## Section 03: Questions for a Visit (`for-families.checklist`)
**Section Key:** `ff-checklist`
**Status:** MODIFIED (Condensed from 8 questions to 3 core questions)

### Field: `eyebrow`
- **PHP Key Path:** `sections[2]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Preparing for Your Walkthrough
```
- **NEW CONTENT:**
```text
Preparing for a Tour
```

### Field: `heading`
- **PHP Key Path:** `sections[2]['data']['heading']`
- **OLD CONTENT:**
```text
Questions to Bring to a Visit in Daly City
```
- **NEW CONTENT:**
```text
Three questions worth asking.
```

---

## Section 04: Family Involvement (`for-families.involvement`)
**Section Key:** `ff-involvement`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[3]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Transitions & Partnership
```
- **NEW CONTENT:**
```text
Family Partnership
```

### Field: `heading`
- **PHP Key Path:** `sections[3]['data']['heading']`
- **OLD CONTENT:**
```text
Family Involvement & <em>Personalizing Your Loved One’s Space</em>
```
- **NEW CONTENT:**
```text
Your connection still matters.
```

---

## Section 05: FAQs (`for-families.faq`)
**Section Key:** `ff-faq`
**Status:** MODIFIED (Pruned from 12 FAQs to 4 essential questions)

### FAQ 1: Care Offerings
#### Field: `items[0]['question']`
- **PHP Key Path:** `sections[4]['data']['items'][0]['question']`
- **OLD CONTENT:**
```text
What care programs does Mission Villa Senior Living offer in Daly City?
```
- **NEW CONTENT:**
```text
What care does Mission Villa offer?
```

#### Field: `items[0]['answer']`
- **PHP Key Path:** `sections[4]['data']['items'][0]['answer']`
- **OLD CONTENT:**
```text
Mission Villa Senior Living specializes in two dedicated programs at 995 East Market Street in Daly City: full-time Memory Care (featuring our signature Legacies™ Memory Care program for seniors living with Alzheimer’s disease or other forms of dementia) and short-term Respite Care stays that support both seniors and family caregivers.
```
- **NEW CONTENT:**
```text
Legacies™ Memory Care and short-term Respite Care.
```

### FAQ 2: Suite Options
#### Field: `items[3]['question']`
- **PHP Key Path:** `sections[4]['data']['items'][3]['question']`
- **OLD CONTENT:**
```text
What types of suites and floor-plan formats are available at Mission Villa?
```
- **NEW CONTENT:**
```text
What suite options are there?
```

#### Field: `items[3]['answer']`
- **PHP Key Path:** `sections[4]['data']['items'][3]['answer']`
- **OLD CONTENT:**
```text
Mission Villa offers both private suites and shared suites—including our Companion Unit and Jack & Jill floor-plan formats—each equipped with a private bathroom. During your visit in Daly City, our team will gladly show you available suite layouts so you can see the rooms and bathrooms in person.
```
- **NEW CONTENT:**
```text
Private suites, companion units, and Jack & Jill formats are described in the source materials. Ask about current openings.
```

### FAQ 3: Pricing
#### Field: `items[6]['question']`
- **PHP Key Path:** `sections[4]['data']['items'][6]['question']`
- **OLD CONTENT:**
```text
How is monthly pricing determined, and why aren’t fixed rates or calculators shown online?
```
- **NEW CONTENT:**
```text
Can I find prices online?
```

#### Field: `items[6]['answer']`
- **PHP Key Path:** `sections[4]['data']['items'][6]['answer']`
- **OLD CONTENT:**
```text
Because every resident’s daily support needs, care assessment, and suite preference (Private, Companion Unit, or Jack & Jill) are unique, automated online calculators or flat rate estimates can be misleading. Instead, our Daly City team provides clear, assessment-informed pricing tailored to your loved one after a personal conversation.
```
- **NEW CONTENT:**
```text
Request current pricing based on the care and accommodation being considered.
```

### FAQ 4: Scheduling a Tour
#### Field: `items[9]['question']`
- **PHP Key Path:** `sections[4]['data']['items'][9]['question']`
- **OLD CONTENT:**
```text
How can our family schedule a tour of Mission Villa in Daly City, and what happens during a visit?
```
- **NEW CONTENT:**
```text
How can we arrange a tour?
```

#### Field: `items[9]['answer']`
- **PHP Key Path:** `sections[4]['data']['items'][9]['answer']`
- **OLD CONTENT:**
```text
You can call us directly at (650) 756-1995, email mktg.missionvilla@missionvillaseniorliving.com, or use the inquiry form on this page to request a visit at 995 East Market Street, Daly City, CA 94014. During your visit, we walk through our dining room, communal lounges, courtyard, and available suites, and take time to answer your family’s questions without pressure.
```
- **NEW CONTENT:**
```text
Call (650) 756-1995 or submit a visit request.
```

*(Note: Surplus FAQs in PHP `items` are disabled or hidden in Editorial V2).*

---

## Section 06: Bridge (`for-families.bridge`)
**Section Key:** `ff-bridge`
**Status:** RETIRED / REMOVED IN V2

### Editorial Action:
- Retired per `CONTENT_MAP.md` ("ff-bridge and large guides removed").
- **Recommended PHP Action:** Set `'enabled' => false`.

### Field: `cards[0]['title']` (Retired Section)
- **PHP Key Path:** `sections[5]['data']['cards'][0]['title']`
- **OLD CONTENT:**
```text
Financial Planning & Paper-Ledger Worksheet
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

---

## Section 07: Closing CTA (`visit.cta`)
**Section Key:** `ff-cta`
**Status:** MODIFIED

### Field: `heading`
- **PHP Key Path:** `sections[6]['data']['heading']`
- **OLD CONTENT:**
```text
Schedule a Visit to Mission Villa in Daly City
```
- **NEW CONTENT:**
```text
Let's take the next step at your pace.
```

### Field: `body`
- **PHP Key Path:** `sections[6]['data']['body']`
- **OLD CONTENT:**
```text
Meet our care leadership, walk through our suites, lounges, and garden courtyard, and discuss your family’s unique situation with no pressure.
```
- **NEW CONTENT:**
```text
Visit Mission Villa or start with a phone conversation.
```

### Action Configuration:
- Schedule a Visit (`schedule_visit` modal, care: `exploring`)
- Request Pricing (`request_pricing` modal, care: `exploring`)
- Request a Call (`request_callback` modal)
- Phone: `(650) 756-1995`
