# 05 — Complete Page-by-Page Conversion Blueprints (All 13 Pages / 71 Blocks)
## Verified Section Order, Source Files, Assets, Special Partials & Editor Controls

> Every single page below has been verified directly against `routes/web.php`, `content/pages/*.php`, `app/Content/Sections/*.php`, `resources/views/sections/*`, and `vite.config.js`.
> All 13 pages use `header_variant: overlay` and close with the shared `missionvilla/visit-cta` block.

---

## Shared Blocks (Build First in Phase 2)

### Shared Block A: `missionvilla/visit-cta` (Used on ALL 13 Pages)
- **Laravel Source:** `VisitCtaSection.php` | `sections/visit-cta/index.blade.php` | `visit-cta.css` (216L) | JS: None (driven by global `inquiry-dialog.js`)
- **Special Assets:** Google Font `Allura` (for `.vc__script`), SVG wave edge `.vc__wave`, botanical leaf `/images/decor/botanical-leaf-shadow.svg`, embeds `template-parts/inquiry-form.php` (`instance="inline"`).
- **Native Gutenberg Controls:** Inline `<RichText>` for script eyebrow, heading, body, card heading, card lede; Repeater for up to 3 vertical action buttons (label, icon picker, inquiry intent, primary style toggle); Inspector toggles for `show_contact`, `show_form`, `source`, and `care` preselect.

### Shared Block B: `missionvilla/faq-featured` (Used on `home` & `memory-care`)
- **Laravel Source:** `FaqFeaturedSection.php` | `sections/faq-featured/index.blade.php` | `faq-featured.css` (199L) | `faq-featured.js` (51L — accordion toggle)
- **Native Gutenberg Controls:** Inline `<RichText>` for eyebrow, heading (`<em>`), intro, CTA; Repeater for FAQ items (question + answer inline `<RichText>`, add/remove/reorder).

---

## Phase 3 — Page 1: Home (`/`)
- **Content File:** `content/pages/home.php`
- **SEO Title:** `Mission Villa Senior Living | Memory Care & Respite Care in Daly City`
- **Sections (8 total — 6 new + 2 shared):**

| # | Laravel Type | WP Block Slug | Schema Class | CSS / JS | Special Dependencies & Editor Notes |
|---|---|---|---|---|---|
| 1 | `intro.shutters` | `missionvilla/intro-shutters` | `IntroShuttersSection` | `intro-shutters.css` (19L) / `intro-shutters.js` (112L) | **GSAP 3.12.5** + **Allura font**. In `edit.js`, render as a compact non-blocking banner so editors can edit shutter copy without covering the canvas! |
| 2 | `hero.cinematic` | `missionvilla/hero-cinematic` | `HeroCinematicSection` | `hero-cinematic.css` (402L) / `hero-cinematic.js` (516L) | **GSAP 3.12.5** + **2 extra partials** (`hero-care-chat.php`, `hero-concierge.php`) + `<link rel="preload">` for slide 0 desktop/mobile hero images. Editor needs Slide Switcher tabs (01/02/03) to edit each slide's 3 headline lines, body, eyebrow, CTA, desktop/mobile photo, provenance, + Care Guide sidebar choices & footnote. |
| 3 | `care.options` | `missionvilla/care-options` | `CareOptionsSection` | `care-options.css` (623L) / `care-options.js` (74L) | **Extra partial:** `care-options-icon.php`. Two interactive care cards (Memory Care & Respite Care) with tabs/hover states, feature lists, photos, and inquiry/page CTAs. |
| 4 | `life.gallery` | `missionvilla/life-gallery` | `LifeGallerySection` | `life-gallery.css` (792L) / `life-gallery.js` (478L) | **Extra partial:** `life-gallery-icon.php` + **`MV_Life_Gallery_Manifest`** (`public/media/mission-villa/...`). Interactive chapter/film gallery + fallback stills. Editor allows editing chapter titles, descriptions, poster photos, and manifest path. |
| 5 | `trust.why-families` | `missionvilla/why-families` | `WhyFamiliesSection` | `why-families.css` (574L) / `why-families.js` (22L) | **Extra partial:** `why-families-icon.php` + **`MV_Life_Gallery_Manifest`**. Trust pillars, quote/proof strip, and photography. |
| 6 | `living.suites` | `missionvilla/suites-spaces` | `SuitesSpacesSection` | `suites-spaces.css` (270L) / `suites-spaces.js` (51L) | Interactive suite tabs/cards (Private / Companion / Shared Spaces) with `data-inquiry-suite` preselects. |
| 7 | `faq.featured` | `missionvilla/faq-featured` | *(Shared)* | *(Shared)* | Reuse Phase 2 block. |
| 8 | `visit.cta` | `missionvilla/visit-cta` | *(Shared)* | *(Shared)* | Reuse Phase 2 block. |

