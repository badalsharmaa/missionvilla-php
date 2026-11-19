# Content Update Guide: Suites & Floor Plans Page (`suites-and-floor-plans`)

**Route:** `/suites-and-floor-plans`
**PHP Source File:** `content/pages/suites-and-floor-plans.php`
**Current Content Spec:** `docs/pages/suites-and-floor-plans.md`
**Editorial V2 Source:** `docs/Mission_Villa_Website_Content_Editorial_V2/pages/suites-and-floor-plans.md`

---

## Executive Summary of Changes
- **Total Sections in PHP:** 6 (`sfp-hero`, `sfp-formats`, `sfp-diagram`, `sfp-features`, `sfp-faq`, `sfp-cta`)
- **Sections Modified:** 5 (`sfp-hero`, `sfp-formats`, `sfp-diagram`, `sfp-faq`, `sfp-cta`)
- **Sections Retired / Withheld:** 1 (`sfp-features` withheld pending factual verification of room fixtures; recommend `'enabled' => false`)
- **Key Editorial Directions:**
  - Honest presentation of accommodations without fabricated square footage or CAD renders.
  - Accurate presentation of the single verified architectural diagram (Companion Unit).
  - Clear distinction between Private, Companion, and Jack & Jill formats.
  - FAQs pruned from 6 to 3 verified, practical questions.

---

## SEO & Page Metadata

### Field: `title`
- **PHP Key Path:** `title`
- **OLD CONTENT:**
```text
Suites & Floor Plans | Mission Villa Senior Living
```
- **NEW CONTENT:**
```text
Suites & Floor Plans | Mission Villa Senior Living
```

### Field: `seo['title']`
- **PHP Key Path:** `seo['title']`
- **OLD CONTENT:**
```text
Suites & Floor Plans: Memory Care Living in Daly City | Mission Villa
```
- **NEW CONTENT:**
```text
Suites & Floor Plans | Mission Villa Senior Living
```

### Field: `seo['description']`
- **PHP Key Path:** `seo['description']`
- **OLD CONTENT:**
```text
Explore comfortable private and companion suites at Mission Villa in Daly City. Each suite includes a private en-suite bathroom, natural daylight, and 24/7 care support.
```
- **NEW CONTENT:**
```text
View private, companion, and Jack & Jill suite options at Mission Villa in Daly City. Ask about current availability and arrange a tour.
```

---

## Section 01: Hero (`suites-floor-plans.hero`)
**Section Key:** `sfp-hero`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[0]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Accommodations & Living Spaces
```
- **NEW CONTENT:**
```text
Suites & Floor Plans
```

### Field: `heading`
- **PHP Key Path:** `sections[0]['data']['heading']`
- **OLD CONTENT:**
```text
Calm Personal Sanctuaries, <em>Designed for Dignity.</em>
```
- **NEW CONTENT:**
```text
A comfortable space to call your own.
```

### Field: `intro`
- **PHP Key Path:** `sections[0]['data']['intro']`
- **OLD CONTENT:**
```text
Every suite at Mission Villa provides a peaceful, personal retreat where familiar furnishings, favorite keepsakes, and caring 24-hour support create an immediate sense of home and belonging.
```
- **NEW CONTENT:**
```text
Whether your loved one prefers privacy or companionship, we can help you explore available suite layouts and the everyday comforts of Mission Villa.
```

### Field: `actions[1]['label']`
- **PHP Key Path:** `sections[0]['data']['actions'][1]['label']`
- **OLD CONTENT:**
```text
Request Pricing & Plans
```
- **NEW CONTENT:**
```text
Request Availability
```
*(Note: Intent is `request_availability`).*

---

## Section 02: Suite Formats (`suites-floor-plans.formats`)
**Section Key:** `sfp-formats`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[1]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Suite Layout Options
```
- **NEW CONTENT:**
```text
Your Options
```

### Field: `heading`
- **PHP Key Path:** `sections[1]['data']['heading']`
- **OLD CONTENT:**
```text
Thoughtfully Arranged for <em>Comfort & Connection.</em>
```
- **NEW CONTENT:**
```text
Find the space that feels right.
```

