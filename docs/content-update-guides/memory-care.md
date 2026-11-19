# Content Update Guide: Memory Care Page (`memory-care`)

**Route:** `/memory-care`
**PHP Source File:** `content/pages/memory-care.php`
**Current Content Spec:** `docs/pages/memory-care.md`
**Editorial V2 Source:** `docs/Mission_Villa_Website_Content_Editorial_V2/pages/memory-care.md`

---

## Executive Summary of Changes
- **Total Sections in PHP:** 6 (`mc-hero`, `mc-legacies`, `mc-daily`, `mc-care`, `mc-faq`, `mc-cta`)
- **Sections Modified:** 6 (All 6 sections retained, copy substantially condensed and de-duplicated)
- **Sections Retired / Removed:** None; 4 touchpoints in `mc-legacies` condensed into 3 focused areas
- **Key Editorial Directions:**
  - Clear, empathetic tone focusing on personal dignity and routine.
  - Three distinct Legacies™ focus areas (Personal History, Familiar Routines, Connection).
  - Daily life structured simply into Morning, Afternoon, and Evening overviews.
  - Featured FAQs condensed from 5 lengthy answers to 3 direct questions.

---

## SEO & Page Metadata

### Field: `title`
- **PHP Key Path:** `title`
- **OLD CONTENT:**
```text
Legacies™ Memory Care | Mission Villa Senior Living
```
- **NEW CONTENT:**
```text
Legacies™ Memory Care in Daly City | Mission Villa
```

### Field: `seo['title']`
- **PHP Key Path:** `seo['title']`
- **OLD CONTENT:**
```text
Legacies™ Memory Care in Daly City | Mission Villa Senior Living
```
- **NEW CONTENT:**
```text
Legacies™ Memory Care in Daly City | Mission Villa
```

### Field: `seo['description']`
- **PHP Key Path:** `seo['description']`
- **OLD CONTENT:**
```text
Dedicated Memory Care in Daly City featuring the Legacies™ program. Dignity, familiar routines, personalized Alzheimer’s & dementia support, and 24/7 care.
```
- **NEW CONTENT:**
```text
Learn about Legacies™ Memory Care at Mission Villa in Daly City: personalized routines, meaningful activities, and family involvement.
```

---

## Section 01: Hero (`memory-care.hero`)
**Section Key:** `mc-hero`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[0]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Memory Care at Mission Villa
```
- **NEW CONTENT:**
```text
Legacies™ Memory Care
```

### Field: `heading`
- **PHP Key Path:** `sections[0]['data']['heading']`
- **OLD CONTENT:**
```text
Legacies™ Memory Care
```
- **NEW CONTENT:**
```text
Memory care that starts with the person.
```

### Field: `intro`
- **PHP Key Path:** `sections[0]['data']['intro']`
- **OLD CONTENT:**
```text
A warm, nurturing environment with personalized care, familiar daily routines, and compassionate 24/7 support in Daly City. Where your loved one is genuinely known, and dignity always comes first.
```
- **NEW CONTENT:**
```text
When someone is living with Alzheimer's disease or another form of dementia, familiar things matter. At Mission Villa, care is shaped around personal history, daily routines, and respectful support.
```

### Field: `actions[1]['label']`
- **PHP Key Path:** `sections[0]['data']['actions'][1]['label']`
- **OLD CONTENT:**
```text
Explore the Legacies™ Approach
```
- **NEW CONTENT:**
```text
See Our Living Options
```
*(Note: Link target switches to `/living-options`).*

---

## Section 02: Legacies™ (`memory-care.legacies`)
**Section Key:** `mc-legacies`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[1]['data']['eyebrow']`
- **OLD CONTENT:**
```text
The Legacies™ Difference
```
- **NEW CONTENT:**
```text
Our Approach
```

### Field: `heading`
- **PHP Key Path:** `sections[1]['data']['heading']`
- **OLD CONTENT:**
```text
Personalized Memory Care <em>with Purpose</em>
```
- **NEW CONTENT:**
```text
A life story is part of the care plan.
```

### Field: `intro`
- **PHP Key Path:** `sections[1]['data']['intro']`
- **OLD CONTENT:**
```text
Thoughtful, person-centered care that celebrates each resident’s history, abilities, and sense of self.
```
- **NEW CONTENT:**
```text
We listen to families and learn about each resident's interests, habits, and ways of finding comfort. That understanding guides everyday interactions.
```

