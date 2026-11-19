# Content Update Guide: Financial Planning Page (`financial-planning`)

**Route:** `/financial-planning`
**PHP Source File:** `content/pages/financial-planning.php`
**Current Content Spec:** `docs/pages/financial-planning.md`
**Editorial V2 Source:** `docs/Mission_Villa_Website_Content_Editorial_V2/pages/financial-planning.md`

---

## Executive Summary of Changes
- **Total Sections in PHP:** 7 (`fp-hero`, `fp-factors`, `fp-inclusions`, `fp-worksheet`, `fp-pathways`, `fp-faq`, `fp-cta`)
- **Sections Modified:** 6 (`fp-hero`, `fp-factors`, `fp-inclusions`, `fp-worksheet`, `fp-faq`, `fp-cta`)
- **Sections Retired / Removed:** 1 (`fp-pathways` moved to specialist-reviewed articles; recommend `'enabled' => false`)
- **Key Editorial Directions:**
  - Clear, empathetic approach: "Let's make the costs easier to understand."
  - 4 core pricing drivers: Care needs, Suite choice, Length of stay, Additional services.
  - No fabricated rates, savings promises, or automated calculator marketing gimmicks.
  - Pruned FAQs from 6 to 3 focused, honest questions.

---

## SEO & Page Metadata

### Field: `title`
- **PHP Key Path:** `title`
- **OLD CONTENT:**
```text
Financial Planning & Pricing Clarity | Mission Villa Senior Living
```
- **NEW CONTENT:**
```text
Memory Care & Respite Care Costs | Mission Villa
```

### Field: `seo['title']`
- **PHP Key Path:** `seo['title']`
- **OLD CONTENT:**
```text
Financial Planning & Cost Clarity: Memory Care in Daly City | Mission Villa
```
- **NEW CONTENT:**
```text
Memory Care & Respite Care Costs | Mission Villa
```

### Field: `seo['description']`
- **PHP Key Path:** `seo['description']`
- **OLD CONTENT:**
```text
Understand the four factors that shape Memory Care and Respite Care pricing in Daly City. Review typical inclusions and use our blank Paper-Ledger Worksheet.
```
- **NEW CONTENT:**
```text
Learn what can affect Memory Care and Respite Care pricing at Mission Villa in Daly City and request a personalized cost discussion.
```

---

## Section 01: Hero (`financial-planning.hero`)
**Section Key:** `fp-hero`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[0]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Financial Planning & Cost Clarity · Daly City, California
```
- **NEW CONTENT:**
```text
Financial Planning
```

### Field: `heading`
- **PHP Key Path:** `sections[0]['data']['heading']`
- **OLD CONTENT:**
```text
Understanding the Cost of Memory Care & Respite Care with <em>Clarity and Empathy</em>.
```
- **NEW CONTENT:**
```text
Let's make the costs easier to understand.
```

### Field: `lead`
- **PHP Key Path:** `sections[0]['data']['lead']`
- **OLD CONTENT:**
```text
Planning for specialized <a href="/memory-care" class="underline decoration-[#C98268] font-semibold text-[#3B2348]">Memory Care</a> or a short-term <a href="/respite-care" class="underline decoration-[#C98268] font-semibold text-[#3B2348]">Respite Care</a> stay is one of the most important financial conversations a family will ever have. Because every resident’s daily support needs, routines, and suite preferences differ, generic rate cards and automated online calculators can be deeply misleading. We believe families deserve honest, personalized pricing grounded in an individualized care assessment and transparent review of grouped monthly inclusions.
```
- **NEW CONTENT:**
```text
Choosing senior care involves practical questions about price. We'll help your family understand how care needs, suite options, and stay length can affect the cost.
```

### Field: `actions[0]['label']`
- **PHP Key Path:** `sections[0]['data']['actions'][0]['label']`
- **OLD CONTENT:**
```text
Schedule a Tour Visit
```
- **NEW CONTENT:**
```text
Request Pricing
```
*(Note: Action intent is `request_pricing`, care: `exploring`).*

---

## Section 02: What Affects Pricing (`financial-planning.factors`)
**Section Key:** `fp-factors`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[1]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Transparent Structure
```
- **NEW CONTENT:**
```text
Cost Factors
```

### Field: `heading`
- **PHP Key Path:** `sections[1]['data']['heading']`
- **OLD CONTENT:**
```text
The 4 Factors That Shape Senior Living Costs
```
- **NEW CONTENT:**
```text
What goes into a quote?
```

