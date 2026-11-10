# Next Session

_Written 2026-11-09 at the end of Phase 1; updated 2026-11-10 after Sections 05–07 correction and the website-wide modal rule;
updated 2026-11-10 after implementing the Memory Care landing page (`/memory-care`);
updated 2026-11-10 after implementing the Short-Term Respite Care landing page (`/respite-care`)._

## Current state

- **Respite Care page (`/respite-care`) implemented on branch `feat/respite-care-php`:**
  Second complete internal page ported to Laravel according to the approved design standard (`.agents/skills/missionvilla-design-standard/`) and approved visual mockup (`Mission Villa Respite Care Website Mockup.png`).
  Includes:
  1. `respite-care.hero`: Photographic hero with dark plum gradient scrim, Newsreader 600 title, Newsreader italic 500 subtitle, body narrative, 3-column information strip (Stay Duration, Accommodations, Location), Inquire About Respite Availability CTA (`data-inquiry="request_availability"` + `care="respite_care"`), See How a Short-Term Stay Works anchor to `#respite-planning`, and direct phone link.
  2. `respite-care.scenarios`: "Support When You Need It Most" 4-scenario interactive selector with ARIA tablist/tabpanels, grid-stacked panels eliminating layout shift, verified points, and photography with provenance labels.
  3. `respite-care.inclusions`: "Comfort, Care & Everyday Support" editorial asymmetrical layout with 6 stay inclusions (Chef-Prepared Meals, Furnished Accommodations, Daily Assistance, Daily Life, Hospitality, Care Coordination) and team confirmation notice.
  4. `respite-care.story`: "A Welcoming Stay, From Start to Finish" 3-moment visual story cards (Arrival & Settling In, Shared Meals & Gentle Activity, Restful Evenings & Reassurance).
  5. `respite-care.caregiver`: "Caring for the Caregiver. Take Time to Rest." deep-plum emotional band with wave top edge, caregiver reassurance narrative, conversion actions, and 3 concept cards (Peace of Mind, Memory-Loss Familiarity, Compassionate Temporary Support).
  6. `respite-care.timeline`: "A Simple Stay-Planning Timeline" 5-step sequence (Reach Out, Care Review, Choose Dates, Prepare for Arrival, Welcome to Mission Villa) with interactive step selection on desktop and stacked mobile cards.
  7. `respite-care.faq`: "Questions Families Often Ask" 2-column layout with left Respite Stay Planning Guide card (checklist and modal inquiry action) and right 5-question accessible accordion card.
  8. `visit.cta`: "Talk With Our Respite Care Team" deep-plum closing band with 3 conversion actions and the inline cream inquiry card (`#visit-form`, with `care_interest` preselected to `respite_care`).
  Screenshots and measurements in `../docs/respite-care-2026-11-10/`. 159 automated tests pass (14 new tests).
- **Memory Care page (`/memory-care`) implemented on branch `feat/memory-care-laravel`:**
  First complete internal page ported to Laravel according to the approved design standard (`.agents/skills/missionvilla-design-standard/`).
  Includes:
  1. `memory-care.hero`: Photographic hero with dark plum gradient scrim, Newsreader 600 title, Newsreader italic 500 subtitle, body narrative, 3 verified badges, Schedule a Memory Care Visit CTA (`data-inquiry="schedule_visit"` + `care="memory_care"`), direct phone link, leaf decor.
  2. `memory-care.legacies`: "The Legacies™ Difference" 4-chapter interactive selector with ARIA tablist/tabpanels, grid-stacked panels that eliminate layout shifts, verified in-practice points, family takeaway, and photograph with provenance pill and caption.
  3. `memory-care.daily-life`: "A Day Shaped Around the Individual" 3-rhythm editorial cards (Morning, Midday, Evening) with natural photography and verified highlights.
  4. `memory-care.care-comfort`: "Care, Comfort & Home" 2-column editorial spread with 5 verified support commitments, care planning reassurance box, and large authentic facility suite photo (`/images/suites/suite-bedroom-facility-899.webp`).
  5. `faq.featured`: "Questions Families Often Ask" compact 5-question accordion using established single-open pattern and modal CTA actions.
  6. `visit.cta`: "Talk With Our Memory Care Team" deep-plum closing band with 3 conversion actions (preselecting `memory_care` in modal) and the inline cream inquiry card (`#visit-form`, with `care_interest` preselected to `memory_care`).
  Screenshots and measurements in `../docs/memory-care-2026-11-10/`. 144 automated tests pass (8 new tests).
