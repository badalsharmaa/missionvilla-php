# Content Update Guide: Services & Amenities Page (`services-and-amenities`)

**Route:** `/services-and-amenities`
**PHP Source File:** `content/pages/services-and-amenities.php`
**Current Content Spec:** `docs/pages/services-and-amenities.md`
**Editorial V2 Source:** `docs/Mission_Villa_Website_Content_Editorial_V2/pages/services-and-amenities.md`

---

## Executive Summary of Changes
- **Total Sections in PHP:** 6 (`sa-hero`, `sa-explorer`, `sa-diptych`, `sa-disclosures`, `sa-care-bridge`, `sa-cta`)
- **Sections Modified:** 5 (`sa-hero`, `sa-explorer`, `sa-disclosures`, `sa-care-bridge`, `sa-cta`)
- **Sections Retired / Removed:** 1 (`sa-diptych` retired; recommend `'enabled' => false`)
- **Key Editorial Directions:**
  - Condensed 20+ itemized card directory into 4 clear service groups (Support, Meals, Activities, Conveniences).
  - Explicit instruction: withhold claims about on-site salon/spa, therapy animals, high-speed Wi-Fi, specialized diets, or scheduled medical transport until confirmed with client leadership.
  - Transparent disclosures on base inclusions versus optional extra charges.

---

## SEO & Page Metadata

### Field: `title`
- **PHP Key Path:** `title`
- **OLD CONTENT:**
```text
Services & Amenities | Memory Care Community Features in Daly City
```
- **NEW CONTENT:**
```text
Services & Amenities | Mission Villa Senior Living
```

### Field: `seo['title']`
- **PHP Key Path:** `seo['title']`
- **OLD CONTENT:**
```text
Services & Amenities: 24/7 Support, Dining & Care in Daly City | Mission Villa
```
- **NEW CONTENT:**
```text
Services & Amenities | Mission Villa Senior Living
```

### Field: `seo['description']`
- **PHP Key Path:** `seo['description']`
- **OLD CONTENT:**
```text
Explore services and amenities at Mission Villa Senior Living in Daly City. 24-hour care team, chef-prepared dining, courtyard gardens, housekeeping, and life enrichment.
```
- **NEW CONTENT:**
```text
Explore everyday support, dining, activities, suites, and shared spaces at Mission Villa Senior Living in Daly City.
```

---

