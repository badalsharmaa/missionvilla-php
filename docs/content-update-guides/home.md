# Content Update Guide: Home Page (`home`)

**Route:** `/`
**PHP Source File:** `content/pages/home.php`
**Current Content Spec:** `docs/pages/home.md`
**Editorial V2 Source:** `docs/Mission_Villa_Website_Content_Editorial_V2/pages/home.md`

---

## Executive Summary of Changes
- **Total Sections in PHP:** 8 (`intro`, `hero`, `care-options`, `life-gallery`, `why-families`, `suites`, `faq`, `visit`)
- **Sections Modified:** 8 (All sections retained; text heavily streamlined for brevity and clarity)
- **Sections Unchanged:** None completely unchanged; structure retained
- **Sections Retired / Removed:** None; all 8 sections remain active
- **Key Editorial Directions:**
  - Concise headlines and descriptions across all 3 hero slides.
  - Care cards trimmed to 2 concise flip details each.
  - Why Families condensed into 3 core highlights.
  - Featured FAQs reduced from 4 lengthy answers to 3 direct answers.
  - All form CTAs consistently routed to shared modal rather than inline forms.

---

## SEO & Page Metadata

### Field: `seo['title']`
- **PHP Key Path:** `seo['title']`
- **OLD CONTENT:**
```text
Mission Villa Senior Living — Memory Care & Respite Care in Daly City, CA
```
- **NEW CONTENT:**
```text
Mission Villa Senior Living | Memory Care & Respite Care in Daly City
```

### Field: `seo['description']`
- **PHP Key Path:** `seo['description']`
- **OLD CONTENT:**
```text
Legacies™ Memory Care and Short-Term Respite Care in an unhurried, residential community at 995 East Market Street, Daly City, CA. Call (650) 756-1995 to schedule a visit.
```
- **NEW CONTENT:**
```text
Explore Legacies™ Memory Care and short-term Respite Care at Mission Villa Senior Living in Daly City. Learn about our community or schedule a visit.
```

### Unchanged Metadata Fields:
- `og_image`: `/images/hero/family-connection-1200.webp` (Retained; verify illustrative label)

---

## Section 00: Opening Shutters (`intro.shutters`)
**Section Key:** `intro`
**Status:** MODIFIED

### Field: `left_tagline`
- **PHP Key Path:** `sections[0]['data']['left_tagline']`
- **OLD CONTENT:**
```text
“The honor they deserve,”
```
- **NEW CONTENT:**
```text
Care that feels personal.
```

### Field: `right_tagline`
- **PHP Key Path:** `sections[0]['data']['right_tagline']`
- **OLD CONTENT:**
```text
“the care you’ll love.”
```
- **NEW CONTENT:**
```text
Memory Care & Respite Care
```

### Retained / Unchanged Fields in `intro`:
- `left_kicker`: `'Mission Villa'`
- `right_top`: `'Daly City, California'`
- `skip_label`: `'Skip Intro'`
- `left_script`: `'A Place to Belong'`
- `left_footer`: `'Dignity · Connection · Purpose'`
- `right_kicker`: `'Senior Living'`
- `right_footer`: `'Memory Care · Respite Care'`

---

## Section 01: Hero (`hero.cinematic`)
**Section Key:** `hero`
**Status:** MODIFIED

### Slide 1: Welcome to Mission Villa
#### Field: `slides[0]['eyebrow']`
- **PHP Key Path:** `sections[1]['data']['slides'][0]['eyebrow']`
- **OLD CONTENT:**
```text
Chapter 01 · Welcome to Mission Villa
```
- **NEW CONTENT:**
```text
Welcome to Mission Villa
```

#### Field: `slides[0]['line1']`
- **PHP Key Path:** `sections[1]['data']['slides'][0]['line1']`
- **OLD CONTENT:**
```text
A calm, trusted home
```
- **NEW CONTENT:**
```text
A place to feel at home.
```

#### Field: `slides[0]['line2']`
- **PHP Key Path:** `sections[1]['data']['slides'][0]['line2']`
- **OLD CONTENT:**
```text
where <em>your loved one</em>
```
- **NEW CONTENT:**
```text

```
*(Note: Editorial V2 provides a single heading "A place to feel at home." Set `line2` and `line3` to empty string or adjust headline splitting if desired).*

#### Field: `slides[0]['line3']`
- **PHP Key Path:** `sections[1]['data']['slides'][0]['line3']`
- **OLD CONTENT:**
```text
is genuinely known.
```
- **NEW CONTENT:**
```text

```

