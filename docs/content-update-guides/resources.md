# Content Update Guide: Resources Page (`resources`)

**Route:** `/resources`
**PHP Source File:** `content/pages/resources.php`
**Current Content Spec:** `docs/pages/resources.md`
**Editorial V2 Source:** `docs/Mission_Villa_Website_Content_Editorial_V2/pages/resources.md`

---

## Executive Summary of Changes
- **Total Sections in PHP:** 6 (`res-hero`, `res-desk`, `res-packet`, `res-blog`, `res-faq`, `res-cta`)
- **Sections Modified:** 4 (`res-hero`, `res-desk`, `res-packet`, `res-cta`)
- **Sections Retired / Withheld:** 2 (`res-faq` retired per Editorial V2; `res-blog` withheld/hidden until actual client-approved articles exist; recommend `'enabled' => false` for both)
- **Key Editorial Directions:**
  - Clean gateway to practical family help, removing technical development logs, brochure-status ledgers, and editorial audit commentary.
  - Four helpful starting guides: Choosing Care, Costs & Planning, Preparing for a Visit, Daily Life & Suites.
  - Materials section refactored as an inquiry rather than a broken PDF download or prototype status flag.

---

## SEO & Page Metadata

### Field: `title`
- **PHP Key Path:** `title`
- **OLD CONTENT:**
```text
Caregiver & Family Resources Overview | Mission Villa Senior Living
```
- **NEW CONTENT:**
```text
Family Resources | Mission Villa Senior Living
```

### Field: `seo['title']`
- **PHP Key Path:** `seo['title']`
- **OLD CONTENT:**
```text
Caregiver & Family Resources: Guides, Brochure & Blog Status | Mission Villa
```
- **NEW CONTENT:**
```text
Family Resources | Mission Villa Senior Living
```

### Field: `seo['description']`
- **PHP Key Path:** `seo['description']`
- **OLD CONTENT:**
```text
Explore Mission Villa Senior Living resources in Daly City: Financial Planning paper ledger, Family Decision Guide & visit questions, community brochure packet builder, and transparent blog status.
```
- **NEW CONTENT:**
```text
Helpful starting points for families exploring Memory Care, Respite Care, costs, and visiting Mission Villa in Daly City.
```

---

## Section 01: Hero (`resources.hero`)
**Section Key:** `res-hero`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[0]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Family Reference Library · Guides, Brochure & Archive Status
```
- **NEW CONTENT:**
```text
Family Resources
```

### Field: `heading`
- **PHP Key Path:** `sections[0]['data']['heading']`
- **OLD CONTENT:**
```text
Practical Guides, Financial Clarity & <em>Honest Answers for Your Family’s Next Step</em>.
```
- **NEW CONTENT:**
```text
Helpful information, when you need it.
```

### Field: `lead`
- **PHP Key Path:** `sections[0]['data']['lead']`
- **OLD CONTENT:**
```text
Exploring Memory Care or a short-term Respite Care stay brings important questions about daily life, suite options, and monthly costs. This resource library gathers Mission Villa’s <a href="/financial-planning" class="underline decoration-[#C98268] font-semibold text-[#3B2348]">Financial Planning Paper-Ledger Guide</a>, <a href="/for-families" class="underline decoration-[#C98268] font-semibold text-[#3B2348]">Family Decision &amp; Tour Question Notebook</a>, <a href="#brochure-and-packet" class="underline decoration-[#C98268] font-semibold text-[#3B2348]">Community Brochure Packet Builder</a>, and transparent <a href="#blog-inventory-status" class="underline decoration-[#C98268] font-semibold text-[#3B2348]">Blog Inventory Status</a> into one calm, accessible reading desk.
```
- **NEW CONTENT:**
```text
Explore care options, prepare for a visit, or learn which questions to ask about cost. Start with the topic that's most useful to you.
```

### Field: `actions[0]['label']`
- **PHP Key Path:** `sections[0]['data']['actions'][0]['label']`
- **OLD CONTENT:**
```text
Schedule a Visit in Daly City
```
- **NEW CONTENT:**
```text
Ask a Question
```
*(Note: Action intent is `request_callback`, care: `exploring`).*

### Field: `actions[1]['label']`
- **PHP Key Path:** `sections[0]['data']['actions'][1]['label']`
- **OLD CONTENT:**
```text
Browse Resource Desk ↓
```
- **NEW CONTENT:**
```text
Schedule a Visit
```
*(Note: Action intent is `schedule_visit`, care: `exploring`).*

---

## Section 02: Helpful Guides (`resources.desk`)
**Section Key:** `res-desk`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[1]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Curated Family Planning Library
```
- **NEW CONTENT:**
```text
Start Here
```

