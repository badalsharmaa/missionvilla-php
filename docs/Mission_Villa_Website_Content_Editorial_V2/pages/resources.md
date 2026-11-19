# Resources Page (`/resources`)

**Source File:** `content/pages/resources.php`  
**Header Variant:** `overlay`  
**Editorial Status:** Revised copy for review

## SEO & Page Metadata
- **Slug:** `resources`
- **SEO Page Title:** Family Resources | Mission Villa Senior Living
- **Meta Description:** Helpful starting points for families exploring Memory Care, Respite Care, costs, and visiting Mission Villa in Daly City.
- **OG Image:** `/images/property/sitting-nook-detail.webp`

## Section 01: Hero (`resources.hero`)
- **Section Key:** `res-hero`
- **Eyebrow:** Family Resources
- **Heading:** Helpful information, when you need it.
- **Description:** Explore care options, prepare for a visit, or learn which questions to ask about cost. Start with the topic that's most useful to you.
- **Primary CTA:** Ask a Question (`request_callback` modal, care: `exploring`)
- **Secondary CTA:** Schedule a Visit (`schedule_visit` modal, care: `exploring`)

## Section 02: Helpful Guides (`resources.desk`)
- **Section Key:** `res-desk`
- **Eyebrow:** Start Here
- **Heading:** Find the information you're looking for.

### Guide 1 — Choosing Care
- **Description:** Understand the difference between ongoing Memory Care and short-term Respite Care.
- **CTA:** Compare Living Options (`/living-options`)

### Guide 2 — Costs & Planning
- **Description:** See what affects pricing and what to ask when requesting a quote.
- **CTA:** Explore Financial Planning (`/financial-planning`)

### Guide 3 — Preparing for a Visit
- **Description:** Get a short list of useful questions to bring on a tour.
- **CTA:** Visit the Family Guide (`/for-families`)

### Guide 4 — Daily Life & Suites
- **Description:** Explore the community's living spaces, meals, and day-to-day routines.
- **CTA:** See Daily Life (`/life-at-mission-villa`)

## Section 03: Brochures & Materials (`resources.packet`)
- **Section Key:** `res-packet`
- **Eyebrow:** More Information
- **Heading:** Need something specific?
- **Description:** Ask our team about a community brochure, available suite layouts, or current activity information.
- **CTA:** Request Information (`general_inquiry` modal, care: `exploring`)
- **Asset Rule:** Only show brochure/download links when approved files actually exist. Until then, offer an inquiry rather than a broken download or public “asset pending” card.

## Section 04: Articles & Advice (`resources.blog`)
- **Section Key:** `res-blog`
- **Eyebrow:** Learn More
- **Heading:** More guidance for families.
- **Description:** Longer guides about memory care, respite planning, and family visits will live in our article library.
- **Publishing Rule:** Do not display this section or a `/blog` link until real, edited, approved articles are available. Never invent article authors or publication dates.
- **Proposed First Article Topics (internal only):** What to Ask on a Memory Care Tour; How Respite Care Works; Preparing for a Move into Memory Care; Understanding Care Costs. See `BLOG_CONTENT_PLAN.md` in the ZIP root.

## Section 06: Closing CTA (`visit.cta`)
- **Section Key:** `res-cta`
- **Heading:** Prefer to talk with someone?
- **Description:** Our team can help point you toward the information you need.
- **Actions:** Request a Call (`request_callback`) | Schedule a Visit (`schedule_visit`)

<!-- Retired: resources.faq and all internal blog-migration, brochure-status, “zero fabricated,” editorial audit, and packet-builder language from public display. Those are production notes, not family-facing content. -->
