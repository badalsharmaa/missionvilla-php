# Mission Villa WordPress Migration — Slow & Steady Progress Tracker

> Update this file at the end of EVERY completed phase/page. Do not start Phase N+1 until Phase N passes all 4 QA gates in `06-VISUAL-QA-AND-PARITY-PROTOCOL.md`.

---

## Phase 0: Environment & Reference Setup
- [ ] Laravel reference running at `http://127.0.0.1:8010`
- [ ] Local WordPress installed (PHP 8.3+, MariaDB, permalinks `/%postname%/`, WP-CLI active)
- [ ] Playwright installed for automated visual pixel-diff QA

## Phase 1: Theme Scaffold & Global Shell
- [ ] `style.css`, `theme.json` (v3), `functions.php`
- [ ] Dual build working: `vite build` (Tailwind v4 + GSAP 3.12.5) + `wp-scripts build`
- [ ] `inc/setup.php`, `inc/assets.php`, `inc/blocks.php`, `inc/helpers.php`, `inc/seo.php`
- [ ] `inc/settings.php` (WP Admin → Mission Villa Settings)
- [ ] `template-parts/site-header.php` + `inc/nav-walker.php` + `site-header.js`
- [ ] `template-parts/site-footer.php`
- [ ] `template-parts/inquiry-dialog.php` + `inquiry-form.php` + `inquiry-dialog.js`
- [ ] Shared Block Editor React primitives (`src/block-editor/shared/*`)
- [ ] **Phase 1 QA Gate Passed** (Header/Footer/Modal pixel-identical)

## Phase 2: Backend Inquiry API, Media Manifest, WP-CLI Seeder & Shared Blocks
- [ ] `inc/inquiries-db.php` (`wp_mv_lead_submissions` + encrypted storage + Admin Leads table)
- [ ] `inc/inquiries-rest.php` (`POST /wp-json/missionvilla/v1/inquiries` — 201/422/429/503)
- [ ] `inc/life-gallery-manifest.php` (`MV_Life_Gallery_Manifest`)
- [ ] `inc/cli-seeder.php` (`wp mv import-media`, `seed-menus`, `seed-page`, `seed-all`, `verify-blocks`)
- [ ] Media imported (49 images) + 4 WP Nav Menus seeded
- [ ] Shared Block 1/71: `missionvilla/visit-cta`
- [ ] Shared Block 2/71: `missionvilla/faq-featured`
- [ ] **Phase 2 QA Gate Passed**

## Phase 3: Page 1 — Home (`/`)
- [ ] Block 3/71: `missionvilla/intro-shutters` (GSAP + Allura)
- [ ] Block 4/71: `missionvilla/hero-cinematic` (GSAP + care-chat + concierge)
- [ ] Block 5/71: `missionvilla/care-options` (+ icon partial)
- [ ] Block 6/71: `missionvilla/life-gallery` (+ icon partial + video manifest)
- [ ] Block 7/71: `missionvilla/why-families` (+ icon partial + video manifest)
- [ ] Block 8/71: `missionvilla/suites-spaces`
- [ ] Seeded via `wp mv seed-page home` + set as Front Page
- [ ] **Phase 3 QA Gate Passed** (Pixel diff < 0.5% + GSAP + Gutenberg edit test)

## Phase 4: Page 2 — Living Options (`/living-options`)
- [ ] Block 9/71: `missionvilla/living-options-hero`
- [ ] Block 10/71: `missionvilla/living-options-care`
- [ ] Block 11/71: `missionvilla/living-options-suites`
- [ ] Block 12/71: `missionvilla/living-options-setting`
- [ ] Block 13/71: `missionvilla/living-options-faq`
- [ ] Seeded + **Phase 4 QA Gate Passed**

## Phase 5: Page 3 — Memory Care (`/memory-care`)
- [ ] Block 14/71: `missionvilla/memory-care-hero`
- [ ] Block 15/71: `missionvilla/memory-care-legacies`
- [ ] Block 16/71: `missionvilla/memory-care-daily-life`
- [ ] Block 17/71: `missionvilla/memory-care-care-comfort`
- [ ] Seeded (reuses `faq-featured` & `visit-cta`) + **Phase 5 QA Gate Passed**

## Phase 6: Page 4 — Respite Care (`/respite-care`)
- [ ] Block 18/71: `missionvilla/respite-care-hero`
- [ ] Block 19/71: `missionvilla/respite-care-scenarios`
- [ ] Block 20/71: `missionvilla/respite-care-inclusions`
- [ ] Block 21/71: `missionvilla/respite-care-story`
- [ ] Block 22/71: `missionvilla/respite-care-caregiver`
- [ ] Block 23/71: `missionvilla/respite-care-timeline`
- [ ] Block 24/71: `missionvilla/respite-care-faq`
- [ ] Seeded + **Phase 6 QA Gate Passed**