---

## Phase 4 — Page 2: Living Options (`/living-options`)
- **Content File:** `content/pages/living-options.php`
- **SEO Title:** `Living Options | Memory Care & Respite Care at Mission Villa`
- **Sections (6 total — 5 new + 1 shared):**

| # | Laravel Type | WP Block Slug | Schema Class | CSS / JS | Editor & Interaction Notes |
|---|---|---|---|---|---|
| 1 | `living-options.hero` | `missionvilla/living-options-hero` | `LivingOptionsHeroSection` | `living-options-hero.css` (336L) / none | Full-bleed hero with eyebrow, heading (`<em>`), body, CTAs, hero photo + provenance. |
| 2 | `living-options.care` | `missionvilla/living-options-care` | `LivingOptionsCareSection` | `living-options-care.css` (574L) / `living-options-care.js` (70L) | Interactive care comparison tabs/cards (Memory Care vs Respite Care). Editor needs tab selector to edit both panels inline. |
| 3 | `living-options.suites` | `missionvilla/living-options-suites` | `LivingOptionsSuitesSection` | `living-options-suites.css` (358L) / none | Suite options showcase with photos, feature bullets, and inquiry CTAs. |
| 4 | `living-options.setting` | `missionvilla/living-options-setting` | `LivingOptionsSettingSection` | `living-options-setting.css` (144L) / none | Homelike setting editorial band. |
| 5 | `living-options.faq` | `missionvilla/living-options-faq` | `LivingOptionsFaqSection` | `living-options-faq.css` (294L) / `living-options-faq.js` (69L) | Accordion FAQ section with repeater controls. |
| 6 | `visit.cta` | `missionvilla/visit-cta` | *(Shared)* | *(Shared)* | Reuse Phase 2 block. |

---

## Phase 5 — Page 3: Memory Care (`/memory-care`)
- **Content File:** `content/pages/memory-care.php`
- **SEO Title:** `Legacies™ Memory Care in Daly City | Mission Villa`
- **Sections (6 total — 4 new + 2 shared):**

| # | Laravel Type | WP Block Slug | Schema Class | CSS / JS | Editor & Interaction Notes |
|---|---|---|---|---|---|
| 1 | `memory-care.hero` | `missionvilla/memory-care-hero` | `MemoryCareHeroSection` | `memory-care-hero.css` (291L) / none | Memory Care hero with Legacies™ copy, CTAs, and photography. |
| 2 | `memory-care.legacies` | `missionvilla/memory-care-legacies` | `MemoryCareLegaciesSection` | `memory-care-legacies.css` (396L) / `memory-care-legacies.js` (68L) | Interactive Legacies™ pillars/tabs showcase; include tab switcher in `edit.js`. |
| 3 | `memory-care.daily-life` | `missionvilla/memory-care-daily-life` | `MemoryCareDailyLifeSection` | `memory-care-daily-life.css` (234L) / none | Daily rhythm editorial band with cards/list. |
| 4 | `memory-care.care-comfort` | `missionvilla/memory-care-care-comfort` | `MemoryCareCareComfortSection` | `memory-care-care-comfort.css` (240L) / none | Care & comfort features grid + photography. |
| 5 | `faq.featured` | `missionvilla/faq-featured` | *(Shared)* | *(Shared)* | Reuse Phase 2 block (populated with Memory Care FAQs). |
| 6 | `visit.cta` | `missionvilla/visit-cta` | *(Shared)* | *(Shared)* | Reuse Phase 2 block (`care: "memory_care"`). |

---

## Phase 6 — Page 4: Respite Care (`/respite-care`)
- **Content File:** `content/pages/respite-care.php`
- **SEO Title:** `Short-Term Respite Care in Daly City | Mission Villa`
- **Sections (8 total — 7 new + 1 shared):**

