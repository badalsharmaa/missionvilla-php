# Content Update Guide: About Us Page (`about`)

**Route:** `/about`
**PHP Source File:** `content/pages/about.php`
**Current Content Spec:** `docs/pages/about.md`
**Editorial V2 Source:** `docs/Mission_Villa_Website_Content_Editorial_V2/pages/about.md`

---

## Executive Summary of Changes
- **Total Sections in PHP:** 6 (`about-hero`, `about-philosophy`, `about-geography`, `about-core-values`, `about-team`, `about-cta`)
- **Sections Modified:** 5 (`about-hero`, `about-philosophy`, `about-geography`, `about-team`, `about-cta`)
- **Sections Retired / Merged:** 1 (`about-core-values` merged into `about-philosophy`; recommend `'enabled' => false`)
- **Key Editorial Directions:**
  - One concise story and three simple principles: Dignity first, Care that feels familiar, Family connection.
  - Zero fabricated staff biographies, stock portraits, awards, or false family testimonials.
  - Pet policy intentionally withheld pending client confirmation.
  - Warm, neighborhood-focused introduction to Daly City and San Bruno Mountain.

---

## SEO & Page Metadata

### Field: `title`
- **PHP Key Path:** `title`
- **OLD CONTENT:**
```text
About Mission Villa Senior Living | Memory Care in Daly City, CA
```
- **NEW CONTENT:**
```text
About Mission Villa Senior Living | Daly City, CA
```

### Field: `seo['title']`
- **PHP Key Path:** `seo['title']`
- **OLD CONTENT:**
```text
About Us: Compassionate Memory Care in Daly City | Mission Villa
```
- **NEW CONTENT:**
```text
About Mission Villa Senior Living | Daly City, CA
```

### Field: `seo['description']`
- **PHP Key Path:** `seo['description']`
- **OLD CONTENT:**
```text
Discover Mission Villa Senior Living at 995 East Market Street in Daly City. Person-first Memory Care, Legacies™ philosophy, family support near San Bruno Mountain.
```
- **NEW CONTENT:**
```text
Get to know Mission Villa Senior Living, a Daly City community offering Legacies™ Memory Care and short-term Respite Care.
```

---

## Section 01: Hero (`about.hero`)
**Section Key:** `about-hero`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[0]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Community Monograph · Philosophy, Location & Stewardship
```
- **NEW CONTENT:**
```text
About Mission Villa
```

### Field: `heading`
- **PHP Key Path:** `sections[0]['data']['heading']`
- **OLD CONTENT:**
```text
Compassionate Memory Care Rooted in Dignity, Respect & Neighborhood Trust.
```
- **NEW CONTENT:**
```text
A caring community in Daly City.
```

### Field: `lead`
- **PHP Key Path:** `sections[0]['data']['lead']`
- **OLD CONTENT:**
```text
Located at 995 East Market Street in Daly City near the peaceful slopes of San Bruno Mountain, Mission Villa Senior Living is an intimate residential community dedicated to personalized Legacies™ Memory Care and short-term Respite Care. Every day, we honor the individual behind each life story while supporting the families who love them.
```
- **NEW CONTENT:**
```text
At Mission Villa, we focus on two things: providing thoughtful care and helping residents feel at home. Our community offers Legacies™ Memory Care and short-term Respite Care, with families welcomed as partners.
```

### Field: `actions[0]['label']`
- **PHP Key Path:** `sections[0]['data']['actions'][0]['label']`
- **OLD CONTENT:**
```text
Schedule a Tour Visit
```
- **NEW CONTENT:**
```text
Schedule a Visit
```

### Field: `actions[1]['label']`
- **PHP Key Path:** `sections[0]['data']['actions'][1]['label']`
- **OLD CONTENT:**
```text
Read Our Philosophy
```
- **NEW CONTENT:**
```text
Our Care Options
```
*(Note: Link target switches to `/living-options`).*

---

## Section 02: Our Approach (`about.philosophy`)
**Section Key:** `about-philosophy`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[1]['data']['eyebrow']`
- **OLD CONTENT:**
```text
What Guides Every Day
```
- **NEW CONTENT:**
```text
What Matters Here
```

### Field: `heading`
- **PHP Key Path:** `sections[1]['data']['heading']`
- **OLD CONTENT:**
```text
Our Care Philosophy: <em>Person-Centered Support Built on Relationship.</em>
```
- **NEW CONTENT:**
```text
We see the person, not just the care needs.
```

### Field: `intro`
- **PHP Key Path:** `sections[1]['data']['intro']`
- **OLD CONTENT:**
```text
At Mission Villa, Memory Care and Respite Care are never reduced to impersonal checklists. Select any of the four chapters below to explore how our philosophy shapes daily life for residents and families in Daly City.
```
- **NEW CONTENT:**
```text
A favorite song. A familiar morning routine. The people who make someone smile. These details help us understand each resident and make daily life more comfortable.
```

### Principle 1: Dignity First
#### Field: `chapters[0]['title']`
- **PHP Key Path:** `sections[1]['data']['chapters'][0]['title']`
- **OLD CONTENT:**
```text
Honoring the Individual Behind Every Life Story
```
- **NEW CONTENT:**
```text
Dignity first
```

#### Field: `chapters[0]['subtitle']`
- **PHP Key Path:** `sections[1]['data']['chapters'][0]['subtitle']`
- **OLD CONTENT:**
```text
Care shaped around lifelong identity, personal privacy, and self-respect
```
- **NEW CONTENT:**
```text
Respect for personal preferences, privacy, and the pace of each day.
```