## Phase 7: Page 5 — Suites & Floor Plans (`/suites-and-floor-plans`)
- [ ] Block 25/71: `missionvilla/suites-floor-plans-hero`
- [ ] Block 26/71: `missionvilla/suites-floor-plans-formats`
- [ ] Block 27/71: `missionvilla/suites-floor-plans-diagram`
- [ ] Block 28/71: `missionvilla/suites-floor-plans-features`
- [ ] Block 29/71: `missionvilla/suites-floor-plans-faq`
- [ ] Seeded + **Phase 7 QA Gate Passed**

## Phase 8: Page 6 — Life at Mission Villa (`/life-at-mission-villa`)
- [ ] Block 30/71: `missionvilla/life-at-mission-villa-hero`
- [ ] Block 31/71: `missionvilla/life-at-mission-villa-pillars`
- [ ] Block 32/71: `missionvilla/life-at-mission-villa-rhythm`
- [ ] Block 33/71: `missionvilla/life-at-mission-villa-engagement`
- [ ] Block 34/71: `missionvilla/life-at-mission-villa-faq`
- [ ] Seeded + **Phase 8 QA Gate Passed**

## Phase 9: Page 7 — Services & Amenities (`/services-and-amenities`)
- [ ] Block 35/71: `missionvilla/services-and-amenities-hero`
- [ ] Block 36/71: `missionvilla/services-and-amenities-explorer`
- [ ] Block 37/71: `missionvilla/services-and-amenities-diptych`
- [ ] Block 38/71: `missionvilla/services-and-amenities-disclosures`
- [ ] Block 39/71: `missionvilla/services-and-amenities-care-bridge`
- [ ] Seeded + **Phase 9 QA Gate Passed**

## Phase 10: Page 8 — Gallery (`/gallery`)
- [ ] Block 40/71: `missionvilla/gallery-hero`
- [ ] Block 41/71: `missionvilla/gallery-masonry`
- [ ] Block 42/71: `missionvilla/gallery-virtual-tour`
- [ ] Block 43/71: `missionvilla/gallery-pathways`
- [ ] Seeded + **Phase 10 QA Gate Passed**

## Phase 11: Page 9 — About (`/about`)
- [ ] Block 44/71: `missionvilla/about-hero`
- [ ] Block 45/71: `missionvilla/about-philosophy`
- [ ] Block 46/71: `missionvilla/about-geography`
- [ ] Block 47/71: `missionvilla/about-core-values`
- [ ] Block 48/71: `missionvilla/about-team-commitment`
- [ ] Seeded + **Phase 11 QA Gate Passed**

## Phase 12: Page 10 — For Families (`/for-families`)
- [ ] Block 49/71: `missionvilla/for-families-hero`
- [ ] Block 50/71: `missionvilla/for-families-decision-guide`
- [ ] Block 51/71: `missionvilla/for-families-checklist`
- [ ] Block 52/71: `missionvilla/for-families-involvement`
- [ ] Block 53/71: `missionvilla/for-families-faq`
- [ ] Block 54/71: `missionvilla/for-families-bridge`
- [ ] Seeded + **Phase 12 QA Gate Passed**

## Phase 13: Page 11 — Financial Planning (`/financial-planning`)
- [ ] Block 55/71: `missionvilla/financial-planning-hero`
- [ ] Block 56/71: `missionvilla/financial-planning-factors`
- [ ] Block 57/71: `missionvilla/financial-planning-inclusions`
- [ ] Block 58/71: `missionvilla/financial-planning-worksheet`
- [ ] Block 59/71: `missionvilla/financial-planning-pathways`
- [ ] Block 60/71: `missionvilla/financial-planning-faq`
- [ ] Seeded + **Phase 13 QA Gate Passed**

## Phase 14: Page 12 — Resources (`/resources`)
- [ ] Block 61/71: `missionvilla/resources-hero`
- [ ] Block 62/71: `missionvilla/resources-desk`
- [ ] Block 63/71: `missionvilla/resources-packet`
- [ ] Block 64/71: `missionvilla/resources-blog`
- [ ] Block 65/71: `missionvilla/resources-faq`
- [ ] Seeded + **Phase 14 QA Gate Passed**

## Phase 15: Page 13 — Contact (`/contact`) & Final Sign-Off
- [ ] Block 66/71: `missionvilla/contact-hero`
- [ ] Block 67/71: `missionvilla/contact-studio`
- [ ] Block 68/71: `missionvilla/contact-directions`
- [ ] Block 69/71: `missionvilla/contact-workflow`
- [ ] Block 70/71: `missionvilla/contact-referral`
- [ ] Block 71/71: `missionvilla/contact-faq`
- [ ] Seeded + **Phase 15 QA Gate Passed**
- [ ] **Final 13-Page Playwright Regression Sweep Passed (52/52 viewports)**
- [ ] **`wp mv verify-blocks` Passed (71/71 blocks, 84/84 instances, 0 errors)**