| # | Laravel Type | WP Block Slug | Schema Class | CSS / JS | Editor & Interaction Notes |
|---|---|---|---|---|---|
| 1 | `respite-care.hero` | `missionvilla/respite-care-hero` | `RespiteCareHeroSection` | `respite-care-hero.css` (315L) / none | Respite Care hero band. |
| 2 | `respite-care.scenarios` | `missionvilla/respite-care-scenarios` | `RespiteCareScenariosSection` | `respite-care-scenarios.css` (301L) / `respite-care-scenarios.js` (68L) | Interactive respite stay scenarios (tabs/cards). |
| 3 | `respite-care.inclusions` | `missionvilla/respite-care-inclusions` | `RespiteCareInclusionsSection` | `respite-care-inclusions.css` (276L) / none | Included services checklist/cards. |
| 4 | `respite-care.story` | `missionvilla/respite-care-story` | `RespiteCareStorySection` | `respite-care-story.css` (157L) / none | Editorial story / caregiver perspective band. |
| 5 | `respite-care.caregiver` | `missionvilla/respite-care-caregiver` | `RespiteCareCaregiverSection` | `respite-care-caregiver.css` (205L) / none | Caregiver relief highlights. |
| 6 | `respite-care.timeline` | `missionvilla/respite-care-timeline` | `RespiteCareTimelineSection` | `respite-care-timeline.css` (237L) / `respite-care-timeline.js` (58L) | Interactive planning timeline steps. |
| 7 | `respite-care.faq` | `missionvilla/respite-care-faq` | `RespiteCareFaqSection` | `respite-care-faq.css` (323L) / `respite-care-faq.js` (69L) | Accordion FAQ with repeater controls. |
| 8 | `visit.cta` | `missionvilla/visit-cta` | *(Shared)* | *(Shared)* | Reuse Phase 2 block (`care: "respite_care"`). |

---

## Phase 7 — Page 5: Suites & Floor Plans (`/suites-and-floor-plans`)
- **Content File:** `content/pages/suites-and-floor-plans.php`
- **SEO Title:** `Suites & Floor Plans | Mission Villa Senior Living`
- **Sections (6 total — 5 new + 1 shared):**

| # | Laravel Type | WP Block Slug | Schema Class | CSS / JS | Editor & Interaction Notes |
|---|---|---|---|---|---|
| 1 | `suites-floor-plans.hero` | `missionvilla/suites-floor-plans-hero` | `SuitesFloorPlansHeroSection` | `suites-floor-plans-hero.css` (246L) / none | Hero section. |
| 2 | `suites-floor-plans.formats` | `missionvilla/suites-floor-plans-formats` | `SuitesFloorPlansFormatsSection` | `suites-floor-plans-formats.css` (361L) / none | Private, Companion & Jack & Jill suite cards with `data-inquiry-suite` attributes. |
| 3 | `suites-floor-plans.diagram` | `missionvilla/suites-floor-plans-diagram` | `SuitesFloorPlansDiagramSection` | `suites-floor-plans-diagram.css` (296L) / none | Floor plan schematic & suite dimensions/notes; keep SVG/diagram markup intact with editable labels. |
| 4 | `suites-floor-plans.features` | `missionvilla/suites-floor-plans-features` | `SuitesFloorPlansFeaturesSection` | `suites-floor-plans-features.css` (152L) / none | Suite safety & comfort features grid. |
| 5 | `suites-floor-plans.faq` | `missionvilla/suites-floor-plans-faq` | `SuitesFloorPlansFaqSection` | `suites-floor-plans-faq.css` (214L) / `suites-floor-plans-faq.js` (42L) | Accordion FAQ. |
| 6 | `visit.cta` | `missionvilla/visit-cta` | *(Shared)* | *(Shared)* | Reuse Phase 2 block. |

---

## Phase 8 — Page 6: Life at Mission Villa (`/life-at-mission-villa`)
- **Content File:** `content/pages/life-at-mission-villa.php`
- **SEO Title:** `Life at Mission Villa | Dining, Activities & Community`
- **Sections (6 total — 5 new + 1 shared):**