### Factor 1: Care Needs
#### Field: `factors[0]['title']`
- **PHP Key Path:** `sections[1]['data']['factors'][0]['title']`
- **OLD CONTENT:**
```text
Assessment-Informed Personal Care Needs
```
- **NEW CONTENT:**
```text
Care needs
```

#### Field: `factors[0]['subtitle']`
- **PHP Key Path:** `sections[1]['data']['factors'][0]['subtitle']`
- **OLD CONTENT:**
```text
Tailored around the daily support your loved one actually needs
```
- **NEW CONTENT:**
```text
The assistance your loved one requires, based on an individual review.
```

### Factor 2: Suite Choice
#### Field: `factors[1]['title']`
- **PHP Key Path:** `sections[1]['data']['factors'][1]['title']`
- **OLD CONTENT:**
```text
Suite Layout & Shared vs. Private Living
```
- **NEW CONTENT:**
```text
Suite choice
```

#### Field: `factors[1]['subtitle']`
- **PHP Key Path:** `sections[1]['data']['factors'][1]['subtitle']`
- **OLD CONTENT:**
```text
Private Suite, Companion Unit, or Jack & Jill floor-plan formats
```
- **NEW CONTENT:**
```text
Private, companion, or another available accommodation.
```

### Factor 3: Length of Stay
#### Field: `factors[2]['title']`
- **PHP Key Path:** `sections[1]['data']['factors'][2]['title']`
- **OLD CONTENT:**
```text
Long-Term Memory Care vs. Short-Term Respite Stays
```
- **NEW CONTENT:**
```text
Length of stay
```

#### Field: `factors[2]['subtitle']`
- **PHP Key Path:** `sections[1]['data']['factors'][2]['subtitle']`
- **OLD CONTENT:**
```text
Ongoing residential living or temporary caregiver relief
```
- **NEW CONTENT:**
```text
Ongoing Memory Care or short-term Respite Care.
```

### Factor 4: Additional Services
#### Field: `factors[3]['title']`
- **PHP Key Path:** `sections[1]['data']['factors'][3]['title']`
- **OLD CONTENT:**
```text
Included Community Living vs. Personal Add-Ons
```
- **NEW CONTENT:**
```text
Additional services
```

#### Field: `factors[3]['subtitle']`
- **PHP Key Path:** `sections[1]['data']['factors'][3]['subtitle']`
- **OLD CONTENT:**
```text
Understanding what is part of base care versus optional conveniences
```
- **NEW CONTENT:**
```text
Any optional services or special arrangements not included in the quoted rate.
```

---

## Section 03: Inclusions (`financial-planning.inclusions`)
**Section Key:** `fp-inclusions`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[2]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Grouped Inclusions
```
- **NEW CONTENT:**
```text
Understanding Inclusions
```

### Field: `heading`
- **PHP Key Path:** `sections[2]['data']['heading']`
- **OLD CONTENT:**
```text
What Is Typically Included in Monthly Living
```
- **NEW CONTENT:**
```text
Ask what's included.
```

### Field: `intro`
- **PHP Key Path:** `sections[2]['data']['intro']`
- **OLD CONTENT:**
```text
Monthly living at Mission Villa consolidates housing, chef-prepared dining, 24-hour staff availability, and life enrichment into a predictable monthly investment. Filter by category below to explore typical inclusions.
```
- **NEW CONTENT:**
```text
The submitted community materials describe meals, housekeeping, laundry, daily activities, and on-site staff support. Your written quote should explain which of these are included, what level of personal care is covered, and whether any extras apply.
```

---

## Section 04: Cost Worksheet (`financial-planning.worksheet`)
**Section Key:** `fp-worksheet`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[3]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Interactive Paper-Ledger Comparison
```
- **NEW CONTENT:**
```text
Optional Cost Worksheet
```

### Field: `heading`
- **PHP Key Path:** `sections[3]['data']['heading']`
- **OLD CONTENT:**
```text
Comparing Current Household Costs With Community Living
```
- **NEW CONTENT:**
```text
Comparing care costs?
```

### Field: `intro`
- **PHP Key Path:** `sections[3]['data']['intro']`
- **OLD CONTENT:**
```text
A meaningful comparison looks at the complete picture of home living expenses—housing, food, utilities, maintenance, and private caregiving hours. Use our blank paper-ledger worksheet below to enter your family’s actual monthly costs.
```
- **NEW CONTENT:**
```text
You may find it helpful to total monthly expenses at home, including housing, meals, utilities, transportation, and outside caregiving.
```

---

## Section 05: Pathways (`financial-planning.pathways`)
**Section Key:** `fp-pathways`
**Status:** RETIRED / REMOVED IN V2

