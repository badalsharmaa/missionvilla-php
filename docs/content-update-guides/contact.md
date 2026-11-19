# Content Update Guide: Contact Us & Schedule a Visit (`/contact`)

> **Source File:** `content/pages/contact.php`  
> **Current Reference Documentation:** `docs/pages/contact.md`  
> **Updated Editorial Reference:** `docs/Mission_Villa_Website_Content_Editorial_V2/pages/contact.md`

---

## Overview of Editorial Changes

1. **Streamlined & Focused Hospitality Hub:** Refines the contact hub from prototype/demo language to clean, direct editorial copy welcoming prospective families.
2. **Simplified Inquiries:** Updates contact options to 4 clear modal triggers (`schedule_visit`, `request_pricing`, `request_availability`, `request_callback`).
3. **Directions Simplification:** Replaces long narrative corridors with concise arrival guidance directing families to call ahead for arrival and accessibility details.
4. **Retired Prototype & Unconfirmed Sections:** Retires Section 4 (`contact-workflow`), Section 5 (`contact-referral`), and Section 6 (`contact-faq`) in favor of direct contact and the shared inquiry modal.
5. **Brand Tone & Consistency:** Replaces salesy language with unhurried, reassuring language. Maintains Daly City phone `(650) 756-1995` and address `995 East Market Street, Daly City, CA 94014`.

---

## Replacement Map by Section

### SEO & Page Metadata

#### 1. Page Title
- **Field / PHP Key Path:** `title`
- **OLD CONTENT:**
```text
Contact Us & Schedule a Visit | Mission Villa Senior Living
```
- **NEW CONTENT:**
```text
Contact & Schedule a Visit | Mission Villa Senior Living
```

#### 2. SEO Title
- **Field / PHP Key Path:** `seo['title']`
- **OLD CONTENT:**
```text
Contact Us & Schedule a Visit | Mission Villa Daly City
```
- **NEW CONTENT:**
```text
Contact & Schedule a Visit | Mission Villa Senior Living
```

#### 3. SEO Meta Description
- **Field / PHP Key Path:** `seo['description']`
- **OLD CONTENT:**
```text
Connect with Mission Villa Senior Living in Daly City. Call 650-756-1995, explore directions via I-280 and BART, or preview a personal visit request.
```
- **NEW CONTENT:**
```text
Call or contact Mission Villa Senior Living at 995 East Market Street, Daly City, CA 94014. Ask about Memory Care, Respite Care, pricing, or visits.
```

---

### Section 01: Contact Hero (`contact-hero`)

#### 4. Hero Eyebrow
- **Field / PHP Key Path:** `sections[0]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Direct Community Desk · Phone, Guided Inquiry & Arrival Guide
```
- **NEW CONTENT:**
```text
Contact Mission Villa
```

#### 5. Hero Script Accent
- **Field / PHP Key Path:** `sections[0]['data']['script_title']`
- **OLD CONTENT:**
```text
A Warm Welcome in Daly City
```
- **NEW CONTENT:**
```text
A Warm Welcome in Daly City
```
*(Note: Can be retained as an accent or set to empty if script accents are streamlined site-wide.)*

#### 6. Hero Main Heading
- **Field / PHP Key Path:** `sections[0]['data']['heading']`
- **OLD CONTENT:**
```text
Reach Out to Our Team or Schedule an <em>Unhurried Personal Visit.</em>
```
- **NEW CONTENT:**
```text
We're here to answer your questions.
```

#### 7. Hero Lead Paragraph
- **Field / PHP Key Path:** `sections[0]['data']['lead']`
- **OLD CONTENT:**
```text
Whether you are exploring <a href="/memory-care" class="underline decoration-[#C98268] underline-offset-4 font-semibold text-[#3B2348] hover:text-[#C98268] transition">Legacies™ Memory Care</a> for a loved one living with Alzheimer’s or dementia, planning a short-term <a href="/respite-care" class="underline decoration-[#C98268] underline-offset-4 font-semibold text-[#3B2348] hover:text-[#C98268] transition">Respite Care</a> stay, or simply want to walk through our suites and dining room in person, our team at <strong class="text-[#3B2348]">995 East Market Street, Daly City, CA 94014</strong> is here to listen and help without pressure.
```
- **NEW CONTENT:**
```text
Whether you're exploring care, asking about a short stay, or ready to visit, we'd be glad to hear from you.
```

#### 8. Hero Primary CTA Label
- **Field / PHP Key Path:** `sections[0]['data']['actions'][0]['label']`
- **OLD CONTENT:**
```text
Schedule a Visit or Request Info ↓
```
- **NEW CONTENT:**
```text
Schedule a Visit
```

