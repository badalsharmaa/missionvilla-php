# Content Update Guide: Respite Care Page (`respite-care`)

**Route:** `/respite-care`
**PHP Source File:** `content/pages/respite-care.php`
**Current Content Spec:** `docs/pages/respite-care.md`
**Editorial V2 Source:** `docs/Mission_Villa_Website_Content_Editorial_V2/pages/respite-care.md`

---

## Executive Summary of Changes
- **Total Sections in PHP:** 8 (`rc-hero`, `rc-scenarios`, `rc-inclusions`, `rc-story`, `rc-caregiver`, `rc-timeline`, `rc-faq`, `rc-cta`)
- **Sections Modified:** 6 (`rc-hero`, `rc-scenarios`, `rc-inclusions`, `rc-timeline`, `rc-faq`, `rc-cta`)
- **Sections Retired / Merged:** 2 (`rc-story` and `rc-caregiver` merged into `rc-scenarios` and `rc-timeline`; recommend `'enabled' => false` for both)
- **Key Editorial Directions:**
  - Honest, supportive tone emphasizing caregiver renewal and safe respite.
  - Clinical clarification: explicit note that respite care is not skilled nursing or medical rehabilitation.
  - Three distinct stay scenarios (Caregiver break, Travel/commitments, Exploring community).
  - Planning timeline condensed from 5 steps to 3 clear phases.
  - FAQs pruned from 5 to 3 focused answers.

---

## SEO & Page Metadata

### Field: `title`
- **PHP Key Path:** `title`
- **OLD CONTENT:**
```text
Short-Term Respite Care | Mission Villa Senior Living
```
- **NEW CONTENT:**
```text
Short-Term Respite Care in Daly City | Mission Villa
```

### Field: `seo['title']`
- **PHP Key Path:** `seo['title']`
- **OLD CONTENT:**
```text
Short-Term Respite Care in Daly City | Mission Villa Senior Living
```
- **NEW CONTENT:**
```text
Short-Term Respite Care in Daly City | Mission Villa
```

### Field: `seo['description']`
- **PHP Key Path:** `seo['description']`
- **OLD CONTENT:**
```text
Flexible short-term respite care stays in Daly City. Welcoming accommodations, 24/7 personalized care, chef-prepared meals, and peace of mind for family caregivers.
```
- **NEW CONTENT:**
```text
Explore short-term Respite Care at Mission Villa Senior Living in Daly City. Learn about stays, daily support, and how to ask about availability.
```

---

## Section 01: Hero (`respite-care.hero`)
**Section Key:** `rc-hero`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[0]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Short-Term Stays at Mission Villa
```
- **NEW CONTENT:**
```text
Short-Term Respite Care
```

### Field: `heading`
- **PHP Key Path:** `sections[0]['data']['heading']`
- **OLD CONTENT:**
```text
Short-Term Respite Care
```
- **NEW CONTENT:**
```text
Caring support, for the time you need.
```

### Field: `intro`
- **PHP Key Path:** `sections[0]['data']['intro']`
- **OLD CONTENT:**
```text
Temporary stays that provide compassionate care, a comfortable place to stay, and supportive daily routines—while caregivers rest, travel, or navigate recovery.
```
- **NEW CONTENT:**
```text
Looking after someone you love is important work. A short stay at Mission Villa can give family caregivers time to rest, travel, or manage other responsibilities while their loved one receives daily support.
```

### Field: `actions[0]['label']`
- **PHP Key Path:** `sections[0]['data']['actions'][0]['label']`
- **OLD CONTENT:**
```text
Inquire About Respite Availability
```
- **NEW CONTENT:**
```text
Ask About Availability
```

### Field: `actions[1]['label']`
- **PHP Key Path:** `sections[0]['data']['actions'][1]['label']`
- **OLD CONTENT:**
```text
See How a Short-Term Stay Works
```
- **NEW CONTENT:**
```text
How Respite Works
```

---

## Section 02: Scenarios (`respite-care.scenarios`)
**Section Key:** `rc-scenarios`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[1]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Why Families Choose Respite Care
```
- **NEW CONTENT:**
```text
Is Respite Right for Us?
```

### Field: `heading`
- **PHP Key Path:** `sections[1]['data']['heading']`
- **OLD CONTENT:**
```text
Support When You Need It <em>Most.</em>
```
- **NEW CONTENT:**
```text
A short stay can help in different ways.
```

### Scenario 1: A break for caregivers
#### Field: `scenarios[0]['title']`
- **PHP Key Path:** `sections[1]['data']['scenarios'][0]['title']`
- **OLD CONTENT:**
```text
Caregiver Rest & Renewal
```
- **NEW CONTENT:**
```text
A break for caregivers
```