### Principle 2: Care That Feels Familiar
#### Field: `chapters[1]['title']`
- **PHP Key Path:** `sections[1]['data']['chapters'][1]['title']`
- **OLD CONTENT:**
```text
The Legacies™ Philosophy of Familiar Connection
```
- **NEW CONTENT:**
```text
Care that feels familiar
```

#### Field: `chapters[1]['subtitle']`
- **PHP Key Path:** `sections[1]['data']['chapters'][1]['subtitle']`
- **OLD CONTENT:**
```text
Connecting past history with present comfort and daily purpose
```
- **NEW CONTENT:**
```text
Learning each resident's story and building on routines they know.
```

### Principle 3: Family Connection
#### Field: `chapters[2]['title']`
- **PHP Key Path:** `sections[1]['data']['chapters'][2]['title']`
- **OLD CONTENT:**
```text
Lifting the Caregiving Burden So Families Can Reconnect
```
- **NEW CONTENT:**
```text
Family connection
```

#### Field: `chapters[2]['subtitle']`
- **PHP Key Path:** `sections[1]['data']['chapters'][2]['subtitle']`
- **OLD CONTENT:**
```text
Standing beside spouses, adult children, and relatives at every step
```
- **NEW CONTENT:**
```text
Keeping loved ones involved in conversations about care and daily life.
```

*(Note: Surplus chapter in PHP `chapters[3]` 'A Homelike Community Rather Than an Institution' is merged into Section 01 and Section 03; link targets update to `/memory-care`).*

---

## Section 03: Our Neighborhood (`about.geography`)
**Section Key:** `about-geography`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[2]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Rooted in Daly City & the Peninsula
```
- **NEW CONTENT:**
```text
Our Location
```

### Field: `heading`
- **PHP Key Path:** `sections[2]['data']['heading']`
- **OLD CONTENT:**
```text
A Peaceful Neighborhood Setting <em>Near San Bruno Mountain.</em>
```
- **NEW CONTENT:**
```text
Close to the people who matter.
```

### Field: `intro`
- **PHP Key Path:** `sections[2]['data']['intro']`
- **OLD CONTENT:**
```text
Where a community is located shapes both resident peace and how often family members can visit. At 995 East Market Street in Daly City, Mission Villa pairs tranquil hillside surroundings near San Bruno Mountain with effortless access to San Francisco and Peninsula amenities.
```
- **NEW CONTENT:**
```text
Located on East Market Street in Daly City, Mission Villa is near San Bruno Mountain and accessible to families across San Francisco and the Peninsula. We encourage families to visit and see the community firsthand.
```

---

## Section 04: Core Values (`about.core-values`)
**Section Key:** `about-core-values`
**Status:** RETIRED / MERGED IN V2

### Editorial Action:
- Retired per `CONTENT_MAP.md` and V2 notes: "about-core-values merged into philosophy; do not render a duplicate four-card values strip."
- **Recommended PHP Action:** Set `'enabled' => false`.

### Field: `heading` (Retired Section)
- **PHP Key Path:** `sections[3]['data']['heading']`
- **OLD CONTENT:**
```text
How Our Core Values <em>Shape Daily Community Activities.</em>
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

---

## Section 05: Meet the Team (`about.team-commitment`)
**Section Key:** `about-team`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[4]['data']['eyebrow']`
- **OLD CONTENT:**
```text
People & Care Stewardship
```
- **NEW CONTENT:**
```text
The People Behind the Care
```

### Field: `heading`
- **PHP Key Path:** `sections[4]['data']['heading']`
- **OLD CONTENT:**
```text
Meet Our Team in Person at 995 East Market Street.
```
- **NEW CONTENT:**
```text
Come meet our team.
```

### Field: `intro`
- **PHP Key Path:** `sections[4]['data']['intro']`
- **OLD CONTENT:**
```text
Rather than displaying stock portraits or generic staff profiles online, we invite families to meet our real Daly City caregivers, Activity Director, culinary team, and leadership in person during a visit. Select a team role below to see how each department supports your loved one and what questions to bring on your tour.
```
- **NEW CONTENT:**
```text
Our caregivers and community staff help with everyday routines, meals, activities, and family questions. A visit is the best way to meet the people who will be part of your loved one's day.
```

*(Note: Pet policy in `about-team` is intentionally withheld pending client confirmation).*

---

## Section 06: Closing CTA (`visit.cta`)
**Section Key:** `about-cta`
**Status:** MODIFIED

### Field: `heading`
- **PHP Key Path:** `sections[5]['data']['heading']`
- **OLD CONTENT:**
```text
Schedule a Visit to Mission Villa in Daly City
```
- **NEW CONTENT:**
```text
We'd be glad to show you around.
```

### Field: `body`
- **PHP Key Path:** `sections[5]['data']['body']`
- **OLD CONTENT:**
```text
Meet our care team, walk through our courtyard gardens and private suites, and discover how our person-first philosophy brings comfort to seniors and their families.
```
- **NEW CONTENT:**
```text
See the suites, shared spaces, and courtyard, and ask our team your questions.
```

### Action Configuration:
- Schedule a Visit (`schedule_visit` modal, care: `exploring`)
- Request Pricing (`request_pricing` modal, care: `exploring`)
- Request a Call (`request_callback` modal)
- Phone: `(650) 756-1995`