| # | Laravel Type | WP Block Slug | Schema Class | CSS / JS | Editor & Interaction Notes |
|---|---|---|---|---|---|
| 1 | `life-at-mission-villa.hero` | `missionvilla/life-at-mission-villa-hero` | `LifeAtMissionVillaHeroSection` | `life-at-mission-villa-hero.css` (242L) / none | Hero section. |
| 2 | `life-at-mission-villa.pillars` | `missionvilla/life-at-mission-villa-pillars` | `LifeAtMissionVillaPillarsSection` | `life-at-mission-villa-pillars.css` (281L) / none | Community culture pillars grid. |
| 3 | `life-at-mission-villa.rhythm` | `missionvilla/life-at-mission-villa-rhythm` | `LifeAtMissionVillaRhythmSection` | `life-at-mission-villa-rhythm.css` (182L) / none | Daily rhythm / dining & social schedule. |
| 4 | `life-at-mission-villa.engagement` | `missionvilla/life-at-mission-villa-engagement` | `LifeAtMissionVillaEngagementSection` | `life-at-mission-villa-engagement.css` (205L) / none | Resident engagement cards & photos. |
| 5 | `life-at-mission-villa.faq` | `missionvilla/life-at-mission-villa-faq` | `LifeAtMissionVillaFaqSection` | `life-at-mission-villa-faq.css` (216L) / `life-at-mission-villa-faq.js` (39L) | Accordion FAQ. |
| 6 | `visit.cta` | `missionvilla/visit-cta` | *(Shared)* | *(Shared)* | Reuse Phase 2 block. |

---

## Phase 9 — Page 7: Services & Amenities (`/services-and-amenities`)
- **Content File:** `content/pages/services-and-amenities.php`
- **SEO Title:** `Services & Amenities | Mission Villa Senior Living`
- **Sections (6 total — 5 new + 1 shared):**

| # | Laravel Type | WP Block Slug | Schema Class | CSS / JS | Editor & Interaction Notes |
|---|---|---|---|---|---|
| 1 | `services-and-amenities.hero` | `missionvilla/services-and-amenities-hero` | `ServicesAmenitiesHeroSection` | `services-and-amenities-hero.css` (608L) / none | Rich editorial hero. |
| 2 | `services-and-amenities.explorer` | `missionvilla/services-and-amenities-explorer` | `ServicesAmenitiesExplorerSection` | `services-and-amenities-explorer.css` (534L) / `services-and-amenities-explorer.js` (78L) | Interactive category explorer (tabs/filters). Include category tab switcher in `edit.js`. |
| 3 | `services-and-amenities.diptych` | `missionvilla/services-and-amenities-diptych` | `ServicesAmenitiesDiptychSection` | `services-and-amenities-diptych.css` (321L) / none | Two-panel photo & editorial diptych. |
| 4 | `services-and-amenities.disclosures` | `missionvilla/services-and-amenities-disclosures` | `ServicesAmenitiesDisclosuresSection` | `services-and-amenities-disclosures.css` (269L) / none | Transparent care/amenity disclosures band. |
| 5 | `services-and-amenities.care-bridge` | `missionvilla/services-and-amenities-care-bridge` | `ServicesAmenitiesCareBridgeSection` | `services-and-amenities-care-bridge.css` (209L) / none | Bridge CTA band linking to care pages & inquiry modal. |
| 6 | `visit.cta` | `missionvilla/visit-cta` | *(Shared)* | *(Shared)* | Reuse Phase 2 block. |

---

## Phase 10 — Page 8: Gallery (`/gallery`)
- **Content File:** `content/pages/gallery.php`
- **SEO Title:** `Photo Gallery | Mission Villa Senior Living in Daly City`
- **Sections (5 total — 4 new + 1 shared):**

| # | Laravel Type | WP Block Slug | Schema Class | CSS / JS | Editor & Interaction Notes |
|---|---|---|---|---|---|
| 1 | `gallery.hero` | `missionvilla/gallery-hero` | `GalleryHeroSection` | `gallery-hero.css` (422L) / none | Gallery hero band. |
| 2 | `gallery.masonry` | `missionvilla/gallery-masonry` | `GalleryMasonrySection` | `gallery-masonry.css` (578L) / `gallery-masonry.js` (153L) | Interactive category filter + masonry grid + lightbox modal. Editor supports adding/reordering photos via WP Media Library, setting category tag, caption, alt, and provenance (`facility` vs `illustrative`). |
| 3 | `gallery.virtual-tour` | `missionvilla/gallery-virtual-tour` | `GalleryVirtualTourSection` | `gallery-virtual-tour.css` (436L) / none | Virtual tour preview & visit CTA band. |
| 4 | `gallery.pathways` | `missionvilla/gallery-pathways` | `GalleryPathwaysSection` | `gallery-pathways.css` (162L) / none | Related pages navigation cards. |
| 5 | `visit.cta` | `missionvilla/visit-cta` | *(Shared)* | *(Shared)* | Reuse Phase 2 block. |

---

## Phase 11 — Page 9: About (`/about`)
- **Content File:** `content/pages/about.php`
- **SEO Title:** `About Mission Villa Senior Living | Daly City, CA`
- **Sections (6 total — 5 new + 1 shared):**