#### Field: `scenarios[0]['subtitle']`
- **PHP Key Path:** `sections[1]['data']['scenarios'][0]['subtitle']`
- **OLD CONTENT:**
```text
A trusted place to stay while you take time for yourself.
```
- **NEW CONTENT:**
```text
Time to recharge while a loved one stays in a supportive community.
```

### Scenario 2: Travel or Commitments
#### Field: `scenarios[1]['subtitle']`
- **PHP Key Path:** `sections[1]['data']['scenarios'][1]['subtitle']`
- **OLD CONTENT:**
```text
When work, travel, or family milestones call you away.
```
- **NEW CONTENT:**
```text
Care while you're away for work, travel, or personal responsibilities.
```

### Scenario 3: Exploring Community Life
#### Field: `scenarios[3]['title']`
- **PHP Key Path:** `sections[1]['data']['scenarios'][3]['title']`
- **OLD CONTENT:**
```text
Gentle Introduction to Community Life
```
- **NEW CONTENT:**
```text
Exploring community life
```

#### Field: `scenarios[3]['subtitle']`
- **PHP Key Path:** `sections[1]['data']['scenarios'][3]['subtitle']`
- **OLD CONTENT:**
```text
Experience Mission Villa firsthand before making longer-term plans.
```
- **NEW CONTENT:**
```text
An opportunity to experience Mission Villa before considering a longer-term move.
```

*(Note: In PHP `scenarios`, `scenarios[2]` ('Recovery & Transitional Support') is replaced/annotated with the mandatory clinical caveat note: "If your loved one is leaving a hospital or rehabilitation setting, ask the team about admission requirements and whether their needs can be safely supported. Respite Care is not a substitute for skilled nursing or medical rehabilitation.")*

---

## Section 03: What's Included (`respite-care.inclusions`)
**Section Key:** `rc-inclusions`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[2]['data']['eyebrow']`
- **OLD CONTENT:**
```text
What’s Included in a Stay
```
- **NEW CONTENT:**
```text
During a Stay
```

### Field: `heading`
- **PHP Key Path:** `sections[2]['data']['heading']`
- **OLD CONTENT:**
```text
Comfort, Care & <em>Everyday Support.</em>
```
- **NEW CONTENT:**
```text
Familiar comforts and daily support.
```

### Field: `note`
- **PHP Key Path:** `sections[2]['data']['note']`
- **OLD CONTENT:**
```text
Availability and specific inclusions are confirmed with our team for each stay.
```
- **NEW CONTENT:**
```text
The team will review care needs, dates, and specific inclusions before confirming a stay.
```

---

## Section 04: Story (`respite-care.story`)
**Section Key:** `rc-story`
**Status:** RETIRED / MERGED IN V2

### Editorial Action:
- Retired per `CONTENT_MAP.md` (content merged into `rc-scenarios` and `rc-timeline`).
- **Recommended PHP Action:** Set `'enabled' => false`.

### Field: `heading` (Retired Section)
- **PHP Key Path:** `sections[3]['data']['heading']`
- **OLD CONTENT:**
```text
A Welcoming Stay, <em>From Start to Finish.</em>
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

---

## Section 05: Caregiver Support (`respite-care.caregiver`)
**Section Key:** `rc-caregiver`
**Status:** RETIRED / MERGED IN V2

### Editorial Action:
- Retired per `CONTENT_MAP.md` (content merged into `rc-scenarios` and `rc-timeline`).
- **Recommended PHP Action:** Set `'enabled' => false`.

