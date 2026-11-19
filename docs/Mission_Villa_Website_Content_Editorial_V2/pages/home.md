# Home Page (`/`)

**Source File:** `content/pages/home.php`  
**Header Variant:** `overlay`  
**Editorial Status:** Revised copy for review — not approved for publication

## SEO & Page Metadata
- **Slug:** `home`
- **SEO Page Title:** Mission Villa Senior Living | Memory Care & Respite Care in Daly City
- **Meta Description:** Explore Legacies™ Memory Care and short-term Respite Care at Mission Villa Senior Living in Daly City. Learn about our community or schedule a visit.
- **OG Image:** `/images/hero/family-connection-1200.webp` *(illustrative; label clearly)*

## Section 00: Opening Shutters (`intro.shutters`)
- **Section Key:** `intro`
- **Left Heading:** Mission Villa
- **Left Tagline:** Care that feels personal.
- **Right Location:** Daly City, California
- **Right Tagline:** Memory Care & Respite Care
- **Skip Button:** Skip Intro

## Section 01: Cinematic Hero (`hero.cinematic`)
- **Section Key:** `hero`
- **Design Note:** Keep the approved full-height hero and three-slide format; brief copy only. Existing slide images may be retained with correct illustrative labels.

### Slide 1 — Welcome
- **Eyebrow:** Welcome to Mission Villa
- **Heading:** A place to feel at home.
- **Description:** Personal attention, familiar routines, and a welcoming community in Daly City. We're here for older adults and the families who care for them.
- **CTA:** Schedule a Visit (`schedule_visit` modal, care: `exploring`)
- **Image:** `/images/hero/family-connection-2000.webp` *(illustrative)*

### Slide 2 — Memory Care
- **Eyebrow:** Legacies™ Memory Care
- **Heading:** Care that begins with knowing the person.
- **Description:** Support for people living with Alzheimer's disease or other forms of dementia, shaped around their stories, preferences, and daily routines.
- **CTA:** Explore Memory Care (`/memory-care`)
- **Image:** `/images/hero/memory-care-conversation-2000.webp` *(illustrative)*

### Slide 3 — Respite Care
- **Eyebrow:** Short-Term Respite Care
- **Heading:** A little support can make a big difference.
- **Description:** A short stay for your loved one while you rest, travel, or take care of life's demands.
- **CTA:** Ask About Respite Stays (`request_availability` modal, care: `respite_care`)
- **Image:** `/images/hero/respite-quiet-reading-2000.webp` *(illustrative)*

### Optional Care Guide Preview
- **Heading:** Not sure where to begin?
- **Description:** Learn about our two care options or ask the team a question.
- **Choices:** Memory Care (`/memory-care`) | Respite Care (`/respite-care`) | Request a Call (`request_callback` modal)
- **Publishing Rule:** Do not present a prototype chat as a live care adviser. Show the widget only if its behavior, disclaimers, and inquiry routing are tested.

## Section 02: Care Options (`care.options`)
- **Section Key:** `care-options`
- **Eyebrow:** Our Care Options
- **Heading:** The right care for this stage of life.

### Card 1 — Memory Care
- **Title:** Legacies™ Memory Care
- **Description:** Ongoing support for people living with memory loss, with attention to familiar routines and personal connections.
- **Flip Details (maximum 2):** Life-story-led care; supportive daily routines.
- **CTA:** Learn About Memory Care (`/memory-care`)
- **Image:** `/images/care/memory-care-companion-1122.webp` *(illustrative)*

### Card 2 — Respite Care
- **Title:** Short-Term Respite Care
- **Description:** A comfortable, temporary stay that supports your loved one and gives family caregivers time away.
- **Flip Details (maximum 2):** Daily assistance; dining and activities.
- **CTA:** Learn About Respite Care (`/respite-care`)
- **Image:** `/images/care/respite-care-welcome-1402.webp` *(illustrative)*

## Section 03: Life at Mission Villa (`life.gallery`)
- **Section Key:** `life-gallery`
- **Eyebrow:** Everyday Life
- **Heading:** A closer look at Mission Villa.
- **Description:** Comfortable spaces, shared meals, and time for connection.
- **Tab 1:** Living Spaces — A room to make your own. (`/suites-and-floor-plans`)
- **Tab 2:** Dining & Daily Life — Familiar meals and a welcoming table. (`/life-at-mission-villa`)
- **Tab 3:** Connection — Music, activities, and quiet moments together. (`/life-at-mission-villa`)
- **CTA:** See Daily Life (`/life-at-mission-villa`)
- **Media Rule:** Use approved videos or property photography. Label any illustrative footage; do not show stale “film in production” notices.

## Section 04: Why Mission Villa (`trust.why-families`)
- **Section Key:** `why-families`
- **Eyebrow:** Our Approach
- **Heading:** Small details. Personal care.
- **Description:** We learn what matters to each resident—from everyday preferences to the people and memories they hold close.
- **Three Highlights:** Familiar routines | Family involvement | A welcoming residential setting
- **Image:** `/images/why-families/courtyard-patio-facility-1024.webp` *(property photograph; rights to confirm)*
- **CTA:** About Mission Villa (`/about`)

## Section 05: Suites (`living.suites`)
- **Section Key:** `suites`
- **Eyebrow:** Suites & Shared Spaces
- **Heading:** Room to feel comfortable.
- **Description:** Explore private, companion, and Jack & Jill suite formats. Availability and room arrangements can be discussed during a visit.
- **Tab 1:** Private Suites — `/images/suites/suite-bedroom-facility-899.webp`
- **Tab 2:** Companion Suites — `/images/suites/companion-suite-floorplan-1000.webp` *(use only if approved as an actual layout)*
- **Tab 3:** Community Spaces — `/images/suites/community-lounge-facility-899.webp`
- **CTA:** Explore Suites (`/suites-and-floor-plans`)

## Section 06: Featured FAQs (`faq.featured`)
- **Section Key:** `faq`
- **Heading:** A few common questions.
1. **What care does Mission Villa provide?** Legacies™ Memory Care and short-term Respite Care.
2. **Can we tour the community?** Yes. Call (650) 756-1995 or request a visit to discuss a convenient time.
3. **How do we find out about pricing?** Speak with the team about care needs, suite options, and current rates.
- **More Questions:** Visit For Families (`/for-families`)

## Section 07: Visit CTA (`visit.cta`)
- **Section Key:** `visit`
- **Heading:** Come see Mission Villa for yourself.
- **Description:** Tour the community, meet the team, and ask what matters to your family.
- **Primary CTA:** Schedule a Visit (`schedule_visit` modal, care: `exploring`)
- **Secondary CTA:** Request Pricing (`request_pricing` modal, care: `exploring`)
- **Tertiary CTA:** Request a Call (`request_callback` modal)
- **Contact:** (650) 756-1995
- **Developer Note:** Keep the approved visual layout and existing form-card space if needed, but all form-intent CTAs open the shared modal rather than scrolling to an inline form. Do not claim form delivery works until verified.
