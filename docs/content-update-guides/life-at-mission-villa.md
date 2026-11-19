# Content Update Guide: Life at Mission Villa Page (`life-at-mission-villa`)

**Route:** `/life-at-mission-villa`
**PHP Source File:** `content/pages/life-at-mission-villa.php`
**Current Content Spec:** `docs/pages/life-at-mission-villa.md`
**Editorial V2 Source:** `docs/Mission_Villa_Website_Content_Editorial_V2/pages/life-at-mission-villa.md`

---

## Executive Summary of Changes
- **Total Sections in PHP:** 6 (`lmv-hero`, `lmv-pillars`, `lmv-rhythm`, `lmv-engagement`, `lmv-faq`, `lmv-cta`)
- **Sections Modified:** 5 (`lmv-hero`, `lmv-pillars`, `lmv-rhythm`, `lmv-faq`, `lmv-cta`)
- **Sections Retired / Removed:** 1 (`lmv-engagement` moved to future activity/blog content; recommend `'enabled' => false`)
- **Key Editorial Directions:**
  - Simple, grounded everyday language: "There is comfort in the everyday."
  - 3 concise pillars: Dining Together, Activities & Connection, Outdoor Moments.
  - Daily rhythm condensed to simple Morning, Afternoon, Evening summaries without rigid schedules.
  - FAQs condensed from 6 to 3 focused community questions.

---

## SEO & Page Metadata

### Field: `title`
- **PHP Key Path:** `title`
- **OLD CONTENT:**
```text
Life at Mission Villa | Memory Care Community Culture & Dining
```
- **NEW CONTENT:**
```text
Life at Mission Villa | Dining, Activities & Community
```

### Field: `seo['title']`
- **PHP Key Path:** `seo['title']`
- **OLD CONTENT:**
```text
Life at Mission Villa: Dining, Routine & Connection in Daly City
```
- **NEW CONTENT:**
```text
Life at Mission Villa | Dining, Activities & Community
```

### Field: `seo['description']`
- **PHP Key Path:** `seo['description']`
- **OLD CONTENT:**
```text
Discover daily life at Mission Villa in Daly City. Chef-prepared dining, reassuring daily routines, music, creative enrichment, and sunny courtyard garden strolls.
```
- **NEW CONTENT:**
```text
See daily life at Mission Villa Senior Living in Daly City: shared meals, music, activities, and time outdoors.
```

---

## Section 01: Hero (`life-at-mission-villa.hero`)
**Section Key:** `lmv-hero`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[0]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Community Culture & Daily Life
```
- **NEW CONTENT:**
```text
Life at Mission Villa
```

### Field: `heading`
- **PHP Key Path:** `sections[0]['data']['heading']`
- **OLD CONTENT:**
```text
Where Every Day Feels <em>Familiar, Connected & Warm.</em>
```
- **NEW CONTENT:**
```text
There is comfort in the everyday.
```

### Field: `intro`
- **PHP Key Path:** `sections[0]['data']['intro']`
- **OLD CONTENT:**
```text
Life at Mission Villa is shaped around what brings each resident comfort and joy—from the aroma of morning coffee and chef-prepared meals to gentle music, creative workshops, and peaceful courtyard garden walks.
```
- **NEW CONTENT:**
```text
A familiar meal. A favorite song. Time outdoors or a visit with family. We make space for the moments that help each day feel like their own.
```

### Field: `actions[0]['label']`
- **PHP Key Path:** `sections[0]['data']['actions'][0]['label']`
- **OLD CONTENT:**
```text
Experience Daily Life on Tour
```
- **NEW CONTENT:**
```text
Experience Mission Villa
```

### Field: `actions[1]['label']`
- **PHP Key Path:** `sections[0]['data']['actions'][1]['label']`
- **OLD CONTENT:**
```text
Request Life & Care Guide
```
- **NEW CONTENT:**
```text
Browse the Gallery
```
*(Note: Link target switches to `/gallery`).*

---

## Section 02: Lifestyle Pillars (`life-at-mission-villa.pillars`)
**Section Key:** `lmv-pillars`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[1]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Core Lifestyle Pillars
```
- **NEW CONTENT:**
```text
Living Here
```

### Field: `heading`
- **PHP Key Path:** `sections[1]['data']['heading']`
- **OLD CONTENT:**
```text
A Culture of <em>Nourishment, Sanctuary & Friendship.</em>
```
- **NEW CONTENT:**
```text
The little things matter.
```