- **PHP homepage: all sections implemented.** Opening shutters → 01 cinematic hero → 02 Care Options →
  03 Life at Mission Villa (**films pending**) → 04 Why Families → **05 Suites & Living Spaces** →
  **06 Questions Families Often Ask** → **07 Come See Mission Villa** → **global footer**. 134 automated tests pass.
  Nothing is production-ready yet (see the readiness table in `SECTION_STATUS.md`).
- **2026-11-10 correction (branch `feat/sections-05-07-modal-system`):** Sections 05–07 rebuilt to the newly approved
  tall mockup (`~/Downloads/mission_villa_suites_faqs_visits.png`) as three independent, content-height sections
  (1440×900: 75 / 53 / 85vh). **Website-wide rule:** every form CTA opens ONE shared inquiry modal with an intent
  (visit · pricing · availability · callback · general); nothing scrolls to a form. Section 07 also shows the same
  form inline. See `ARCHITECTURE.md` → "Website-wide rule". Screenshots: `../docs/sections-05-07-2026-11-10/`.
- **2026-11-10 header logo fix (same branch):** the header's HTML "MISSION VILLA" text wordmark was replaced by the
  official logo artwork: a horizontal lockup rearranged from the official PNG's own leaf, wordmark and subtitle pixels,
  with ivory ink on dark (`resources/brand/build-header-logo.py`). The footer is unchanged. The brand rule and asset map
  are in `.agents/skills/missionvilla-design-standard/references/brand-logo.md`. Screenshots: `../docs/header-logo-2026-11-10/`.
  **Client to confirm:** (a) the horizontal lockup and light (ivory/sage) recolour, since no official horizontal or
  reversed logo exists; (b) leaf-only header at 1280–1365px and ≤369px, where the full nav leaves no room;
  (c) ask for vector (SVG/AI/EPS) logo files, because the master is a 1342px raster with a slightly rough edge halo.
- **2026-11-10 sticky header (same branch):** two header states. Initial: transparent over the hero, 72/88px bar,
  larger logo. Compact (after 88px of scroll): solid plum, 60/64px bar, logo ~34–38px, slightly tighter nav. The trigger
  is an IntersectionObserver sentinel (no scroll listener), with no transition under reduced motion. Documented in the
  skill (`components.md` → Header, `brand-logo.md` table). Before/after screenshots: `../docs/header-sticky-2026-11-10/`.
- **2026-11-10 site-wide gutter (same branch):** every section now aligns to the hero/header side padding
  (`--mv-gutter` = `--pad-x`: 76/72/68/38/24px at 1920/1440/1366/768/390). Care Options (was 42px), Life at Mission Villa
  (54px), the Why Families glance card (48px right) and the values strip (104rem cap) were too wide. Phones went from 20px
  to 24px. Full width, no boxed max-width wrappers. Section heights unchanged at desktop sizes. Before/after:
  `../docs/section-gutters-2026-11-10/`.
- **Branches:** `feat/php-foundation-hero` @ `d160d21` → `feat/section-04-why-families` @ `b22d825` →
  `feat/sections-05-07-footer` @ `82c5d7c` → **`feat/sections-05-07-modal-system`** (this correction). Each is a
  fast-forward of the previous one. Merge order when approved: 04, then 05–07, then the correction. No remote exists.
- **Leads:** every inquiry path (modal from any CTA, hero included, and the Section 07 inline card) posts to
  `POST /inquiries` and is stored (contact encrypted) in `lead_submissions` with status `received`. Leads are
  **not delivered anywhere**, and the visitor is told "saved, not yet sent". No email is sent. The hero's
  "nothing was sent" demo visit dialog was removed (decision 1e resolved by the 2026-11-10 brief).
- **Section 03 films: STILL PENDING.** Produced by a separate Motion Studio session against
  `docs/SECTION_03_VIDEO_CONTRACT.md`. Check a delivery with `php artisan missionvilla:life-media`.
  Section 04's "Take a Quick Tour" reads "Films in production" until the manifest has a playable
  film, then drops the note automatically (no code change).