### Touchpoints Condensation:
#### Touchpoint 1: Personal History
##### Field: `touchpoints[0]['title']`
- **PHP Key Path:** `sections[1]['data']['touchpoints'][0]['title']`
- **OLD CONTENT:**
```text
Knowing the Person Behind the Memory
```
- **NEW CONTENT:**
```text
Personal history
```

##### Field: `touchpoints[0]['description']`
- **PHP Key Path:** `sections[1]['data']['touchpoints'][0]['description']`
- **OLD CONTENT:**
```text
In our Legacies™ Memory Care program, support begins with listening. We partner with families to understand each resident’s background, lifelong habits, favorite music, and personal accomplishments so our team can connect with who they have always been.
```
- **NEW CONTENT:**
```text
Favorite music, memories, and meaningful relationships.
```

#### Touchpoint 2: Familiar Routines
##### Field: `touchpoints[1]['title']`
- **PHP Key Path:** `sections[1]['data']['touchpoints'][1]['title']`
- **OLD CONTENT:**
```text
Calm, Predictable Days Without Rigidity
```
- **NEW CONTENT:**
```text
Familiar routines
```

##### Field: `touchpoints[1]['description']`
- **PHP Key Path:** `sections[1]['data']['touchpoints'][1]['description']`
- **OLD CONTENT:**
```text
For older adults living with memory loss, a calm and recognizable daily flow creates a natural sense of ease. Rather than enforcing a rigid institutional timetable, we guide each day with gentle cues, unhurried mornings, and familiar transitions.
```
- **NEW CONTENT:**
```text
Gentle support with daily activities at an individual pace.
```

#### Touchpoint 3: Connection
##### Field: `touchpoints[2]['title']`
- **PHP Key Path:** `sections[1]['data']['touchpoints'][2]['title']`
- **OLD CONTENT:**
```text
Everyday Moments of Joy & Belonging
```
- **NEW CONTENT:**
```text
Connection
```

##### Field: `touchpoints[2]['description']`
- **PHP Key Path:** `sections[1]['data']['touchpoints'][2]['description']`
- **OLD CONTENT:**
```text
Through Legacies™ Memory Care and our daily activity programming, residents are invited into small-group and one-on-one experiences that spark recognition, creativity, and camaraderie—without pressure or frustration.
```
- **NEW CONTENT:**
```text
Opportunities for conversation, activities, and family visits.
```

*(Note: Surplus touchpoint `touchpoints[3]` ('Supporting the Whole Family Journey') is merged into FAQ 2 / Connection in Editorial V2 and can be removed or disabled).*

---

## Section 03: Daily Life (`memory-care.daily-life`)
**Section Key:** `mc-daily`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[2]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Daily Life in Memory Care
```
- **NEW CONTENT:**
```text
A Typical Day
```

### Field: `heading`
- **PHP Key Path:** `sections[2]['data']['heading']`
- **OLD CONTENT:**
```text
A Day Shaped <em>Around the Individual</em>
```
- **NEW CONTENT:**
```text
Support throughout the day.
```

### Morning Scene
#### Field: `scenes[0]['narrative']`
- **PHP Key Path:** `sections[2]['data']['scenes'][0]['narrative']`
- **OLD CONTENT:**
```text
Mornings begin at a human pace. Attentive assistance with bathing, dressing, and grooming honors privacy while gently guiding residents toward breakfast.
```
- **NEW CONTENT:**
```text
Help with personal routines and a welcoming breakfast.
```

### Midday / Afternoon Scene
#### Field: `scenes[1]['narrative']`
- **PHP Key Path:** `sections[2]['data']['scenes'][1]['narrative']`
- **OLD CONTENT:**
```text
Meals are familiar anchors of the day. Residents gather in our dining room for freshly prepared meals served with attentive table support and companionship.
```
- **NEW CONTENT:**
```text
Shared meals, music or other activities, and quiet time when needed.
```

### Evening Scene
#### Field: `scenes[2]['narrative']`
- **PHP Key Path:** `sections[2]['data']['scenes'][2]['narrative']`
- **OLD CONTENT:**
```text
Music, reminiscence, art, and patio time transition naturally into calm evening routines that help residents feel peaceful, secure, and settled.
```
- **NEW CONTENT:**
```text
A familiar pace and assistance with settling in.
```

---

## Section 04: Care & Comfort (`memory-care.care-comfort`)
**Section Key:** `mc-care`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[3]['data']['eyebrow']`
- **OLD CONTENT:**
```text
A Supportive Place to Live
```
- **NEW CONTENT:**
```text
At Home at Mission Villa
```

