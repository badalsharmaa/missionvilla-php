# Next Session

_Written 2026-11-09 at the end of Phase 1; updated the same day after Sections 03, 04 and 05–07 + footer._

## Current state

- **PHP homepage: all sections implemented.** Opening shutters → 01 cinematic hero → 02 Care Options →
  03 Life at Mission Villa (**films pending**) → 04 Why Families → **05 Suites & Living Spaces** →
  **06 Questions Families Often Ask** → **07 Come See Mission Villa** → **global footer**. Plus a **shared inquiry form**
  (Schedule a Visit · Request Pricing · Request a Call) behind `POST /inquiries`. 118 automated tests pass.
  Nothing is production-ready yet (see the readiness table in `SECTION_STATUS.md`).
- **Branches:** `feat/php-foundation-hero` @ `d160d21` → `feat/section-04-why-families` @ `b22d825` →
  **`feat/sections-05-07-footer`** (Sections 05–07, footer, inquiry form; branched from `b22d825`). Each is a
  fast-forward of the previous one. Merge order when approved: 04, then 05–07. No remote exists.
- **Leads:** requests from the inquiry form are stored (contact encrypted) in `lead_submissions` with
  status `received`. They are **not delivered anywhere**, and the visitor is told "saved, not yet sent". No email is sent.
  The homepage's Schedule a Visit buttons still open the hero’s "nothing was sent" demo dialog (decision 1e).
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
1e. **Visit dialog unification.** The hero's visit dialog is still the approved "nothing was sent" demo, while
   pricing/callback requests are stored. Recommended: point `window.MissionVilla.openVisit` at the shared form
   (`openInquiry('schedule_visit')`). That is a one-line change, but it alters approved Section 01 behaviour, so approve it first.
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

1. Client review of Sections 05–07 + footer. Then merge `feat/section-04-why-families` and `feat/sections-05-07-footer`.
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

## Not verified this session (Sections 05–07 + footer)

- Real iOS/Android devices, screen readers, Safari rendering of `<dialog>` and `:has()`.
- Synergy Hub delivery and email (not built by design).

## Not verified (earlier sessions)

- `prefers-reduced-motion` behaviour in a browser (logic ported unchanged).
- Real iOS/Android devices. Mobile was checked in same-origin iframes at 320–414px, because
  the browser window could not be resized reliably.
- React production build (`next build`) was not run, to avoid disturbing the running dev
  server's `.next` cache. The dev server returned HTTP 200.