### Pillar 1: Dining Together
#### Field: `pillars[0]['title']`
- **PHP Key Path:** `sections[1]['data']['pillars'][0]['title']`
- **OLD CONTENT:**
```text
Chef-Prepared Daily Meals
```
- **NEW CONTENT:**
```text
Dining Together
```

#### Field: `pillars[0]['summary']`
- **PHP Key Path:** `sections[1]['data']['pillars'][0]['summary']`
- **OLD CONTENT:**
```text
Our dining room is the social heart of the house. Residents gather three times daily for chef-crafted meals served with attentive table hospitality—turning mealtime into an unhurried celebration of flavor and connection.
```
- **NEW CONTENT:**
```text
Freshly prepared meals offer time to eat, relax, and enjoy company in the dining room.
```

### Pillar 2: Activities & Connection
#### Field: `pillars[1]['title']`
- **PHP Key Path:** `sections[1]['data']['pillars'][1]['title']`
- **OLD CONTENT:**
```text
Thoughtful Daily Engagement
```
- **NEW CONTENT:**
```text
Activities & Connection
```

#### Field: `pillars[1]['summary']`
- **PHP Key Path:** `sections[1]['data']['pillars'][1]['summary']`
- **OLD CONTENT:**
```text
Meaningful engagement sparks joy and self-expression. Guided by our activities team, residents take part in music therapy, creative art workshops, gentle exercise, and trivia that celebrate lifelong passions.
```
- **NEW CONTENT:**
```text
Music, art, gentle movement, and other activities give residents different ways to participate at their own pace.
```

### Pillar 3: Outdoor Moments
#### Field: `pillars[2]['title']`
- **PHP Key Path:** `sections[1]['data']['pillars'][2]['title']`
- **OLD CONTENT:**
```text
Sunlit Courtyard & Gardens
```
- **NEW CONTENT:**
```text
Outdoor Moments
```

#### Field: `pillars[2]['summary']`
- **PHP Key Path:** `sections[1]['data']['pillars'][2]['summary']`
- **OLD CONTENT:**
```text
Our secure central courtyard allows residents to step outside freely into fresh coastal air. Shaded umbrella seating, raised flower beds, and walking pathways provide a peaceful connection to nature.
```
- **NEW CONTENT:**
```text
The community courtyard and patio offer a change of scenery and space to spend time together.
```

---

## Section 03: Daily Rhythm (`life-at-mission-villa.rhythm`)
**Section Key:** `lmv-rhythm`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[2]['data']['eyebrow']`
- **OLD CONTENT:**
```text
A Day in the Life
```
- **NEW CONTENT:**
```text
A Familiar Rhythm
```

### Field: `heading`
- **PHP Key Path:** `sections[2]['data']['heading']`
- **OLD CONTENT:**
```text
A Reassuring Daily Rhythm, <em>Never Rushed.</em>
```
- **NEW CONTENT:**
```text
Each day has room to be different.
```

### Morning
#### Field: `moments[0]['body']`
- **PHP Key Path:** `sections[2]['data']['moments'][0]['body']`
- **OLD CONTENT:**
```text
Residents wake naturally without jarring bells. Caregivers provide respectful grooming and dressing support before escorting residents to a freshly prepared breakfast with warm coffee.
```
- **NEW CONTENT:**
```text
Breakfast and help with daily routines as needed.
```

### Midday / Afternoon
#### Field: `moments[1]['body']`
- **PHP Key Path:** `sections[2]['data']['moments'][1]['body']`
- **OLD CONTENT:**
```text
Morning chair fitness or music reminiscence transitions into a sociable, chef-prepared lunch. Full-table service and dietary modifications ensure enjoyable dining for all.
```
- **NEW CONTENT:**
```text
Activities, a shared meal, conversation, or some quiet time.
```

### Evening
#### Field: `moments[3]['body']`
- **PHP Key Path:** `sections[2]['data']['moments'][3]['body']`
- **OLD CONTENT:**
```text
An evening meal shared with friends is followed by soothing music, warm tea, and quiet bedtime rituals that minimize sundowning and promote restful sleep.
```
- **NEW CONTENT:**
```text
Dinner followed by a calm, familiar routine.
```

### Rhythm Disclaimer
#### Field: `disclaimer`
- **PHP Key Path:** `sections[2]['data']['disclaimer']`
- **OLD CONTENT:**
```text
Daily rhythms adapt flexibly to each individual resident’s preferences, stamina, and wakefulness patterns rather than adhering to rigid institutional timetables.
```
- **NEW CONTENT:**
```text
Each person's schedule and participation depend on preferences and care needs.
```

---

## Section 04: Engagement (`life-at-mission-villa.engagement`)
**Section Key:** `lmv-engagement`
**Status:** RETIRED / REMOVED IN V2

### Editorial Action:
- Retired per `CONTENT_MAP.md`: "lmv-engagement moved to future activity/blog content".
- **Recommended PHP Action:** Set `'enabled' => false`.

### Field: `heading` (Retired Section)
- **PHP Key Path:** `sections[3]['data']['heading']`
- **OLD CONTENT:**
```text
Enrichment That Honors <em>Every Life Story.</em>
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