- **React reference:** untouched (`feat/mission-villa-v1-baseline` @ `82a9d23`, clean). Served on :3000.
- **Database:** local MariaDB 11.4 container `missionvilla-php-db` on 127.0.0.1:3307. Migrations applied (no new migrations).
- **Deployment:** none. No production target defined (`.deploy-policy.yml`).
- **Untracked `AGENTS.md` / `CLAUDE.md`** in this repo ask agents to install Laravel Boost (`composer require
  laravel/boost --dev`). Not done: it adds a dependency outside the homepage milestone. Decide whether to adopt
  it, then commit or delete those files.

## Start-up checklist

**Design standard:** before porting any page or section, read `.agents/skills/missionvilla-design-standard/SKILL.md`
(the approved homepage design rules; also linked for Claude at `.claude/skills/` and as an Antigravity rule in `.agent/rules/`).

```bash
cd missionvilla-php
docker compose up -d
php artisan serve --host=127.0.0.1 --port=8010     # PHP site
(cd ../missionvilla-ui-new && npx next dev -p 3000) # React reference
npm run build   # after any CSS/JS change (or keep `npm run dev` running)
php artisan test
```

## Decisions needed from the client/agency

1. **Homepage sections: complete.** No further homepage sections are planned. Review Sections 05–07 + footer
   against the mockup (`../docs/sections-05-07-2026-11-09/`) and approve, or list adjustments.
1a. **Care Options follow-ups.** (a) Benefit wording on the Memory Care back face was taken from the
   React data, not the mockup's "dementia-informed / secure / experienced caregivers" wording, which
   has no source there. Confirm or supply verified claims. (b) The Respite back face was designed to mirror the
   Memory mockup (no mockup existed). (c) A small corner toggle (+/×) was added for keyboard and touch
   access; the mockups show none. (d) A quiet "Ask our Care Guide" link sits beside Schedule a Visit.
   (e) Card photos are AI-illustrative (from React); swap for facility photos when available.
   (f) "Explore" buttons link to `/memory-care` and `/respite-care`, which are not built in PHP yet
   (same as the header nav).
   (g) The referenced `mission_villa_care_options_claude_handoff.zip` (with `CLAUDE_TASK.md` and a
   botanical SVG) was not on disk, so the section was built from the two mockup PNGs and the written brief, and
   the botanical SVG was drawn locally. If the ZIP turns up, diff its SVG and task list against this build.
1b. **Life at Mission Villa follow-ups.** (a) The films themselves (contract handed off). (b) Fallback
   stills are AI-illustrative (React `illustrative/` set), labelled "Illustrative image · not actual
   residents" on the player. Authentic property photos (`bedroom`, `dining-room`, `community-lounge`)
   could replace them, but they are 899 px wide. (c) Mockup copy "Thoughtfully designed suites and inviting
   common spaces that feel like home" was replaced with verified wording (private and shared suites with private
   bathrooms, lounges). (d) Mockup CTA "Explore Our Living Spaces" is "Explore Our Suites" →
   `/suites-and-floor-plans`. Until that page exists it reads "See Our Suites in Person" and opens the
   visit dialog (same pattern for the other two chapters). (e) A visible provenance badge and a
   "Film in production" notice were added; the mockup shows neither. (f) The mockup's nav labels and
   button look like 700-weight sans. Plus Jakarta Sans is loaded at 400/500/600 only, so Section 03 uses
   600. Loading 700 site-wide would also change faux-bold text in the hero and Section 02, so it
   needs a decision. (g) Section 03 uses the mockup's deeper plum (`#380C34`), slightly more violet
   than Section 02's `#2F1228`. Align one way or the other.
1c. **Why Families (Section 04) follow-ups.** (a) **Courtyard photo rights:** the image is an
   authentic Mission Villa photo, but it was retrieved from the public PurpleDoor Finders listing
   mirror (`docs/image-sourcing-report.md`), so the content marks it `rights: unconfirmed`. Get the
   client's permission and the original full-resolution file, then set `rights` to `cleared`. The
   copy on disk is 1024×683, so it is upscaled ~1.4× on 1920px screens and looks slightly soft.
   (b) The mockup's golden-hour courtyard and hydrangeas are AI-generated and were **not** used.
   A soft-light warm wash is layered over the real daylight photo instead, and the file itself is not regraded.
   (c) Mockup copy was replaced with verified wording. "Experienced & Caring Team",
   "Safety & Peace of Mind", "An Intimate Community", "good meals" and "experienced team" had no
   verified source, so the brief's facts/values were used. (d) The brief numbers the facts 01–04; the
   build follows the mockup's icons instead of numerals. (e) Added a small "Our courtyard patio ·
   Daly City" caption pill (not in the mockup) as an authenticity cue. Remove it via `image.caption`
   if unwanted. (f) "Take a Quick Tour" anchors to the Section 03 gallery with a "Films in
   production" note. Confirm this, or hide the CTA until films exist. (g) Overlay layout starts at
   1200px. 1024–1199px uses the stacked tablet layout. (h) Strip plum is the mockup's warmer
   `#47243D → #3A1A31`. Section 02 uses `#2F1228` and Section 03 `#380C34`. Unify in one pass with 1b(g).