### Format 1: Private Suite
#### Field: `suites[0]['summary']`
- **PHP Key Path:** `sections[1]['data']['suites'][0]['summary']`
- **OLD CONTENT:**
```text
Our private suites offer older adults an unhurried, quiet sanctuary where favorite chairs, family photos, and personal routines create an immediate feeling of ownership.
```
- **NEW CONTENT:**
```text
An individual room with an attached bathroom and room for familiar personal belongings.
```

### Format 2: Companion Unit
#### Field: `suites[1]['summary']`
- **PHP Key Path:** `sections[1]['data']['suites'][1]['summary']`
- **OLD CONTENT:**
```text
For residents who find reassurance in daily friendship, our Companion Unit balances camaraderie with defined personal sleeping zones and a shared en-suite bathroom.
```
- **NEW CONTENT:**
```text
A shared living arrangement with personal sleeping areas and a bathroom within the suite.
```

### Format 3: Jack & Jill
#### Field: `suites[2]['summary']`
- **PHP Key Path:** `sections[1]['data']['suites'][2]['summary']`
- **OLD CONTENT:**
```text
A versatile accommodation featuring two individual private bedrooms connected by a shared central bathroom—ideal for privacy with familiar neighborly closeness.
```
- **NEW CONTENT:**
```text
Two separate rooms connected by a shared bathroom. The original draft lists this as a Memory Care option; check current availability.
```

### Availability Note
#### Field: `cta['note']`
- **PHP Key Path:** `sections[1]['data']['cta']['note']`
- **OLD CONTENT:**
```text
Suite configurations and availability vary. Our Daly City team provides personalized guidance during tours.
```
- **NEW CONTENT:**
```text
Room sizes, furnishings, configurations, and openings vary. Ask the community for details before making plans.
```

#### Field: `cta['label']`
- **PHP Key Path:** `sections[1]['data']['cta']['label']`
- **OLD CONTENT:**
```text
Check Current Suite Availability
```
- **NEW CONTENT:**
```text
Ask About Available Suites
```

---

## Section 03: Floor Plan Diagram (`suites-floor-plans.diagram`)
**Section Key:** `sfp-diagram`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[2]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Architectural Layout & Transparency
```
- **NEW CONTENT:**
```text
See a Layout
```

### Field: `heading`
- **PHP Key Path:** `sections[2]['data']['heading']`
- **OLD CONTENT:**
```text
Authentic Floor Plans, <em>Walked in Person.</em>
```
- **NEW CONTENT:**
```text
A closer look at companion living.
```

### Field: `intro`
- **PHP Key Path:** `sections[2]['data']['intro']`
- **OLD CONTENT:**
```text
We believe in complete transparency. Rather than displaying fabricated blueprints, we share our authentic companion layout and invite you to tour each available room in person.
```
- **NEW CONTENT:**
```text
View the companion-suite diagram, then visit to see how available rooms are arranged in person.
```

### Field: `action['label']`
- **PHP Key Path:** `sections[2]['data']['action']['label']`
- **OLD CONTENT:**
```text
Tour Available Suites in Person
```
- **NEW CONTENT:**
```text
See the Suites in Person
```

---

## Section 04: Features (`suites-floor-plans.features`)
**Section Key:** `sfp-features`
**Status:** RETIRED / WITHHELD IN V2

### Editorial Action:
- Per Editorial V2: "Do not publish detailed step-free, call-cord, grab-bar, or door-memory-box claims until each is verified for available rooms."
- **Recommended PHP Action:** Set `'enabled' => false`.

### Field: `heading` (Retired Section)
- **PHP Key Path:** `sections[3]['data']['heading']`
- **OLD CONTENT:**
```text
Built Around the Needs of <em>Memory Care Residents.</em>
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