## Section 01: Hero (`services-and-amenities.hero`)
**Section Key:** `sa-hero`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[0]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Services & Amenities Directory
```
- **NEW CONTENT:**
```text
Services & Amenities
```

### Field: `heading`
- **PHP Key Path:** `sections[0]['data']['heading']`
- **OLD CONTENT:**
```text
Thoughtful Support & Comfort, <em>Rooted in Everyday Dignity.</em>
```
- **NEW CONTENT:**
```text
Thoughtful support for everyday living.
```

### Field: `intro`
- **PHP Key Path:** `sections[0]['data']['intro']`
- **OLD CONTENT:**
```text
At Mission Villa, practical assistance is woven seamlessly into everyday life. From chef-prepared restaurant-style meals and personal laundry to 24-hour attentive caregivers and secure courtyard gardens, our community provides everything needed for comfort, safety, and joy.
```
- **NEW CONTENT:**
```text
The comforts of home matter. At Mission Villa, daily assistance, shared meals, welcoming spaces, and opportunities to connect are part of community life.
```

### Field: `actions[0]['label']`
- **PHP Key Path:** `sections[0]['data']['actions'][0]['label']`
- **OLD CONTENT:**
```text
Explore Offerings by Need
```
- **NEW CONTENT:**
```text
Schedule a Visit
```

### Field: `actions[1]['label']`
- **PHP Key Path:** `sections[0]['data']['actions'][1]['label']`
- **OLD CONTENT:**
```text
Ask About Inclusions
```
- **NEW CONTENT:**
```text
Ask What's Included
```
*(Note: Intent is `request_pricing`, care: `exploring`).*

---

## Section 02: Services at a Glance (`services-and-amenities.explorer`)
**Section Key:** `sa-explorer`
**Status:** MODIFIED (Condensed from 5 categories & 20+ cards to 4 core groups)

### Field: `eyebrow`
- **PHP Key Path:** `sections[1]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Categorized Directory & Explorer
```
- **NEW CONTENT:**
```text
Everyday Comforts
```

### Field: `heading`
- **PHP Key Path:** `sections[1]['data']['heading']`
- **OLD CONTENT:**
```text
Explore Services & Amenities by <em>Daily Need.</em>
```
- **NEW CONTENT:**
```text
What life here can include.
```

### Service Group 1: Support When It's Needed
#### Field: `categories[0]['title']`
- **PHP Key Path:** `sections[1]['data']['categories'][0]['title']`
- **OLD CONTENT:**
```text
24-Hour Support & Personalized Care
```
- **NEW CONTENT:**
```text
Support When It's Needed
```

#### Field: `categories[0]['narrative']`
- **PHP Key Path:** `sections[1]['data']['categories'][0]['narrative']`
- **OLD CONTENT:**
```text
Practical care at Mission Villa is woven quietly into daily life so residents feel supported without feeling managed. Our on-site team is present 24 hours a day to assist with daily routines, help residents move comfortably between their suites and common areas, and adjust care plans through routine assessments as needs evolve.
```
- **NEW CONTENT:**
```text
On-site staff are available day and night. Personal assistance is guided by each resident's assessed care needs.
```

### Service Group 2: Meals & Dining
#### Field: `categories[1]['title']`
- **PHP Key Path:** `sections[1]['data']['categories'][1]['title']`
- **OLD CONTENT:**
```text
Dining & Hospitality
```
- **NEW CONTENT:**
```text
Meals & Dining
```

#### Field: `categories[1]['narrative']`
- **PHP Key Path:** `sections[1]['data']['categories'][1]['narrative']`
- **OLD CONTENT:**
```text
Dining at Mission Villa is an unhurried social anchor of the day. Residents gather in our welcoming dining room for chef-prepared meals served directly at the table, where familiar flavors, attentive hospitality, and conversation with neighbors turn every meal into a moment of belonging.
```
- **NEW CONTENT:**
```text
Three prepared meals each day, served in a shared dining setting, with individual needs discussed with the team.
```

### Service Group 3: Activities & Community Life
#### Field: `categories[2]['title']`
- **PHP Key Path:** `sections[1]['data']['categories'][2]['title']`
- **OLD CONTENT:**
```text
Lifestyle & Activities
```
- **NEW CONTENT:**
```text
Activities & Community Life
```

#### Field: `categories[2]['narrative']`
- **PHP Key Path:** `sections[1]['data']['categories'][2]['narrative']`
- **OLD CONTENT:**
```text
A meaningful day balances purposeful activity with personal pride and relaxation. Guided by our dedicated activity director, daily life includes creative art, tabletop games, gentle fitness, live entertainment, and volunteer programs—alongside an on-site salon/spa setting where residents can enjoy familiar grooming and self-care.
```
- **NEW CONTENT:**
```text
Residents can enjoy music, creative activities, gentle movement, conversation, or quiet time.
```

### Service Group 4: Everyday Conveniences
#### Field: `categories[4]['title']`
- **PHP Key Path:** `sections[1]['data']['categories'][4]['title']`
- **OLD CONTENT:**
```text
Everyday Convenience
```
- **NEW CONTENT:**
```text
Everyday Conveniences
```

#### Field: `categories[4]['narrative']`
- **PHP Key Path:** `sections[1]['data']['categories'][4]['narrative']`
- **OLD CONTENT:**
```text
Moving into senior living should free both residents and relatives from exhausting household logistics. From personal laundry and linen care to concierge assistance, scheduled transportation, and convenient on-site parking for visitors, our everyday conveniences make life smoother for everyone.
```
- **NEW CONTENT:**
```text
Housekeeping, laundry, and linen services help make day-to-day living simpler.
```

*(Note: Category 4 'Courtyard & Spaces' is folded into Activities & Community Life. The individual 20+ item directory items are retired from public display).*

---

## Section 03: Diptych (`services-and-amenities.diptych`)
**Section Key:** `sa-diptych`
**Status:** RETIRED / REMOVED IN V2

### Editorial Action:
- Retired per `CONTENT_MAP.md` and V2 notes.
- **Recommended PHP Action:** Set `'enabled' => false`.

### Field: `heading` (Retired Section)
- **PHP Key Path:** `sections[2]['data']['heading']`
- **OLD CONTENT:**
```text
How Everyday Services & Spaces Come Together at <em>995 East Market Street.</em>
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