1d. **Sections 05–07 + footer follow-ups.**
   (a) **Image rights:** the bedroom and lounge photos are authentic but came from the Caring.com listing mirror,
   and the companion floor plan from missionvillaseniorliving.com. All are marked `rights: unconfirmed`. Get
   permission and full-resolution originals. The copies are 899–1000px wide, so they are upscaled on large screens.
   (b) The bedroom photo shows one bed but is **not confirmed** to be a private suite. It is labelled
   "Mission Villa photo", not "private suite". No real shared-suite photo exists, so the official companion floor
   plan stands in. (c) Mockup's bedroom, hydrangeas and golden-hour styling are AI-generated and were not used.
   (d) Mockup CTA "View Suite & Floor Plans" appears once `/suites-and-floor-plans` exists. Until then it reads
   "Ask About Private/Shared Suites" (pricing form, suite preselected) or "See Our Spaces in Person" (visit
   dialog). (e) FAQ answers are condensed from React copy. The mockup's "secure environment" wording for Memory
   Care had no source and was not used. "View All FAQs" stays hidden until `/for-families` exists. (f) React's
   marketing email address and "Equal Housing Opportunity" line are not shown: neither is in the verified facts
   (`config/missionvilla.php`). Confirm and add them there if wanted. (g) Privacy Policy and Accessibility Statement
   links are configured but hidden until real pages exist. **Needed before launch**, especially with a lead form.
   (h) The footer has no mockup. Its look extends the Section 07 plum. Approve or supply a design.
   (i) The Section 07 title is set a step below section titles (max 48px vs 76px) so the mockup's single-row band
   fits. The single-row layout starts at 1600px wide; narrower desktops use two rows. (j) The Section 05 text
   column is wider than in the mockup, so the shared title size fits on two lines.
   _Update 2026-11-10:_ (d), (i) and (j) are superseded by the corrected layout (1g).
1e. ~~Visit dialog unification~~ **Done 2026-11-10** (the brief requires one shared modal): every Schedule a Visit,
   including the hero's button, Care Guide and concierge hand-offs, opens the shared inquiry modal. The hero passes
   the chapter's care type (Memory Care / Respite) or the concierge outcome as "Care of interest".
1g. **Sections 05–07 correction follow-ups (2026-11-10).** Review these against the mockup:
   (a) **Floor plans:** no floor-plan page exists, so the mockup's "View Suite & Floor Plans" reads
   **"Request Suite Floor Plans"** and opens the availability modal. It becomes the real link automatically once
   `/suites-and-floor-plans` is routed. (b) "Request Availability & Pricing" opens the pricing modal with the selected
   suite preselected (private/shared; nothing for Community Spaces). (c) The small provenance label ("Mission Villa
   photo" / "Companion suite floor plan") stays on the photo although the mockup has none (honesty rule).
   (d) The per-suite detail paragraph and in-photo CTA were removed (brief: no paragraphs in the image).
   (e) **Form fields:** mockup marks First, Last, Phone and Email all required. Built: first name required, **last name
   optional**, **phone OR email** (callback needs phone), following "don't require unnecessary personal information".
   Make last name required if Synergy Hub needs it. (f) **No "Additional Details" free-text field**: kept out on
   purpose so visitors aren't invited to type medical details (existing privacy rule). The mockup doesn't show one either.
   (g) The inline card adds an optional marketing-consent box, a privacy line and a "development site" notice, which
   the mockup doesn't show. The notice disappears once a lead destination is wired. (h) Modal submit is terracotta
   (brief), inline submit plum (mockup). (i) The mockup's hydrangea photo (bottom-right of Section 07) is AI-styled
   imagery and was **not** used. The existing soft leaf silhouette remains. (j) FAQ answers gained small modal links
   (Request a Call, Ask About Availability, Request Pricing, Schedule a Visit); answer 4 now ends "…or send a request
   below…". (k) Footer "Visit & Contact" stays a navigation anchor to Section 07 (it is navigation to contact details,
   not a form CTA). Change it to a modal trigger if preferred. (l) Two new lead kinds, `availability_request` and
   `general_inquiry`, need mapping in the Synergy Hub contract.
