# Content Update Guide: Photo Gallery Page (`gallery`)

**Route:** `/gallery`
**PHP Source File:** `content/pages/gallery.php`
**Current Content Spec:** `docs/pages/gallery.md`
**Editorial V2 Source:** `docs/Mission_Villa_Website_Content_Editorial_V2/pages/gallery.md`

---

## Executive Summary of Changes
- **Total Sections in PHP:** 5 (`gallery-hero`, `gallery-masonry`, `gallery-virtual-tour`, `gallery-pathways`, `gallery-cta`)
- **Sections Modified:** 4 (`gallery-hero`, `gallery-masonry`, `gallery-virtual-tour`, `gallery-cta`)
- **Sections Retired / Removed:** 1 (`gallery-pathways` retired; recommend `'enabled' => false`)
- **Key Editorial Directions:**
  - Let real property photography speak: 5 verified facility photographs with short, honest captions.
  - Omit long pop-up narratives, essays, and unverified resident testimonials.
  - Virtual tour refactored to focus on encouraging in-person visits rather than premature Zoom/FaceTime claims.

---

## SEO & Page Metadata

### Field: `title`
- **PHP Key Path:** `title`
- **OLD CONTENT:**
```text
Photo Gallery & Virtual Tour | Mission Villa Senior Living in Daly City
```
- **NEW CONTENT:**
```text
Photo Gallery | Mission Villa Senior Living in Daly City
```

### Field: `seo['title']`
- **PHP Key Path:** `seo['title']`
- **OLD CONTENT:**
```text
Photo Gallery & Virtual Tour: Suites, Dining & Courtyard | Mission Villa
```
- **NEW CONTENT:**
```text
Photo Gallery | Mission Villa Senior Living in Daly City
```

### Field: `seo['description']`
- **PHP Key Path:** `seo['description']`
- **OLD CONTENT:**
```text
Explore the photo gallery and virtual walkthrough of Mission Villa in Daly City. Private suites, dining room, fireside lounges, and secure garden courtyard.
```
- **NEW CONTENT:**
```text
Take a look inside Mission Villa Senior Living in Daly City, from suites and shared rooms to our courtyard and community spaces.
```

---