#### Field: `slides[0]['body']`
- **PHP Key Path:** `sections[1]['data']['slides'][0]['body']`
- **OLD CONTENT:**
```text
At Mission Villa Senior Living in Daly City, specialized <strong>Legacies™ Memory Care</strong> and flexible <strong>Short-Term Respite Care</strong> come together in an unhurried, residential community—supporting your family with warmth, clarity, and respect.
```
- **NEW CONTENT:**
```text
Personal attention, familiar routines, and a welcoming community in Daly City. We're here for older adults and the families who care for them.
```

---

### Slide 2: Memory Care
#### Field: `slides[1]['eyebrow']`
- **PHP Key Path:** `sections[1]['data']['slides'][1]['eyebrow']`
- **OLD CONTENT:**
```text
Chapter 02 · Legacies™ Memory Care
```
- **NEW CONTENT:**
```text
Legacies™ Memory Care
```

#### Field: `slides[1]['line1']`
- **PHP Key Path:** `sections[1]['data']['slides'][1]['line1']`
- **OLD CONTENT:**
```text
When memory changes,
```
- **NEW CONTENT:**
```text
Care that begins with knowing the person.
```

#### Field: `slides[1]['line2']`
- **PHP Key Path:** `sections[1]['data']['slides'][1]['line2']`
- **OLD CONTENT:**
```text
<em>dignity and rhythm</em>
```
- **NEW CONTENT:**
```text

```

#### Field: `slides[1]['line3']`
- **PHP Key Path:** `sections[1]['data']['slides'][1]['line3']`
- **OLD CONTENT:**
```text
remain at the center.
```
- **NEW CONTENT:**
```text

```

#### Field: `slides[1]['body']`
- **PHP Key Path:** `sections[1]['data']['slides'][1]['body']`
- **OLD CONTENT:**
```text
Our <strong>Legacies™ Memory Care</strong> neighborhood honors your loved one’s personal history, familiar daily routines, and meaningful human connection—creating calm, reassuring days in the heart of Daly City.
```
- **NEW CONTENT:**
```text
Support for people living with Alzheimer's disease or other forms of dementia, shaped around their stories, preferences, and daily routines.
```

#### Field: `slides[1]['cta']`
- **PHP Key Path:** `sections[1]['data']['slides'][1]['cta']`
- **OLD CONTENT:**
```text
Schedule a Memory Care Visit
```
- **NEW CONTENT:**
```text
Explore Memory Care
```

---

### Slide 3: Respite Care
#### Field: `slides[2]['eyebrow']`
- **PHP Key Path:** `sections[1]['data']['slides'][2]['eyebrow']`
- **OLD CONTENT:**
```text
Chapter 03 · Short-Term Respite Care
```
- **NEW CONTENT:**
```text
Short-Term Respite Care
```

#### Field: `slides[2]['line1']`
- **PHP Key Path:** `sections[1]['data']['slides'][2]['line1']`
- **OLD CONTENT:**
```text
Trusted short-term care,
```
- **NEW CONTENT:**
```text
A little support can make a big difference.
```

#### Field: `slides[2]['line2']`
- **PHP Key Path:** `sections[1]['data']['slides'][2]['line2']`
- **OLD CONTENT:**
```text
<em>peace of mind</em> for
```
- **NEW CONTENT:**
```text

```

#### Field: `slides[2]['line3']`
- **PHP Key Path:** `sections[1]['data']['slides'][2]['line3']`
- **OLD CONTENT:**
```text
family caregivers.
```
- **NEW CONTENT:**
```text

```

#### Field: `slides[2]['body']`
- **PHP Key Path:** `sections[1]['data']['slides'][2]['body']`
- **OLD CONTENT:**
```text
Whether you need time to rest, travel, or recover, <strong>Short-Term Respite Care</strong> at Mission Villa welcomes your loved one into a warm, attentive residential community at 995 East Market Street.
```
- **NEW CONTENT:**
```text
A short stay for your loved one while you rest, travel, or take care of life's demands.
```

#### Field: `slides[2]['cta']`
- **PHP Key Path:** `sections[1]['data']['slides'][2]['cta']`
- **OLD CONTENT:**
```text
Inquire About Respite Stays
```
- **NEW CONTENT:**
```text
Ask About Respite Stays
```

---