| # | Laravel Type | WP Block Slug | Schema Class | CSS / JS | Editor & Interaction Notes |
|---|---|---|---|---|---|
| 1 | `about.hero` | `missionvilla/about-hero` | `AboutHeroSection` | `about-hero.css` (688L) / none | Editorial About hero. |
| 2 | `about.philosophy` | `missionvilla/about-philosophy` | `AboutPhilosophySection` | `about-philosophy.css` (473L) / `about-philosophy.js` (59L) | Interactive philosophy chapters/cards. |
| 3 | `about.geography` | `missionvilla/about-geography` | `AboutGeographySection` | `about-geography.css` (466L) / `about-geography.js` (73L) | Daly City / Peninsula neighborhood interactive map/landmarks band. |
| 4 | `about.core-values` | `missionvilla/about-core-values` | `AboutCoreValuesSection` | `about-core-values.css` (215L) / none | Core values cards. |
| 5 | `about.team-commitment` | `missionvilla/about-team-commitment` | `AboutTeamCommitmentSection` | `about-team-commitment.css` (435L) / `about-team-commitment.js` (36L) | Team commitment interactive section. |
| 6 | `visit.cta` | `missionvilla/visit-cta` | *(Shared)* | *(Shared)* | Reuse Phase 2 block. |

---

## Phase 12 — Page 10: For Families (`/for-families`)
- **Content File:** `content/pages/for-families.php`
- **SEO Title:** `For Families | Questions About Care at Mission Villa`
- **Sections (7 total — 6 new + 1 shared):**

| # | Laravel Type | WP Block Slug | Schema Class | CSS / JS | Editor & Interaction Notes |
|---|---|---|---|---|---|
| 1 | `for-families.hero` | `missionvilla/for-families-hero` | `ForFamiliesHeroSection` | `for-families-hero.css` (291L) / none | Hero section. |
| 2 | `for-families.decision-guide` | `missionvilla/for-families-decision-guide` | `ForFamiliesDecisionGuideSection` | `for-families-decision-guide.css` (596L) / `for-families-decision-guide.js` (36L) | Interactive family decision guide tabs/stages. |
| 3 | `for-families.checklist` | `missionvilla/for-families-checklist` | `ForFamiliesChecklistSection` | `for-families-checklist.css` (320L) / `for-families-checklist.js` (112L) | Interactive visit questions checklist (checkable items / print / copy state). |
| 4 | `for-families.involvement` | `missionvilla/for-families-involvement` | `ForFamiliesInvolvementSection` | `for-families-involvement.css` (407L) / `for-families-involvement.js` (56L) | Interactive family partnership & communication rhythm. |
| 5 | `for-families.faq` | `missionvilla/for-families-faq` | `ForFamiliesFaqSection` | `for-families-faq.css` (452L) / `for-families-faq.js` (192L) | Categorized / searchable accordion FAQ. |
| 6 | `for-families.bridge` | `missionvilla/for-families-bridge` | `ForFamiliesBridgeSection` | `for-families-bridge.css` (190L) / none | Next-steps pathway band. |
| 7 | `visit.cta` | `missionvilla/visit-cta` | *(Shared)* | *(Shared)* | Reuse Phase 2 block. |

---

## Phase 13 — Page 11: Financial Planning (`/financial-planning`)
- **Content File:** `content/pages/financial-planning.php`
- **SEO Title:** `Memory Care & Respite Care Costs | Mission Villa`
- **Sections (7 total — 6 new + 1 shared):**

| # | Laravel Type | WP Block Slug | Schema Class | CSS / JS | Editor & Interaction Notes |
|---|---|---|---|---|---|
| 1 | `financial-planning.hero` | `missionvilla/financial-planning-hero` | `FinancialPlanningHeroSection` | `financial-planning-hero.css` (287L) / none | Hero section. |
| 2 | `financial-planning.factors` | `missionvilla/financial-planning-factors` | `FinancialPlanningFactorsSection` | `financial-planning-factors.css` (239L) / none | Cost factors editorial cards. |
| 3 | `financial-planning.inclusions` | `missionvilla/financial-planning-inclusions` | `FinancialPlanningInclusionsSection` | `financial-planning-inclusions.css` (262L) / `financial-planning-inclusions.js` (42L) | Interactive inclusions breakdown. |
| 4 | `financial-planning.worksheet` | `missionvilla/financial-planning-worksheet` | `FinancialPlanningWorksheetSection` | `financial-planning-worksheet.css` (634L) / `financial-planning-worksheet.js` (168L) | Interactive family cost-comparison worksheet (JS calculations, zero fabricated Mission Villa pricing). Editor allows editing line-item labels, hints, and notes. |
| 5 | `financial-planning.pathways` | `missionvilla/financial-planning-pathways` | `FinancialPlanningPathwaysSection` | `financial-planning-pathways.css` (221L) / none | Funding pathways (long-term care insurance, VA Aid & Attendance, etc.). |
| 6 | `financial-planning.faq` | `missionvilla/financial-planning-faq` | `FinancialPlanningFaqSection` | `financial-planning-faq.css` (202L) / `financial-planning-faq.js` (57L) | Accordion FAQ. |
| 7 | `visit.cta` | `missionvilla/visit-cta` | *(Shared)* | *(Shared)* | Reuse Phase 2 block. |