### Field: `heading` (Retired Section)
- **PHP Key Path:** `sections[4]['data']['heading']`
- **OLD CONTENT:**
```text
Caring for the Caregiver.
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

---

## Section 06: Planning Timeline (`respite-care.timeline`)
**Section Key:** `rc-timeline`
**Status:** MODIFIED (Condensed from 5 steps to 3 simple phases)

### Field: `eyebrow`
- **PHP Key Path:** `sections[5]['data']['eyebrow']`
- **OLD CONTENT:**
```text
A Simple, Supportive Process
```
- **NEW CONTENT:**
```text
Getting Started
```

### Field: `heading`
- **PHP Key Path:** `sections[5]['data']['heading']`
- **OLD CONTENT:**
```text
A Simple Stay-Planning <em>Timeline.</em>
```
- **NEW CONTENT:**
```text
Three simple steps.
```

### Step 1: Let's Talk
#### Field: `steps[0]['title']`
- **PHP Key Path:** `sections[5]['data']['steps'][0]['title']`
- **OLD CONTENT:**
```text
Reach Out
```
- **NEW CONTENT:**
```text
Let's talk
```

#### Field: `steps[0]['summary']`
- **PHP Key Path:** `sections[5]['data']['steps'][0]['summary']`
- **OLD CONTENT:**
```text
Contact our team to talk about your needs and ask questions.
```
- **NEW CONTENT:**
```text
Tell us about the dates you're considering and the support your loved one needs.
```

### Step 2: Care Review
#### Field: `steps[1]['summary']`
- **PHP Key Path:** `sections[5]['data']['steps'][1]['summary']`
- **OLD CONTENT:**
```text
We’ll learn about your loved one’s preferences, routines, and any care needs.
```
- **NEW CONTENT:**
```text
Our team discusses suitability, accommodations, and current availability.
```

### Step 3: Plan the Stay
#### Field: `steps[3]['title']`
- **PHP Key Path:** `sections[5]['data']['steps'][3]['title']`
- **OLD CONTENT:**
```text
Prepare for Arrival
```
- **NEW CONTENT:**
```text
Plan the stay
```

#### Field: `steps[3]['summary']`
- **PHP Key Path:** `sections[5]['data']['steps'][3]['summary']`
- **OLD CONTENT:**
```text
We’ll share what to bring and help you get ready for a smooth stay.
```
- **NEW CONTENT:**
```text
If appropriate and available, we'll explain the next steps and what to bring.
```

*(Note: In PHP `steps`, steps 2 (`Choose Dates`) and 4 (`Welcome to Mission Villa`) are merged into the 3 streamlined steps above).*

---

## Section 07: FAQs (`respite-care.faq`)
**Section Key:** `rc-faq`
**Status:** MODIFIED (Condensed from 5 FAQs to 3 core questions)

### FAQ 1: Duration
#### Field: `faqs[0]['question']`
- **PHP Key Path:** `sections[6]['data']['faqs'][0]['question']`
- **OLD CONTENT:**
```text
How long can a respite stay be?
```
- **NEW CONTENT:**
```text
How long can someone stay?
```

#### Field: `faqs[0]['answer']`
- **PHP Key Path:** `sections[6]['data']['faqs'][0]['answer']`
- **OLD CONTENT:**
```text
Respite Care at Mission Villa is designed for flexible short-term stays—often ranging from a few days to several weeks depending on your family’s needs and current suite availability. Contact our Daly City team at (650) 756-1995 to check current openings for your desired dates.
```
- **NEW CONTENT:**
```text
Stay lengths and minimum requirements depend on availability and current community policies. Ask our team about your dates.
```

### FAQ 2: Memory Loss
#### Field: `faqs[2]['question']`
- **PHP Key Path:** `sections[6]['data']['faqs'][2]['question']`
- **OLD CONTENT:**
```text
Can you support someone with memory loss during a respite stay?
```
- **NEW CONTENT:**
```text
Can someone with memory loss use Respite Care?
```

#### Field: `faqs[2]['answer']`
- **PHP Key Path:** `sections[6]['data']['faqs'][2]['answer']`
- **OLD CONTENT:**
```text
Yes. Because Mission Villa specializes in compassionate Memory Care through our Legacies™ program, our staff and homelike setting are well suited to welcoming short-term guests living with memory loss—provided our pre-stay care review confirms we can safely meet their individual needs.
```
- **NEW CONTENT:**
```text
The team can discuss this with you and assess whether Mission Villa can meet the person's needs during a short stay.
```

### FAQ 3: Pricing
#### Field: `faqs[4]['question']`
- **PHP Key Path:** `sections[6]['data']['faqs'][4]['question']`
- **OLD CONTENT:**
```text
How do I check availability and get started?
```
- **NEW CONTENT:**
```text
How do I get a quote?
```

#### Field: `faqs[4]['answer']`
- **PHP Key Path:** `sections[6]['data']['faqs'][4]['answer']`
- **OLD CONTENT:**
```text
Getting started is as simple as calling our Daly City team at (650) 756-1995 or submitting an availability inquiry online. We will discuss your dates, care needs, and guide you through each planning step.
```
- **NEW CONTENT:**
```text
Request pricing and share your preferred dates so the team can explain options.
```

*(Note: Surplus FAQs `faqs[1]` and `faqs[3]` are retired or disabled in Editorial V2).*

---

## Section 08: Closing CTA (`visit.cta`)
**Section Key:** `rc-cta`
**Status:** MODIFIED

### Field: `heading`
- **PHP Key Path:** `sections[7]['data']['heading']`
- **OLD CONTENT:**
```text
Talk With Our Respite Care Team
```
- **NEW CONTENT:**
```text
Let's plan the next step together.
```

### Field: `body`
- **PHP Key Path:** `sections[7]['data']['body']`
- **OLD CONTENT:**
```text
Explore short-term stay options, get answers to your questions, and see how Mission Villa can provide the support you need—for your loved one and for you.
```
- **NEW CONTENT:**
```text
Talk with our team about timing, support, and availability.
```

### Action Configuration:
- Ask About Availability (`request_availability` modal, care: `respite_care`)
- Schedule a Visit (`schedule_visit` modal, care: `respite_care`)
- Request a Call (`request_callback` modal)
- Phone: `(650) 756-1995`