### Care Guide Preview
#### Field: `care_guide['title']`
- **PHP Key Path:** `sections[1]['data']['care_guide']['title']`
- **OLD CONTENT:**
```text
How can we help your family today?
```
- **NEW CONTENT:**
```text
Not sure where to begin?
```

#### Field: `care_guide['description']`
- **PHP Key Path:** `sections[1]['data']['care_guide']['description']`
- **OLD CONTENT:**
```text
Explore care options, ask a question, or arrange a visit. Start wherever feels comfortable.
```
- **NEW CONTENT:**
```text
Learn about our two care options or ask the team a question.
```

---

## Section 02: Care Options (`care.options`)
**Section Key:** `care-options`
**Status:** MODIFIED

### Field: `heading`
- **PHP Key Path:** `sections[2]['data']['heading']`
- **OLD CONTENT:**
```text
Two Paths. <em>One Commitment to Care.</em>
```
- **NEW CONTENT:**
```text
The right care for this stage of life.
```

### Card 1: Memory Care
#### Field: `cards[0]['summary']`
- **PHP Key Path:** `sections[2]['data']['cards'][0]['summary']`
- **OLD CONTENT:**
```text
Specialized, personalized support for seniors living with Alzheimer’s disease and other forms of dementia.
```
- **NEW CONTENT:**
```text
Ongoing support for people living with memory loss, with attention to familiar routines and personal connections.
```

#### Field: `cards[0]['cta']['label']`
- **PHP Key Path:** `sections[2]['data']['cards'][0]['cta']['label']`
- **OLD CONTENT:**
```text
Explore Memory Care
```
- **NEW CONTENT:**
```text
Learn About Memory Care
```

#### Field: `cards[0]['back']['benefits'][0]['text']`
- **PHP Key Path:** `sections[2]['data']['cards'][0]['back']['benefits'][0]['text']`
- **OLD CONTENT:**
```text
Care built around each life story and routine
```
- **NEW CONTENT:**
```text
Life-story-led care
```

#### Field: `cards[0]['back']['benefits'][1]['text']`
- **PHP Key Path:** `sections[2]['data']['cards'][0]['back']['benefits'][1]['text']`
- **OLD CONTENT:**
```text
Calm, predictable rhythms that feel familiar
```
- **NEW CONTENT:**
```text
Supportive daily routines
```

*(Note: Card 1 flip details reduced to maximum 2 items in Editorial V2. Third benefit `Compassionate support that preserves dignity` can be removed or disabled).*

### Card 2: Respite Care
#### Field: `cards[1]['summary']`
- **PHP Key Path:** `sections[2]['data']['cards'][1]['summary']`
- **OLD CONTENT:**
```text
A welcoming short-term stay that provides caring support and gives family caregivers peace of mind.
```
- **NEW CONTENT:**
```text
A comfortable, temporary stay that supports your loved one and gives family caregivers time away.
```

#### Field: `cards[1]['cta']['label']`
- **PHP Key Path:** `sections[2]['data']['cards'][1]['cta']['label']`
- **OLD CONTENT:**
```text
Explore Respite Care
```
- **NEW CONTENT:**
```text
Learn About Respite Care
```

#### Field: `cards[1]['back']['benefits'][0]['text']`
- **PHP Key Path:** `sections[2]['data']['cards'][1]['back']['benefits'][0]['text']`
- **OLD CONTENT:**
```text
A comfortable suite with a private bathroom
```
- **NEW CONTENT:**
```text
Daily assistance
```

#### Field: `cards[1]['back']['benefits'][1]['text']`
- **PHP Key Path:** `sections[2]['data']['cards'][1]['back']['benefits'][1]['text']`
- **OLD CONTENT:**
```text
Chef-prepared meals and daily activities
```
- **NEW CONTENT:**
```text
Dining and activities
```

*(Note: Card 2 flip details reduced to maximum 2 items in Editorial V2. Third benefit `Personal attention from our care team` can be removed or disabled).*

---