#### 9. Directory Card Description
- **Field / PHP Key Path:** `sections[0]['data']['directory_card']['description']`
- **OLD CONTENT:**
```text
Every call and visit request is handled by our compassionate local team—never an automated call center.
```
- **NEW CONTENT:**
```text
Every call and visit request is handled by our local team—never an automated call center.
```

---

### Section 02: Inquiry Options & Contact Studio (`contact-studio`)

#### 10. Studio Eyebrow
- **Field / PHP Key Path:** `sections[1]['data']['eyebrow']`
- **OLD CONTENT:**
```text
01 · Split Editorial Contact Studio
```
- **NEW CONTENT:**
```text
Get in Touch
```

#### 11. Studio Main Heading
- **Field / PHP Key Path:** `sections[1]['data']['heading']`
- **OLD CONTENT:**
```text
Connect By Phone, Email, or Guided Visit Request.
```
- **NEW CONTENT:**
```text
What would you like to know?
```

#### 12. Studio Intro Paragraph
- **Field / PHP Key Path:** `sections[1]['data']['intro']`
- **OLD CONTENT:**
```text
Choose the way you feel most comfortable reaching out. Call our Daly City desk directly for an immediate conversation, or use the guided form to outline your preferred contact method, care interest, and time window.
```
- **NEW CONTENT:**
```text
Choose the way you feel most comfortable reaching out. Call our Daly City desk directly at (650) 756-1995 for an immediate conversation, or select an option below.
```

#### 13. Preset 1 Label
- **Field / PHP Key Path:** `sections[1]['data']['presets'][0]['label']`
- **OLD CONTENT:**
```text
Tour Memory Care Suites
```
- **NEW CONTENT:**
```text
Schedule a Visit
```

#### 14. Preset 2 Label
- **Field / PHP Key Path:** `sections[1]['data']['presets'][1]['label']`
- **OLD CONTENT:**
```text
Short-Term Respite Stay
```
- **NEW CONTENT:**
```text
Request Pricing
```

#### 15. Preset 3 Label
- **Field / PHP Key Path:** `sections[1]['data']['presets'][2]['label']`
- **OLD CONTENT:**
```text
Pricing & Paper-Ledger Chat
```
- **NEW CONTENT:**
```text
Ask About Respite Availability
```

#### 16. Preset 4 Label
- **Field / PHP Key Path:** `sections[1]['data']['presets'][3]['label']`
- **OLD CONTENT:**
```text
First Family Phone Call
```
- **NEW CONTENT:**
```text
Request a Call
```

#### 17. Privacy Guardrail Text
- **Field / PHP Key Path:** `sections[1]['data']['privacy_guardrail']['text']`
- **OLD CONTENT:**
```text
For your family’s privacy, this inquiry form never asks for medical diagnoses, medication lists, or clinical health histories. Personal support needs are discussed privately with our care team.
```
- **NEW CONTENT:**
```text
Please don't include diagnoses, medication lists, or other sensitive medical information in this form.
```

#### 18. Form Config Title
- **Field / PHP Key Path:** `sections[1]['data']['form_config']['title']`
- **OLD CONTENT:**
```text
Schedule a Visit or Request Information
```
- **NEW CONTENT:**
```text
How can we help?
```

#### 19. Form Message Disclaimer
- **Field / PHP Key Path:** `sections[1]['data']['form_config']['message_disclaimer']`
- **OLD CONTENT:**
```text
Please do not include medical diagnoses or health records
```
- **NEW CONTENT:**
```text
Please don't include diagnoses, medication lists, or other sensitive medical information in this form
```

#### 20. Form Message Placeholder
- **Field / PHP Key Path:** `sections[1]['data']['form_config']['message_placeholder']`
- **OLD CONTENT:**
```text
Share any questions about Legacies™ Memory Care, short-term Respite Care, suites, or visiting with family...
```
- **NEW CONTENT:**
```text
Is there anything you'd like us to know before we connect?
```

#### 21. Form Consent Notice
- **Field / PHP Key Path:** `sections[1]['data']['form_config']['consent_text']`
- **OLD CONTENT:**
```text
Consent & Privacy Notice *: I request that Mission Villa Senior Living contact me via my selected preference regarding community information, pricing, or scheduling a visit. I understand that this prototype form is for general inquiry purposes only (not medical history), and final consent wording is subject to legal/privacy review prior to production launch.
```
- **NEW CONTENT:**
```text
I agree to be contacted by Mission Villa Senior Living about my inquiry using the contact information I've provided. (Legal/privacy review required.)
```

#### 22. Form Submit Label
- **Field / PHP Key Path:** `sections[1]['data']['form_config']['submit_label']`
- **OLD CONTENT:**
```text
Preview Guided Inquiry (Demo only — no inquiry sent)
```
- **NEW CONTENT:**
```text
Send Inquiry
```

---

### Section 03: Directions (`contact-directions`)