### Field: `intro` (Retired Section)
- **PHP Key Path:** `sections[3]['data']['intro']`
- **OLD CONTENT:**
```text
Every suite detail—from bathroom orientation to memory cues—is intentionally designed to reduce disorientation and provide peace of mind.
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

---

## Section 05: FAQs (`suites-floor-plans.faq`)
**Section Key:** `sfp-faq`
**Status:** MODIFIED (Pruned from 6 FAQs to 3 core questions)

### FAQ 1: Personalizing Suites
#### Field: `faqs[0]['question']`
- **PHP Key Path:** `sections[4]['data']['faqs'][0]['question']`
- **OLD CONTENT:**
```text
Are suites furnished, or can we bring our loved one’s own furniture?
```
- **NEW CONTENT:**
```text
Can we personalize a suite?
```

#### Field: `faqs[0]['answer']`
- **PHP Key Path:** `sections[4]['data']['faqs'][0]['answer']`
- **OLD CONTENT:**
```text
Families are warmly encouraged to bring familiar bedroom furniture, favorite recliners, cherished quilts, and framed family photos to make the suite feel truly like home. If needed, Mission Villa can also assist with comfortable furnishings to ensure an easy transition.
```
- **NEW CONTENT:**
```text
Ask the team about bringing photographs, bedding, and other familiar items; suitability depends on the room and safety requirements.
```

### FAQ 2: Pricing
#### Field: `faqs[3]['question']`
- **PHP Key Path:** `sections[4]['data']['faqs'][3]['question']`
- **OLD CONTENT:**
```text
How does pricing differ between private and companion suites?
```
- **NEW CONTENT:**
```text
How do we compare suite prices?
```

#### Field: `faqs[3]['answer']`
- **PHP Key Path:** `sections[4]['data']['faqs'][3]['answer']`
- **OLD CONTENT:**
```text
Pricing reflects the selected suite layout (private vs. companion) alongside individual care support requirements determined during your initial wellness assessment. Our team provides clear, transparent cost sheets during your visit.
```
- **NEW CONTENT:**
```text
Room type and care needs can affect pricing. The team can explain current options and provide details.
```

### FAQ 3: Attached Bathrooms
#### Field: `faqs[1]['question']`
- **PHP Key Path:** `sections[4]['data']['faqs'][1]['question']`
- **OLD CONTENT:**
```text
Do all suites include a private bathroom?
```
- **NEW CONTENT:**
```text
Do suites have attached bathrooms?
```

#### Field: `faqs[1]['answer']`
- **PHP Key Path:** `sections[4]['data']['faqs'][1]['answer']`
- **OLD CONTENT:**
```text
Yes. Both our private suites and companion units include private en-suite bathrooms located directly inside the accommodation, rather than communal corridor-style restrooms. This ensures personal dignity and comfort at all hours.
```
- **NEW CONTENT:**
```text
The source materials describe attached bathrooms for these formats. Confirm the specific room layout during your tour.
```

*(Note: Surplus FAQs in PHP `faqs[2]`, `faqs[4]`, `faqs[5]` are disabled in Editorial V2).*

---

## Section 06: Closing CTA (`visit.cta`)
**Section Key:** `sfp-cta`
**Status:** MODIFIED

### Field: `heading`
- **PHP Key Path:** `sections[5]['data']['heading']`
- **OLD CONTENT:**
```text
Experience the Comfort & Warmth
```
- **NEW CONTENT:**
```text
See the available spaces for yourself.
```

### Field: `body`
- **PHP Key Path:** `sections[5]['data']['body']`
- **OLD CONTENT:**
```text
Schedule a personal tour to walk our private and companion suites, meet our memory care team, and explore our secure courtyard in Daly City.
```
- **NEW CONTENT:**
```text
Tour a suite, ask about layouts, and discuss the options for your loved one.
```

### Action Configuration:
- Schedule a Suite Tour (`schedule_visit` modal, care: `exploring`)
- Request Availability (`request_availability` modal, care: `exploring`)
- Request Pricing (`request_pricing` modal, care: `exploring`)
- Phone: `(650) 756-1995`
