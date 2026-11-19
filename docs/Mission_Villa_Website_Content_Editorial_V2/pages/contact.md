# Contact Us & Schedule a Visit Page (`/contact`)

**Source File:** `content/pages/contact.php`  
**Header Variant:** `overlay`  
**Editorial Status:** Revised copy for review

## SEO & Page Metadata
- **Slug:** `contact`
- **SEO Page Title:** Contact & Schedule a Visit | Mission Villa Senior Living
- **Meta Description:** Call or contact Mission Villa Senior Living at 995 East Market Street, Daly City, CA 94014. Ask about Memory Care, Respite Care, pricing, or visits.
- **OG Image:** `/images/property/courtyard-patio.webp`

## Section 01: Contact Hero (`contact.hero`)
- **Section Key:** `contact-hero`
- **Eyebrow:** Contact Mission Villa
- **Heading:** We're here to answer your questions.
- **Description:** Whether you're exploring care, asking about a short stay, or ready to visit, we'd be glad to hear from you.
- **Phone:** (650) 756-1995 (`tel:16507561995`)
- **Email:** `mktg.missionvilla@missionvillaseniorliving.com`
- **Address:** 995 East Market Street, Daly City, CA 94014
- **License:** California RCFE #415601046 *(verify before launch)*
- **Primary CTA:** Schedule a Visit (`schedule_visit` modal, care: `exploring`)
- **Secondary CTA:** Request a Call (`request_callback` modal)
- **Image:** `/images/property/courtyard-patio.webp` *(property photograph)*

## Section 02: Inquiry Options (`contact.studio`)
- **Section Key:** `contact-studio`
- **Eyebrow:** Get in Touch
- **Heading:** What would you like to know?
- **Option 1:** Schedule a Visit (`schedule_visit` modal)
- **Option 2:** Request Pricing (`request_pricing` modal)
- **Option 3:** Ask About Respite Availability (`request_availability` modal, care: `respite_care`)
- **Option 4:** Request a Call (`request_callback` modal)

### Shared Inquiry Modal Copy
- **Title:** How can we help?
- **Intro:** Share your contact details and a little about what you're looking for. Our team can follow up using your preferred contact method.
- **Fields:** Name (required); Phone or Email (at least one required); Interest (Memory Care / Respite Care / Not Sure); Request Type (preselected from CTA); Preferred Contact Time (optional); Message (optional).
- **Message Placeholder:** Is there anything you'd like us to know before we connect?
- **Privacy Helper:** Please don't include diagnoses, medication lists, or other sensitive medical information in this form.
- **Consent Draft:** I agree to be contacted by Mission Villa Senior Living about my inquiry using the contact information I've provided. *(Legal/privacy review required.)*
- **Submit Button:** Send Inquiry *(use only when the production integration actually delivers inquiries; otherwise disable the form and emphasize telephone/email contact)*
- **Success Message:** Thank you. Your request has been received. *(Show only after confirmed successful submission, never on a local demo-only save.)*

## Section 03: Directions (`contact.directions`)
- **Section Key:** `contact-directions`
- **Eyebrow:** Visit Us
- **Heading:** Find us in Daly City.
- **Address:** 995 East Market Street, Daly City, CA 94014
- **Description:** Call ahead to arrange a visit and ask any questions about arrival or accessibility.
- **Map:** Link to this exact address in a map service; confirm displayed pin and entrance details.
- **CTA:** Schedule a Visit (`schedule_visit` modal, care: `exploring`)

## Section 07: Closing CTA (`visit.cta`)
- **Section Key:** `contact-cta`
- **Heading:** Let's start with a conversation.
- **Description:** Call (650) 756-1995 or choose the type of inquiry that's right for you.
- **Actions:** Schedule a Visit (`schedule_visit`) | Request Pricing (`request_pricing`) | Request a Call (`request_callback`)

<!-- Retired: contact.workflow (demo-only implementation details), contact.referral (unconfirmed referral policies), contact.faq (repeats contact info). Do not promise reply time, specific transportation routes, on-site parking, or in-person video tours without current verification. Original draft also mentioned alternate legacy phone (650) 534-2859: do not publish it unless client confirms. -->