#### 23. Directions Script Title / Accent
- **Field / PHP Key Path:** `sections[2]['data']['script_title']`
- **OLD CONTENT:**
```text
Reaching 995 East Market Street
```
- **NEW CONTENT:**
```text
Visit Us
```

#### 24. Directions Heading
- **Field / PHP Key Path:** `sections[2]['data']['heading']`
- **OLD CONTENT:**
```text
Grounded Map, Peninsula Directions & Accessible Arrival.
```
- **NEW CONTENT:**
```text
Find us in Daly City.
```

#### 25. Directions Intro
- **Field / PHP Key Path:** `sections[2]['data']['intro']`
- **OLD CONTENT:**
```text
Mission Villa Senior Living sits in an established Daly City neighborhood near the western foothills of San Bruno Mountain—offering straightforward access from I-280, southern San Francisco neighborhoods, and Peninsula transit.
```
- **NEW CONTENT:**
```text
Call ahead to arrange a visit and ask any questions about arrival or accessibility.
```

---

### Section 04: What Happens After Submitting (`contact-workflow`) — RETIRED

> **Editorial Directive:** Retired. Demo-only implementation details are removed in production. Recommend setting `'enabled' => false` in `content/pages/contact.php`.

#### 26. Workflow Section Heading (Retired)
- **Field / PHP Key Path:** `sections[3]['data']['heading']`
- **OLD CONTENT:**
```text
What Happens After Submitting (Once Live Backend Is Connected).
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

#### 27. Workflow Section Intro (Retired)
- **Field / PHP Key Path:** `sections[3]['data']['intro']`
- **OLD CONTENT:**
```text
Until production backend integration is connected in a later phase, this page’s inquiry form operates strictly in Demo only — no inquiry sent mode. Here is how your inquiry flows once connected—and how to reach us today.
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

---

### Section 05: Referral Interest Pathways (`contact-referral`) — RETIRED

> **Editorial Directive:** Retired. Unconfirmed referral policies and credit programs are removed pending client confirmation. Recommend setting `'enabled' => false` in `content/pages/contact.php`.

#### 28. Referral Section Script Title (Retired)
- **Field / PHP Key Path:** `sections[4]['data']['script_title']`
- **OLD CONTENT:**
```text
Community & Partner Introductions
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

#### 29. Referral Section Heading (Retired)
- **Field / PHP Key Path:** `sections[4]['data']['heading']`
- **OLD CONTENT:**
```text
Introducing a Family Friend or Professional Care Referral.
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

---

### Section 06: Contact FAQs (`contact-faq`) — RETIRED

> **Editorial Directive:** Retired. Repeats contact and visit information found elsewhere on the site. Recommend setting `'enabled' => false` in `content/pages/contact.php`.

#### 30. FAQ Section Script Title (Retired)
- **Field / PHP Key Path:** `sections[5]['data']['script_title']`
- **OLD CONTENT:**
```text
Practical Answers Before You Visit
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

#### 31. FAQ Section Heading (Retired)
- **Field / PHP Key Path:** `sections[5]['data']['heading']`
- **OLD CONTENT:**
```text
Contact, Visit & Accessibility Directions FAQs.
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

---

### Section 07: Closing Visit CTA (`contact-cta`)

#### 32. Closing CTA Script Accent
- **Field / PHP Key Path:** `sections[6]['data']['script']`
- **OLD CONTENT:**
```text
Experience Mission Villa
```
- **NEW CONTENT:**
```text
Experience Mission Villa
```

#### 33. Closing CTA Heading
- **Field / PHP Key Path:** `sections[6]['data']['heading']`
- **OLD CONTENT:**
```text
Schedule Your Personal Visit in Daly City
```
- **NEW CONTENT:**
```text
Let's start with a conversation.
```

#### 34. Closing CTA Body
- **Field / PHP Key Path:** `sections[6]['data']['body']`
- **OLD CONTENT:**
```text
Meet our compassionate care team, walk through our suites, dining room, and courtyard gardens at 995 East Market Street, and ask any questions at your own pace.
```
- **NEW CONTENT:**
```text
Call (650) 756-1995 or choose the type of inquiry that's right for you.
```

---

## Unchanged Fields & Editorial Safeguards

- **Community Phone:** `(650) 756-1995` (`tel:16507561995`) remains the sole verified primary telephone. Legacy alternate phone `(650) 534-2859` is intentionally omitted unless verified by client.
- **Physical Address:** `995 East Market Street, Daly City, CA 94014` remains verified across all sections.
- **Email:** `mktg.missionvilla@missionvillaseniorliving.com` remains the direct marketing & tour contact.
- **Property Photograph:** `/images/property/courtyard-patio.webp` is verified and retained.
- **License Disclosure:** CA RCFE License #415601046 retained with pre-launch verification flag.
- **Production Integration Note:** Inquiry submission button and success messaging should only become active once the backend mailer/API is connected; otherwise display direct phone and email.