### Editorial Action:
- Retired per `CONTENT_MAP.md` and V2 notes: "fp-pathways moved to specialist-reviewed articles. Do not publish unverified acceptance of insurance, state assistance, or referral credits. No invented pricing."
- **Recommended PHP Action:** Set `'enabled' => false`.

### Field: `heading` (Retired Section)
- **PHP Key Path:** `sections[4]['data']['heading']`
- **OLD CONTENT:**
```text
Ways Families Structure Care Budgets & Benefit Programs
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

---

## Section 06: FAQs (`financial-planning.faq`)
**Section Key:** `fp-faq`
**Status:** MODIFIED (Pruned from 6 FAQs to 3 core questions)

### FAQ 1: Price Before Visiting
#### Field: `items[0]['question']`
- **PHP Key Path:** `sections[5]['data']['items'][0]['question']`
- **OLD CONTENT:**
```text
Why doesn’t Mission Villa list fixed monthly prices or an automated calculator online?
```
- **NEW CONTENT:**
```text
Can I get a price before visiting?
```

#### Field: `items[0]['answer']`
- **PHP Key Path:** `sections[5]['data']['items'][0]['answer']`
- **OLD CONTENT:**
```text
Every resident living with Alzheimer’s or dementia has distinct daily care needs, routines, and suite preferences. Online calculators that display pre-filled estimates or promised “savings” often mislead families. Instead, our Daly City team provides straightforward, personalized pricing information after learning about your loved one and discussing available Private, Companion, or Jack & Jill suites.
```
- **NEW CONTENT:**
```text
Ask the team for current starting information and the steps needed for a personalized quote.
```

### FAQ 2: Suite Cost Dependency
#### Field: `items[3]['question']`
- **PHP Key Path:** `sections[5]['data']['items'][3]['question']`
- **OLD CONTENT:**
```text
How do Companion Units and Jack & Jill suites help families planning a budget?
```
- **NEW CONTENT:**
```text
Will the cost depend on the suite?
```

#### Field: `items[3]['answer']`
- **PHP Key Path:** `sections[5]['data']['items'][3]['answer']`
- **OLD CONTENT:**
```text
For many families, our Companion Unit (shared suite) and Jack & Jill suite formats offer two benefits at once: they provide a more approachable accommodation rate than a solo Private Suite while giving residents comforting daily camaraderie and a shared private bathroom.
```
- **NEW CONTENT:**
```text
It can. Room type and assessed assistance needs may affect pricing.
```

### FAQ 3: Insurance & Benefits
#### Field: `items[4]['question']`
- **PHP Key Path:** `sections[5]['data']['items'][4]['question']`
- **OLD CONTENT:**
```text
Can we use Long-Term Care Insurance, referral credits, or state assistance programs?
```
- **NEW CONTENT:**
```text
What about insurance or benefits?
```

#### Field: `items[4]['answer']`
- **PHP Key Path:** `sections[5]['data']['items'][4]['answer']`
- **OLD CONTENT:**
```text
Many families draw on Long-Term Care (LTC) insurance benefits to help pay for Memory Care or Respite Care; our team can share licensing information (CA RCFE #415601046) and care documentation to assist with your insurer’s claim process. Because referral credits and state assistance participation mentioned on our historical website are subject to change and specific eligibility rules, please ask our team to confirm current program status directly.
```
- **NEW CONTENT:**
```text
Policy coverage and eligibility vary. Ask your insurer about long-term care benefits and discuss documentation with our team. Do not assume Mission Villa participates in a particular payment or assistance program without confirmation.
```

*(Note: Surplus FAQs in PHP `items` are disabled or hidden in Editorial V2).*

---

## Section 07: Closing CTA (`visit.cta`)
**Section Key:** `fp-cta`
**Status:** MODIFIED

### Field: `heading`
- **PHP Key Path:** `sections[6]['data']['heading']`
- **OLD CONTENT:**
```text
Schedule a Financial Planning Walkthrough in Daly City
```
- **NEW CONTENT:**
```text
Get answers about the cost of care.
```

### Field: `body`
- **PHP Key Path:** `sections[6]['data']['body']`
- **OLD CONTENT:**
```text
Meet our care leadership, tour available suites and community spaces, and receive a clear, assessment-informed pricing overview with zero pressure.
```
- **NEW CONTENT:**
```text
Start with a conversation about your family's situation and current options.
```

### Action Configuration:
- Request Pricing (`request_pricing` modal, care: `exploring`)
- Schedule a Visit (`schedule_visit` modal, care: `exploring`)
- Request a Call (`request_callback` modal)
- Phone: `(650) 756-1995`