## Section 01: Hero (`gallery.hero`)
**Section Key:** `gallery-hero`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[0]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Visual Monograph & Photographic Tour
```
- **NEW CONTENT:**
```text
Photo Gallery
```

### Field: `heading`
- **PHP Key Path:** `sections[0]['data']['heading']`
- **OLD CONTENT:**
```text
Experience Mission Villa Through <em>Every Space & Story.</em>
```
- **NEW CONTENT:**
```text
Take a look around.
```

### Field: `intro`
- **PHP Key Path:** `sections[0]['data']['intro']`
- **OLD CONTENT:**
```text
Explore our comfortable private and companion suites, welcoming restaurant-style dining room, fireside common lounges, and sunlit courtyard gardens—all captured to give families an honest, unvarnished look at daily life at 995 East Market Street.
```
- **NEW CONTENT:**
```text
Explore some of the spaces that make up Mission Villa, then schedule a visit to see the community in person.
```

### Field: `actions[0]['label']`
- **PHP Key Path:** `sections[0]['data']['actions'][0]['label']`
- **OLD CONTENT:**
```text
Explore Photo Monograph
```
- **NEW CONTENT:**
```text
Schedule a Visit
```

### Field: `actions[1]['label']`
- **PHP Key Path:** `sections[0]['data']['actions'][1]['label']`
- **OLD CONTENT:**
```text
Guided Virtual Tour
```
- **NEW CONTENT:**
```text
Explore Suites
```
*(Note: Route switches to `/suites-and-floor-plans`).*

---

## Section 02: Gallery Masonry (`gallery.masonry`)
**Section Key:** `gallery-masonry`
**Status:** MODIFIED (Reduced from 10 plates to 5 verified property items)

### Field: `eyebrow`
- **PHP Key Path:** `sections[1]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Curated Photographic Monograph
```
- **NEW CONTENT:**
```text
Inside Mission Villa
```

### Field: `heading`
- **PHP Key Path:** `sections[1]['data']['heading']`
- **OLD CONTENT:**
```text
Explore Mission Villa by <em>Space & Daily Rhythm.</em>
```
- **NEW CONTENT:**
```text
A glimpse of daily life.
```

### Plate 1: Private Suite
#### Field: `plates[0]['title']`
- **PHP Key Path:** `sections[1]['data']['plates'][0]['title']`
- **OLD CONTENT:**
```text
Sunlit Private Suite Sanctuary
```
- **NEW CONTENT:**
```text
Private Suite
```

#### Field: `plates[0]['caption']`
- **PHP Key Path:** `sections[1]['data']['plates'][0]['caption']`
- **OLD CONTENT:**
```text
Private suites at Mission Villa are arranged to feel personal, calm, and immediately recognizable—offering space for favorite bedding, family portraits, and an attached private bathroom.
```
- **NEW CONTENT:**
```text
A comfortable room with space for personal belongings.
```

*(Note: Surplus plates beyond the 5 approved items are removed or disabled in PHP).*

---

## Section 03: Virtual Tour (`gallery.virtual-tour`)
**Section Key:** `gallery-virtual-tour`
**Status:** MODIFIED

### Field: `eyebrow`
- **PHP Key Path:** `sections[2]['data']['eyebrow']`
- **OLD CONTENT:**
```text
Remote & Interactive Exploration
```
- **NEW CONTENT:**
```text
See More
```

### Field: `heading`
- **PHP Key Path:** `sections[2]['data']['heading']`
- **OLD CONTENT:**
```text
Virtual Tour Stage &amp; <em>Guided Spatial Walkthrough.</em>
```
- **NEW CONTENT:**
```text
Photos are just the beginning.
```

### Field: `intro`
- **PHP Key Path:** `sections[2]['data']['intro']`
- **OLD CONTENT:**
```text
Whether your family lives in Daly City or is coordinating care from across the Bay Area, step through our 4-stop interactive spatial tour below—or request a personalized live video walkthrough with our community director.
```
- **NEW CONTENT:**
```text
The best way to understand the space is to visit. We'd be happy to discuss an in-person tour with you.
```

### Field: `action_box['cta_label']`
- **PHP Key Path:** `sections[2]['data']['action_box']['cta_label']`
- **OLD CONTENT:**
```text
Request a Live Video Tour
```
- **NEW CONTENT:**
```text
Schedule a Tour
```

---

## Section 04: Pathways (`gallery.pathways`)
**Section Key:** `gallery-pathways`
**Status:** RETIRED / REMOVED IN V2

### Editorial Action:
- Retired per `CONTENT_MAP.md`: "gallery-pathways; 10 photo essays reduced to five".
- **Recommended PHP Action:** Set `'enabled' => false`.

### Field: `heading` (Retired Section)
- **PHP Key Path:** `sections[3]['data']['heading']`
- **OLD CONTENT:**
```text
Continue Exploring Mission Villa or <em>Plan Your Visit.</em>
```
- **NEW CONTENT:**
```text
[SECTION RETIRED - Set 'enabled' => false]
```

---

## Section 05: Closing CTA (`visit.cta`)
**Section Key:** `gallery-cta`
**Status:** MODIFIED

### Field: `heading`
- **PHP Key Path:** `sections[4]['data']['heading']`
- **OLD CONTENT:**
```text
Schedule an In-Person Tour or Lunch Visit
```
- **NEW CONTENT:**
```text
We'd love to welcome you in person.
```

### Field: `body`
- **PHP Key Path:** `sections[4]['data']['body']`
- **OLD CONTENT:**
```text
Photographs capture our architecture, but our people bring it to life. Walk through our suites, courtyard, and dining room in Daly City with our community director.
```
- **NEW CONTENT:**
```text
Tour the community, meet the team, and ask what matters to your family.
```

### Action Configuration:
- Schedule a Visit (`schedule_visit` modal, care: `exploring`)
- Request Pricing (`request_pricing` modal, care: `exploring`)
- Phone: `(650) 756-1995`