### Field: `intro` (Retired Section)
- **PHP Key Path:** `sections[2]['data']['intro']`
- **OLD CONTENT:**
```text
A service list only matters when it translates into real human comfort. Here is how our dining room, courtyard, and on-site care work together throughout the day.
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

---

## Section 04: Disclosures (`services-and-amenities.disclosures`)
**Section Key:** `sa-disclosures`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[3]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Transparent Guidance for Families
```
- **NEW CONTENT:**
```text
Clear Answers
```

### Field: `heading`
- **PHP Key Path:** `sections[3]['data']['heading']`
- **OLD CONTENT:**
```text
Ask Us About Eligibility, Inclusions &amp; <em>Current Availability.</em>
```
- **NEW CONTENT:**
```text
Know the details before you decide.
```

### Field: `intro`
- **PHP Key Path:** `sections[3]['data']['intro']`
- **OLD CONTENT:**
```text
The services and amenities shown on this page reflect authentic community offerings. Because each resident’s health profile and mobility needs are unique, we encourage families to review specific details with our Daly City team.
```
- **NEW CONTENT:**
```text
Services and charges can vary with care needs, stay type, and optional requests. Ask the team for a current explanation of what's included and what may cost extra.
```

### Field: `action_card['cta_label']`
- **PHP Key Path:** `sections[3]['data']['action_card']['cta_label']`
- **OLD CONTENT:**
```text
Schedule an In-Person Tour
```
- **NEW CONTENT:**
```text
Request Pricing & Inclusions
```

---

## Section 05: Connected Care Pathways (`services-and-amenities.care-bridge`)
**Section Key:** `sa-care-bridge`
**Status:** MODIFIED

### Field: `heading`
- **PHP Key Path:** `sections[4]['data']['heading']`
- **OLD CONTENT:**
```text
How Services & Amenities Support Our <em>Two Care Programs.</em>
```
- **NEW CONTENT:**
```text
Care shaped around your family's needs.
```

### Card 1: Memory Care
#### Field: `programs[0]['summary']`
- **PHP Key Path:** `sections[4]['data']['programs'][0]['summary']`
- **OLD CONTENT:**
```text
Long-term residential memory care that surrounds residents with warmth, familiar routines, and continuous 24-hour dignified caregiver support.
```
- **NEW CONTENT:**
```text
Ongoing support.
```

### Card 2: Respite Care
#### Field: `programs[1]['summary']`
- **PHP Key Path:** `sections[4]['data']['programs'][1]['summary']`
- **OLD CONTENT:**
```text
Temporary, fully furnished stays that give family caregivers peace of mind while your loved one enjoys professional memory care and fellowship.
```
- **NEW CONTENT:**
```text
Temporary stays.
```

---

## Section 06: Closing CTA (`visit.cta`)
**Section Key:** `sa-cta`
**Status:** MODIFIED

### Field: `heading`
- **PHP Key Path:** `sections[5]['data']['heading']`
- **OLD CONTENT:**
```text
Schedule an In-Person Tour or Lunch Visit
```
- **NEW CONTENT:**
```text
See our community in person.
```

### Field: `body`
- **PHP Key Path:** `sections[5]['data']['body']`
- **OLD CONTENT:**
```text
See our comfortable dining room, meet our attentive care team, and experience the warm fellowship of Mission Villa Senior Living in Daly City.
```
- **NEW CONTENT:**
```text
Walk through the shared spaces and talk with us about daily support and services.
```

### Action Configuration:
- Schedule a Visit (`schedule_visit` modal, care: `exploring`)
- Request Pricing (`request_pricing` modal, care: `exploring`)
- Request a Call (`request_callback` modal)
- Phone: `(650) 756-1995`