---

## Phase 14 — Page 12: Resources (`/resources`)
- **Content File:** `content/pages/resources.php`
- **SEO Title:** `Family Resources | Mission Villa Senior Living`
- **Sections (6 total — 5 new + 1 shared):**

| # | Laravel Type | WP Block Slug | Schema Class | CSS / JS | Editor & Interaction Notes |
|---|---|---|---|---|---|
| 1 | `resources.hero` | `missionvilla/resources-hero` | `ResourcesHeroSection` | `resources-hero.css` (469L) / none | Hero section. |
| 2 | `resources.desk` | `missionvilla/resources-desk` | `ResourcesDeskSection` | `resources-desk.css` (577L) / `resources-desk.js` (127L) | Interactive resource desk / topic filter. |
| 3 | `resources.packet` | `missionvilla/resources-packet` | `ResourcesPacketSection` | `resources-packet.css` (407L) / `resources-packet.js` (92L) | Interactive planning packet builder / preview. |
| 4 | `resources.blog` | `missionvilla/resources-blog` | `ResourcesBlogSection` | `resources-blog.css` (463L) / `resources-blog.js` (30L) | Editorial guides & articles preview (keeps exact static/curated cards editable in Gutenberg; optionally extensible to WP Posts later). |
| 5 | `resources.faq` | `missionvilla/resources-faq` | `ResourcesFaqSection` | `resources-faq.css` (324L) / `resources-faq.js` (99L) | Accordion FAQ. |
| 6 | `visit.cta` | `missionvilla/visit-cta` | *(Shared)* | *(Shared)* | Reuse Phase 2 block. |

---

## Phase 15 — Page 13: Contact (`/contact`)
- **Content File:** `content/pages/contact.php`
- **SEO Title:** `Contact & Schedule a Visit | Mission Villa Senior Living`
- **Sections (7 total — 6 new + 1 shared):**

| # | Laravel Type | WP Block Slug | Schema Class | CSS / JS | Editor & Interaction Notes |
|---|---|---|---|---|---|
| 1 | `contact.hero` | `missionvilla/contact-hero` | `ContactHeroSection` | `contact-hero.css` (580L) / none | Contact hero with direct phone/visit actions. |
| 2 | `contact.studio` | `missionvilla/contact-studio` | `ContactStudioSection` | `contact-studio.css` (860L) / `contact-studio.js` (282L) | Largest interactive contact/visit planner studio (386L Blade, 860L CSS, 282L JS). Ensure all interactive tabs/options & `data-inquiry` hooks match 1-to-1. |
| 3 | `contact.directions` | `missionvilla/contact-directions` | `ContactDirectionsSection` | `contact-directions.css` (647L) / `contact-directions.js` (114L) | Interactive directions, landmarks, BART/highway routes, and parking details. |
| 4 | `contact.workflow` | `missionvilla/contact-workflow` | `ContactWorkflowSection` | `contact-workflow.css` (385L) / `contact-workflow.js` (31L) | What happens when you reach out (step-by-step workflow). |
| 5 | `contact.referral` | `missionvilla/contact-referral` | `ContactReferralSection` | `contact-referral.css` (322L) / `contact-referral.js` (86L) | Healthcare professional / discharge planner referral path. |
| 6 | `contact.faq` | `missionvilla/contact-faq` | `ContactFaqSection` | `contact-faq.css` (460L) / `contact-faq.js` (139L) | Accordion FAQ. |
| 7 | `visit.cta` | `missionvilla/visit-cta` | *(Shared)* | *(Shared)* | Reuse Phase 2 block. |