### Field: `heading`
- **PHP Key Path:** `sections[1]['data']['heading']`
- **OLD CONTENT:**
```text
Explore Mission Villa’s Planning Guides, Checklists &amp; Archive Status
```
- **NEW CONTENT:**
```text
Find the information you're looking for.
```

### Guide 1: Choosing Care
#### Field: `items[4]['title']`
- **PHP Key Path:** `sections[1]['data']['items'][4]['title']`
- **OLD CONTENT:**
```text
Living Options Overview: Memory Care vs. Respite Care
```
- **NEW CONTENT:**
```text
Choosing Care
```

#### Field: `items[4]['summary']`
- **PHP Key Path:** `sections[1]['data']['items'][4]['summary']`
- **OLD CONTENT:**
```text
Mission Villa focuses exclusively on full-time Legacies™ Memory Care and short-term Respite Care (without separate standalone Independent or Assisted Living tiers). Use our Living Options Monograph to compare stay durations, daily rhythms, and Private, Companion Unit, and Jack & Jill suite accommodations.
```
- **NEW CONTENT:**
```text
Understand the difference between ongoing Memory Care and short-term Respite Care.
```

#### Field: `items[4]['primaryCtaLabel']`
- **PHP Key Path:** `sections[1]['data']['items'][4]['primaryCtaLabel']`
- **OLD CONTENT:**
```text
Open Living Options Overview
```
- **NEW CONTENT:**
```text
Compare Living Options
```

### Guide 2: Costs & Planning
#### Field: `items[0]['title']`
- **PHP Key Path:** `sections[1]['data']['items'][0]['title']`
- **OLD CONTENT:**
```text
Financial Planning & Paper-Ledger Comparison Guide
```
- **NEW CONTENT:**
```text
Costs & Planning
```

#### Field: `items[0]['summary']`
- **PHP Key Path:** `sections[1]['data']['items'][0]['summary']`
- **OLD CONTENT:**
```text
Designed to help families reason clearly about senior care costs without publishing fictitious rates or deceptive calculators. Explore the four factors that shape Memory Care and Respite Care pricing, review what is typically included in monthly support, and use our blank Paper-Ledger Worksheet to compare current home expenses at your own pace.
```
- **NEW CONTENT:**
```text
See what affects pricing and what to ask when requesting a quote.
```

#### Field: `items[0]['primaryCtaLabel']`
- **PHP Key Path:** `sections[1]['data']['items'][0]['primaryCtaLabel']`
- **OLD CONTENT:**
```text
Open Financial Planning Guide
```
- **NEW CONTENT:**
```text
Explore Financial Planning
```

### Guide 3: Preparing for a Visit
#### Field: `items[1]['title']`
- **PHP Key Path:** `sections[1]['data']['items'][1]['title']`
- **OLD CONTENT:**
```text
For Families: Decision Guide, Visit Notebook & Grouped FAQs
```
- **NEW CONTENT:**
```text
Preparing for a Visit
```

#### Field: `items[1]['summary']`
- **PHP Key Path:** `sections[1]['data']['items'][1]['summary']`
- **OLD CONTENT:**
```text
Our comprehensive companion for spouses, adult children, and relatives navigating a care transition. Compare Memory Care and short-term Respite Care across five practical dimensions, build a printable or attachable list of questions to bring on your Daly City tour, and search answers grouped by Care, Suites, Cost, and Visits.
```
- **NEW CONTENT:**
```text
Get a short list of useful questions to bring on a tour.
```

#### Field: `items[1]['primaryCtaLabel']`
- **PHP Key Path:** `sections[1]['data']['items'][1]['primaryCtaLabel']`
- **OLD CONTENT:**
```text
Open Family FAQs & Guidance
```
- **NEW CONTENT:**
```text
Visit the Family Guide
```