### Field: `heading`
- **PHP Key Path:** `sections[3]['data']['heading']`
- **OLD CONTENT:**
```text
Care, Comfort & <em>Home</em>
```
- **NEW CONTENT:**
```text
Care, comfort, and room for family.
```

### Field: `reassurance_box['text']`
- **PHP Key Path:** `sections[3]['data']['reassurance_box']['text']`
- **OLD CONTENT:**
```text
Every resident’s support plan is shaped around an individual assessment and ongoing family conversation. Ask our team how we accommodate specific routines.
```
- **NEW CONTENT:**
```text
We encourage families to talk with the team about their loved one's specific needs before making a decision.
```

---

## Section 05: FAQs (`faq.featured`)
**Section Key:** `mc-faq`
**Status:** MODIFIED (Condensed from 5 FAQs to 3 focused Q&As)

### FAQ 1: Who it is for
#### Field: `entries[0]['question']`
- **PHP Key Path:** `sections[4]['data']['entries'][0]['question']`
- **OLD CONTENT:**
```text
What makes the Legacies™ Memory Care approach meaningful for residents?
```
- **NEW CONTENT:**
```text
Who is Memory Care for?
```

#### Field: `entries[0]['answer']`
- **PHP Key Path:** `sections[4]['data']['entries'][0]['answer']`
- **OLD CONTENT:**
```text
Legacies™ Memory Care centers on honoring who each resident is—their personal history, life accomplishments, family relationships, and comforting routines. By learning your loved one’s story, our staff can provide individualized care and activities that foster dignity, familiarity, and connection.
```
- **NEW CONTENT:**
```text
Older adults living with Alzheimer's disease or other forms of dementia who may benefit from ongoing residential support. Admission depends on an individual care assessment.
```

### FAQ 2: Family Involvement
#### Field: `entries[4]['question']`
- **PHP Key Path:** `sections[4]['data']['entries'][4]['question']`
- **OLD CONTENT:**
```text
How can family members visit and stay involved after move-in?
```
- **NEW CONTENT:**
```text
Can our family stay involved?
```

#### Field: `entries[4]['answer']`
- **PHP Key Path:** `sections[4]['data']['entries'][4]['answer']`
- **OLD CONTENT:**
```text
Families are always an essential part of life at Mission Villa. We welcome regular visits in our lounges, dining room, and courtyard patio, maintain open communication regarding wellbeing, and partner with you on care planning.
```
- **NEW CONTENT:**
```text
Yes. Family knowledge, regular conversations, and visits are important parts of our approach.
```

### FAQ 3: Getting Started
#### Field: `entries[1]['question']`
- **PHP Key Path:** `sections[4]['data']['entries'][1]['question']`
- **OLD CONTENT:**
```text
What kind of everyday assistance and 24-hour safety support do residents receive?
```
- **NEW CONTENT:**
```text
How do we get started?
```

#### Field: `entries[1]['answer']`
- **PHP Key Path:** `sections[4]['data']['entries'][1]['answer']`
- **OLD CONTENT:**
```text
Staff members are on-site 24 hours a day to provide compassionate help with everyday tasks such as bathing, dressing, grooming, escorting to meals and activities, housekeeping, and laundry. Routine assessments help us tailor support as a resident’s needs change.
```
- **NEW CONTENT:**
```text
Call (650) 756-1995 or request a visit to discuss care needs and current suite options.
```

*(Note: Surplus FAQs in PHP `entries[2]` and `entries[3]` are retired or disabled in Editorial V2).*

---

## Section 06: Closing CTA (`visit.cta`)
**Section Key:** `mc-cta`
**Status:** MODIFIED

### Field: `heading`
- **PHP Key Path:** `sections[5]['data']['heading']`
- **OLD CONTENT:**
```text
Talk With Our Memory Care Team
```
- **NEW CONTENT:**
```text
Let's talk about your loved one.
```

### Field: `body`
- **PHP Key Path:** `sections[5]['data']['body']`
- **OLD CONTENT:**
```text
We’re here to help you explore care options and see what personalized Memory Care looks like at Mission Villa. Schedule a tour, request pricing, or speak directly with our Daly City team.
```
- **NEW CONTENT:**
```text
We'll answer your questions and help you decide whether Mission Villa is a good fit.
```

### Action Configuration:
- Schedule a Visit (`schedule_visit` modal, care: `memory_care`)
- Request Pricing (`request_pricing` modal, care: `memory_care`)
- Request a Call (`request_callback` modal)
- Phone: `(650) 756-1995`
