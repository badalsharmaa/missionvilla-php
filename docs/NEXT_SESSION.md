# Next Session

_Written 2026-11-09 at the end of Phase 1; updated the same day after Section 03 and Section 04._

## Current state

- **PHP site:** Laravel 13 app with the opening conservatory-shutter scene, a global transparent
  header, the approved cinematic hero, **Section 02 · Care Options** (two flip cards) and
  **Section 03 · Life at Mission Villa** (three-chapter video gallery, added 2026-11-09, films
  pending) and **Section 04 · Why Families Choose Mission Villa** (courtyard composition, At a
  Glance panel, values strip; added 2026-11-09, replaces React's ApproachAndLifeSection).
  The homepage has no other sections, by design. 71 automated tests pass.
- **Branch:** Section 04 was built on `feat/section-04-why-families` (branched from
  `feat/php-foundation-hero` @ `d160d21`). Merge it back (fast-forward) when approved.
- **Section 03 films: STILL PENDING.** Produced by a separate Motion Studio session against
  `docs/SECTION_03_VIDEO_CONTRACT.md`. Check a delivery with `php artisan missionvilla:life-media`.
  Section 04's "Take a Quick Tour" reads "Films in production" until the manifest has a playable
  film, then drops the note automatically (no code change).
- **React reference:** untouched (`feat/mission-villa-v1-baseline` @ `82a9d23`, clean). Served on :3000.
- **Database:** local MariaDB 11.4 container `missionvilla-php-db` on 127.0.0.1:3307. Migrations applied.
- **Deployment:** none. No production target defined (`.deploy-policy.yml`).

## Start-up checklist

```bash
cd missionvilla-php
docker compose up -d
php artisan serve --host=127.0.0.1 --port=8010     # PHP site
(cd ../missionvilla-ui-new && npx next dev -p 3000) # React reference
npm run build   # after any CSS/JS change (or keep `npm run dev` running)
php artisan test
```

## Decisions needed from the client/agency

1. **Next homepage section.** Review React's `ApproachAndLifeSection` and decide keep / modify / redesign.
   Done: Care Options, Life at Mission Villa, Why Families (see `SECTION_STATUS.md`). Next candidates:
   React `SuitesAndFamilySection`, then `VisitAndFooterSection` (footer).
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

1. Implement the next approved homepage section (workflow in `README.md`).
2. Admin foundation: Filament install, login with rate limiting, admin/editor roles, a
   `missionvilla:create-admin` command, audit-log hooks.
3. Content import: `php artisan missionvilla:import-content` (file → `pages`/`page_sections`),
   then switch `CONTENT_SOURCE=database` once editing UI and preview exist.
4. Draft/preview/publish service with revisions and rollback.
5. Media library with upload validation and provenance labelling.
6. Inspect the Synergy Hub lead API, then build `SynergyHubLeadDestination` + queued delivery
   (`docs/INTEGRATION_PLAN.md`).
7. Add a Content Security Policy with nonces. Add sitemap + redirect middleware.

## Not verified this session

- `prefers-reduced-motion` behaviour in a browser (logic ported unchanged).
- Real iOS/Android devices. Mobile was checked in same-origin iframes at 320–414px, because
  the browser window could not be resized reliably.
- React production build (`next build`) was not run, to avoid disturbing the running dev
  server's `.next` cache. The dev server returned HTTP 200.