### Guide 4: Daily Life & Suites
#### Field: `items[5]['title']`
- **PHP Key Path:** `sections[1]['data']['items'][5]['title']`
- **OLD CONTENT:**
```text
Services, Amenities & Daily Life Guides
```
- **NEW CONTENT:**
```text
Daily Life & Suites
```

#### Field: `items[5]['summary']`
- **PHP Key Path:** `sections[1]['data']['items'][5]['summary']`
- **OLD CONTENT:**
```text
Explore practical day-to-day offerings across Support, Dining, Lifestyle, Community Spaces, and Convenience—including 24-hour staff, restaurant-style full-table dining, activity director programming, enclosed courtyard/patio spaces, and personal laundry service.
```
- **NEW CONTENT:**
```text
Explore the community's living spaces, meals, and day-to-day routines.
```

#### Field: `items[5]['primaryCtaLabel']`
- **PHP Key Path:** `sections[1]['data']['items'][5]['primaryCtaLabel']`
- **OLD CONTENT:**
```text
Open Services & Amenities Guide
```
- **NEW CONTENT:**
```text
See Daily Life
```

*(Note: Surplus items in PHP `items[2]` Community Brochure, `items[3]` Blog Inventory Status, and `items[5]` Memory Care are pruned or redirected to live sections).*

---

## Section 03: Brochures & Materials (`resources.packet`)
**Section Key:** `res-packet`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[2]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Printed &amp; Downloadable Materials
```
- **NEW CONTENT:**
```text
More Information
```

### Field: `heading`
- **PHP Key Path:** `sections[2]['data']['heading']`
- **OLD CONTENT:**
```text
Community Brochure Status &amp; Custom Visit Packet Builder
```
- **NEW CONTENT:**
```text
Need something specific?
```

### Field: `intro`
- **PHP Key Path:** `sections[2]['data']['intro']`
- **OLD CONTENT:**
```text
Families often appreciate having printed materials to review around the kitchen table with relatives. Here is the transparent status of our downloadable brochure alongside an interactive checklist to request specific materials for your tour at 995 East Market Street.
```
- **NEW CONTENT:**
```text
Ask our team about a community brochure, available suite layouts, or current activity information.
```

---

## Section 04: Articles & Advice (`resources.blog`)
**Section Key:** `res-blog`
**Status:** WITHHELD / HIDDEN UNTIL ARTICLES EXIST

### Editorial Action:
- Per Editorial V2: "Do not display this section or a /blog link until real, edited, approved articles are available. Never invent article authors or publication dates."
- **Recommended PHP Action:** Set `'enabled' => false`.

### Field: `heading` (Retired Section)
- **PHP Key Path:** `sections[3]['data']['heading']`
- **OLD CONTENT:**
```text
Mission Villa Blog Inventory &amp; Migration Status
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

---

## Section 05: FAQs (`resources.faq`)
**Section Key:** `res-faq`
**Status:** RETIRED / REMOVED IN V2

### Editorial Action:
- Retired per `CONTENT_MAP.md` ("technical brochure/blog-status interface removed").
- **Recommended PHP Action:** Set `'enabled' => false`.

### Field: `heading` (Retired Section)
- **PHP Key Path:** `sections[4]['data']['heading']`
- **OLD CONTENT:**
```text
Resources, Brochure &amp; Blog FAQs
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

---

## Section 06: Closing CTA (`visit.cta`)
**Section Key:** `res-cta`
**Status:** MODIFIED

### Field: `heading`
- **PHP Key Path:** `sections[5]['data']['heading']`
- **OLD CONTENT:**
```text
Walk Through Our Daly City Community in Person
```
- **NEW CONTENT:**
```text
Prefer to talk with someone?
```

### Field: `body`
- **PHP Key Path:** `sections[5]['data']['body']`
- **OLD CONTENT:**
```text
Meet our care leadership, tour available suites and courtyard, and receive printed copies of our family guides with zero pressure.
```
- **NEW CONTENT:**
```text
Our team can help point you toward the information you need.
```

### Action Configuration:
- Request a Call (`request_callback` modal)
- Schedule a Visit (`schedule_visit` modal, care: `exploring`)
- Phone: `(650) 756-1995`