## Section 03: Life at Mission Villa (`life.gallery`)
**Section Key:** `life-gallery`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[3]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Life at Mission Villa
```
- **NEW CONTENT:**
```text
Everyday Life
```

### Field: `heading`
- **PHP Key Path:** `sections[3]['data']['heading']`
- **OLD CONTENT:**
```text
A Closer Look at <em>Life Here</em>
```
- **NEW CONTENT:**
```text
A closer look at Mission Villa.
```

### Field: `subheading`
- **PHP Key Path:** `sections[3]['data']['subheading']`
- **OLD CONTENT:**
```text
A welcoming community designed for comfort, engagement, and meaningful connection.
```
- **NEW CONTENT:**
```text
Comfortable spaces, shared meals, and time for connection.
```

### Tab 1: Living Spaces
#### Field: `chapters[0]['description']`
- **PHP Key Path:** `sections[3]['data']['chapters'][0]['description']`
- **OLD CONTENT:**
```text
Private and shared suites, each with a private bathroom, plus inviting lounges where residents relax and families visit.
```
- **NEW CONTENT:**
```text
A room to make your own.
```

### Tab 2: Dining & Daily Life
#### Field: `chapters[1]['description']`
- **PHP Key Path:** `sections[3]['data']['chapters'][1]['description']`
- **OLD CONTENT:**
```text
Chef-prepared meals shared in a welcoming dining room, with group and one-on-one activities woven through each day.
```
- **NEW CONTENT:**
```text
Familiar meals and a welcoming table.
```

### Tab 3: Connection
#### Field: `chapters[2]['label']`
- **PHP Key Path:** `sections[3]['data']['chapters'][2]['label']`
- **OLD CONTENT:**
```text
Meaningful Connection
```
- **NEW CONTENT:**
```text
Connection
```

#### Field: `chapters[2]['description']`
- **PHP Key Path:** `sections[3]['data']['chapters'][2]['description']`
- **OLD CONTENT:**
```text
Care shaped around each resident’s life story, with music, reminiscence, and comfortable spaces for family visits.
```
- **NEW CONTENT:**
```text
Music, activities, and quiet moments together.
```

#### Field: `chapters[2]['cta']['label']`
- **PHP Key Path:** `sections[3]['data']['chapters'][2]['cta']['label']`
- **OLD CONTENT:**
```text
Explore Memory Care
```
- **NEW CONTENT:**
```text
See Daily Life
```

---

## Section 04: Why Mission Villa (`trust.why-families`)
**Section Key:** `why-families`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[4]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Why Families Choose Mission Villa
```
- **NEW CONTENT:**
```text
Our Approach
```

### Field: `heading`
- **PHP Key Path:** `sections[4]['data']['heading']`
- **OLD CONTENT:**
```text
A Trusted Partner in Your Family’s <em>Next Chapter</em>
```
- **NEW CONTENT:**
```text
Small details. Personal care.
```

### Field: `body`
- **PHP Key Path:** `sections[4]['data']['body']`
- **OLD CONTENT:**
```text
At Mission Villa, we believe meaningful care begins with understanding each individual. Our Daly City community offers a welcoming setting where personal histories, familiar routines, and family connections are valued.
```
- **NEW CONTENT:**
```text
We learn what matters to each resident—from everyday preferences to the people and memories they hold close.
```

### Field: `primary_cta['label']`
- **PHP Key Path:** `sections[4]['data']['primary_cta']['label']`
- **OLD CONTENT:**
```text
Schedule a Visit
```
- **NEW CONTENT:**
```text
About Mission Villa
```
*(Note: Editorial V2 links this CTA to `/about`).*

### Highlights Refactor Note:
- Editorial V2 condenses the previous 4 glance facts and 4 values into three core highlights:
  1. `Familiar routines`
  2. `Family involvement`
  3. `A welcoming residential setting`

---