### Field: `intro` (Retired Section)
- **PHP Key Path:** `sections[3]['data']['intro']`
- **OLD CONTENT:**
```text
Our activities director curates varied opportunities for residents to express creativity, celebrate heritage, and stay physically energized.
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

---

## Section 05: FAQs (`life-at-mission-villa.faq`)
**Section Key:** `lmv-faq`
**Status:** MODIFIED (Condensed from 6 FAQs to 3 core questions)

### FAQ 1: Reluctant / Quiet Participation
#### Field: `faqs[2]['question']`
- **PHP Key Path:** `sections[4]['data']['faqs'][2]['question']`
- **OLD CONTENT:**
```text
What if my loved one is quiet or reluctant to participate in group activities?
```
- **NEW CONTENT:**
```text
Do residents have to join group activities?
```

#### Field: `faqs[2]['answer']`
- **PHP Key Path:** `sections[4]['data']['faqs'][2]['answer']`
- **OLD CONTENT:**
```text
Participation is always an invitation, never an obligation. Our care team introduces residents to gentle one-on-one activities, quiet reading time in the lounge, or simple garden walks until they feel naturally comfortable joining small groups.
```
- **NEW CONTENT:**
```text
Activities are offered with each person's interests and comfort in mind. Quiet time is also part of daily life.
```

### FAQ 2: Family Visits
#### Field: `faqs[3]['question']`
- **PHP Key Path:** `sections[4]['data']['faqs'][3]['question']`
- **OLD CONTENT:**
```text
What are the community visiting hours for families?
```
- **NEW CONTENT:**
```text
Can families visit?
```

#### Field: `faqs[3]['answer']`
- **PHP Key Path:** `sections[4]['data']['faqs'][3]['answer']`
- **OLD CONTENT:**
```text
Mission Villa welcomes family visits 7 days a week. We consider families essential partners in their loved one’s care and happiness, and there are comfortable indoor lounges and garden seating for peaceful visits.
```
- **NEW CONTENT:**
```text
Family connection is encouraged. Contact the team to confirm current visiting arrangements and meal participation.
```

### FAQ 3: Activity Calendar
#### Field: `faqs[0]['question']`
- **PHP Key Path:** `sections[4]['data']['faqs'][0]['question']`
- **OLD CONTENT:**
```text
Can family members join residents for meals or celebrate special occasions?
```
- **NEW CONTENT:**
```text
Can we see an activity calendar?
```

#### Field: `faqs[0]['answer']`
- **PHP Key Path:** `sections[4]['data']['faqs'][0]['answer']`
- **OLD CONTENT:**
```text
Yes, absolutely! Families are always welcome to join loved ones for meals in our dining room, or reserve our private family dining room to celebrate birthdays, anniversaries, and holidays together with a customized chef-prepared meal.
```
- **NEW CONTENT:**
```text
Ask our team for the current calendar during your visit.
```

*(Note: Surplus FAQs in PHP `faqs[1]`, `faqs[4]`, `faqs[5]` are disabled in Editorial V2).*

---

## Section 06: Closing CTA (`visit.cta`)
**Section Key:** `lmv-cta`
**Status:** MODIFIED

### Field: `heading`
- **PHP Key Path:** `sections[5]['data']['heading']`
- **OLD CONTENT:**
```text
Join Us for Lunch or a Community Tour
```
- **NEW CONTENT:**
```text
Come experience a day at Mission Villa.
```

### Field: `body`
- **PHP Key Path:** `sections[5]['data']['body']`
- **OLD CONTENT:**
```text
See our vibrant dining room, meet our engaging life enrichment team, and experience the warm fellowship of Mission Villa in Daly City.
```
- **NEW CONTENT:**
```text
See the dining room and shared spaces, and ask about activities and daily routines.
```

### Action Configuration:
- Schedule a Visit (`schedule_visit` modal, care: `exploring`)
- Request a Call (`request_callback` modal)
- Phone: `(650) 756-1995`