1f. **Inquiry backend.** Before going live, decide: (a) the Synergy Hub lead contract (see `INTEGRATION_PLAN.md` §6),
   (b) who sends visitor confirmation and staff notification emails, (c) the retention period for stored leads,
   (d) the consent wording (version `inquiry-consent-2026-11-09`). Do not collect real leads in production until
   delivery and staff alerting exist.
2. **Header utility ribbon.** React has a top ribbon (address, license, Text Comfort A/A+/A++ size
   control, and the **Replay Intro** button). Phase 1 omitted it because the hero already shows address and license in its chapter
   bar. Should the Text Comfort control return, and where?
3. **Header CTA style.** The ivory "Schedule a Visit" button was chosen to stand apart from the hero's
   terracotta CTA. Approve or adjust.
4. **Admin UI.** Approve Filament as the CMS admin framework (recommended), or choose an alternative.
5. **Hosting target.** Confirm Hostinger plan, PHP version (≥ 8.3 required), and whether the domain
   document root can point at `public/`.
6. **Skip Intro on small phones.** The centred pill overlaps the shutter footer lines at ≤390px
   (inherited from React). Keep it, or nudge it on phones?
7. **Fonts.** Self-host Newsreader and Plus Jakarta Sans (privacy and performance), or keep Google Fonts.
8. **Imagery.** Replace illustrative Pexels hero photos with verified facility photography when available.

## Recommended next engineering steps (in order)

1. Client review of the corrected Sections 05–07 (+ footer) and the modal system. Then merge
   `feat/section-04-why-families`, `feat/sections-05-07-footer` and `feat/sections-05-07-modal-system`.
1a. Privacy policy + accessibility statement pages (footer links appear automatically once routed).
2. Admin foundation: Filament install, login with rate limiting, admin/editor roles, a
   `missionvilla:create-admin` command, audit-log hooks.
3. Content import: `php artisan missionvilla:import-content` (file → `pages`/`page_sections`),
   then switch `CONTENT_SOURCE=database` once editing UI and preview exist.
4. Draft/preview/publish service with revisions and rollback.
5. Media library with upload validation and provenance labelling.
6. Inspect the Synergy Hub lead API, then build `SynergyHubLeadDestination` + queued delivery
   (`docs/INTEGRATION_PLAN.md`).
7. Add a Content Security Policy with nonces. Add sitemap + redirect middleware.

## Not verified this session (2026-11-10 correction)

- Verified in headless Chrome: all 16 form CTAs plus the hero button open the modal with the right heading/intent/source
  and never scroll; Escape closes, focus returns to the opener, body scroll unlocks; server validation errors are
  shown and focused; real submissions (modal + inline) report "saved, not yet sent"; suite tabs (click + keyboard),
  stable frame height; accordion (one open, keyboard); no duplicate ids or nested forms; no horizontal overflow at
  1920/1440/1366/1280/1024/768/430/390/375/320; mobile modal scrolls inside the viewport; hero slider and
  Section 03 tabs still work. No-JS round trip (errors + kept input) checked with curl.
- Not verified: real iOS/Android devices, screen readers (VoiceOver/NVDA announcement of the dialog and errors),
  Safari/Firefox rendering of `<dialog>` and CSS masks, reduced-motion in a browser.
- Synergy Hub delivery and email (not built by design).

## Not verified (2026-11-09: Sections 05–07 + footer)

- Real iOS/Android devices, screen readers, Safari rendering of `<dialog>` and `:has()`.

## Not verified (earlier sessions)

- `prefers-reduced-motion` behaviour in a browser (logic ported unchanged).
- Real iOS/Android devices. Mobile was checked in same-origin iframes at 320–414px, because
  the browser window could not be resized reliably.
- React production build (`next build`) was not run, to avoid disturbing the running dev
  server's `.next` cache. The dev server returned HTTP 200.