## Section 05: Suites (`living.suites`)
**Section Key:** `suites`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[5]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Suites & Living Spaces
```
- **NEW CONTENT:**
```text
Suites & Shared Spaces
```

### Field: `heading`
- **PHP Key Path:** `sections[5]['data']['heading']`
- **OLD CONTENT:**
```text
Comfortable Suites & <em>Welcoming Spaces</em>
```
- **NEW CONTENT:**
```text
Room to feel comfortable.
```

### Field: `intro`
- **PHP Key Path:** `sections[5]['data']['intro']`
- **OLD CONTENT:**
```text
Thoughtfully designed accommodations and inviting communal spaces create a sense of comfort, familiarity, and belonging at Mission Villa.
```
- **NEW CONTENT:**
```text
Explore private, companion, and Jack & Jill suite formats. Availability and room arrangements can be discussed during a visit.
```

### Field: `options[1]['label']`
- **PHP Key Path:** `sections[5]['data']['options'][1]['label']`
- **OLD CONTENT:**
```text
Shared Suites
```
- **NEW CONTENT:**
```text
Companion Suites
```

### Field: `actions[0]['label']`
- **PHP Key Path:** `sections[5]['data']['actions'][0]['label']`
- **OLD CONTENT:**
```text
View Suite & Floor Plans
```
- **NEW CONTENT:**
```text
Explore Suites
```

---

## Section 06: Featured FAQs (`faq.featured`)
**Section Key:** `faq`
**Status:** MODIFIED (Condensed from 4 FAQs to 3 direct FAQs)

### Field: `heading`
- **PHP Key Path:** `sections[6]['data']['heading']`
- **OLD CONTENT:**
```text
Questions Families Often Ask
```
- **NEW CONTENT:**
```text
A few common questions.
```

### FAQ 1
#### Field: `entries[0]['question']`
- **PHP Key Path:** `sections[6]['data']['entries'][0]['question']`
- **OLD CONTENT:**
```text
What is included in the Legacies™ Memory Care program?
```
- **NEW CONTENT:**
```text
What care does Mission Villa provide?
```

#### Field: `entries[0]['answer']`
- **PHP Key Path:** `sections[6]['data']['entries'][0]['answer']`
- **OLD CONTENT:**
```text
Our Legacies™ Memory Care program focuses on honoring each resident’s life story, personal preferences, and sense of dignity. By learning about each resident’s background, family connections, and comforting routines, our team provides compassionate daily support tailored to the individual.
```
- **NEW CONTENT:**
```text
Legacies™ Memory Care and short-term Respite Care.
```

### FAQ 2
#### Field: `entries[1]['question']`
- **PHP Key Path:** `sections[6]['data']['entries'][1]['question']`
- **OLD CONTENT:**
```text
Can we arrange a short-term Respite Care stay?
```
- **NEW CONTENT:**
```text
Can we tour the community?
```

#### Field: `entries[1]['answer']`
- **PHP Key Path:** `sections[6]['data']['entries'][1]['answer']`
- **OLD CONTENT:**
```text
Yes. Short-Term Respite Care offers a supportive stay when a family caregiver needs time to rest, travel, or manage personal obligations, with attentive care, a comfortable suite, chef-prepared dining, and daily activities. Call (650) 756-1995 to talk through your dates and current availability.
```
- **NEW CONTENT:**
```text
Yes. Call (650) 756-1995 or request a visit to discuss a convenient time.
```

### FAQ 3
#### Field: `entries[3]['question']`
- **PHP Key Path:** `sections[6]['data']['entries'][3]['question']`
- **OLD CONTENT:**
```text
How can we learn about pricing and schedule a visit?
```
- **NEW CONTENT:**
```text
How do we find out about pricing?
```

#### Field: `entries[3]['answer']`
- **PHP Key Path:** `sections[6]['data']['entries'][3]['answer']`
- **OLD CONTENT:**
```text
Pricing depends on your loved one’s daily support needs and the suite you choose, so our team discusses it with you personally rather than publishing set rates. Call (650) 756-1995 or send a request below, and ask to arrange a visit at the same time.
```
- **NEW CONTENT:**
```text
Speak with the team about care needs, suite options, and current rates.
```

*(Note: Surplus FAQ entry `entries[2]` ('What suite options are available?') is pruned or disabled as Editorial V2 specifies exactly 3 FAQs).*

---

## Section 07: Visit CTA (`visit.cta`)
**Section Key:** `visit`
**Status:** MODIFIED

### Field: `heading`
- **PHP Key Path:** `sections[7]['data']['heading']`
- **OLD CONTENT:**
```text
Come See Mission Villa for Yourself
```
- **NEW CONTENT:**
```text
Come see Mission Villa for yourself.
```

### Field: `body`
- **PHP Key Path:** `sections[7]['data']['body']`
- **OLD CONTENT:**
```text
We welcome you to visit our Daly City community, meet our care team, and see firsthand the warm, supportive environment we’ve created for residents and their families.
```
- **NEW CONTENT:**
```text
Tour the community, meet the team, and ask what matters to your family.
```

### Modal Intents & Actions:
- Primary CTA: `Schedule a Visit` (`schedule_visit` modal, care: `exploring`)
- Secondary CTA: `Request Pricing` (`request_pricing` modal, care: `exploring`)
- Tertiary CTA: `Request a Call` (`request_callback` modal)
- Contact Phone: `(650) 756-1995`
- Developer Note: Retain shared modal bindings; all form-intent CTAs must trigger the modal.
