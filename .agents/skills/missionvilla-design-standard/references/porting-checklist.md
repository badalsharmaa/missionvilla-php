# Porting a page or section: workflow and done-checklist

## Workflow (one section at a time)
1. **Orient.**
   - Read `docs/NEXT_SESSION.md`, `docs/SECTION_STATUS.md` and `docs/ARCHITECTURE.md`.
   - Run `git status`, check the branch and recent commits. Preserve uncommitted work.
   - Never assume `main` is production.
2. **Reference.**
   - Open the React reference (`http://localhost:3000`, read-only, `missionvilla-ui-new`) and/or the approved mockup.
   - The user reviews and decides keep / modify / redesign. **List every reference element you will not port, and ask.**
3. **Map onto the standard.** Pick the homepage pattern that fits (`sections.md`) and reuse its components
   (`components.md`) and tokens (`tokens.md`). Only new mockups introduce new patterns.
4. **Implement** (Laravel, `missionvilla-php`):
   - Schema `app/Content/Sections/<Name>Section.php` (`SectionSchema`: `type()`, `label()`, `view()`, `normalize()`
     with strict `Validator` rules, length limits that protect the layout, `InlineText::plain/sanitize`,
     provenance/rights on images, `intent` or `href`+fallback for CTAs).
   - View `resources/views/sections/<name>/index.blade.php`, with assets pushed via `@push('section-assets') @vite([...])`.
   - CSS/JS in `resources/css/sections/<name>.css` and `resources/js/sections/<name>.js` (add them to `vite.config.js`).
   - Register in `AppServiceProvider`. Add content to `content/pages/<slug>.php` (verified copy only).
   - Route the page in `routes/web.php` once approved. Header/footer links switch to it automatically.
   - Run `npm run build` after CSS/JS changes.
5. **Verify** (below). Fix what you find. Then update `docs/SECTION_STATUS.md` (status + validation log) and
   `docs/NEXT_SESSION.md` (decisions/deviations for the client).
6. **Commit** on a feature branch that fast-forwards the previous one. **Do not deploy.**

## Done-checklist (all must pass)
- [ ] **Type:** computed font sizes match Section 02's scale (diff them at 1920×1080 and 1440×900). No size copied from a mockup.
- [ ] **Colour:** only `--mv-*` (or hero tokens inside a hero). No new hex values without a reason.
- [ ] **Layout** at 1920×1080, 1440×900, 1366×768, 1280×720, 1024, 768, 430, 390, 375, 320:
  - no horizontal overflow; nothing cramped or stretched;
  - no forced `100vh` on content sections;
  - section boundaries are clear.
- [ ] **Forms:** every form CTA has `data-inquiry` + `tel:` href and opens the modal with the right title and intent.
  Nothing scrolls to a form. Escape closes, focus returns, scroll unlocks. No duplicate ids, no nested forms.
- [ ] **Honesty:** every image has provenance + rights and a visible label. No fabricated facts, prices,
  availability or claims. Unrouted links fall back to an inquiry, never a 404.
- [ ] **Accessibility:**
  - tabs/accordion keyboard patterns work, focus rings are visible, tap targets ≥44px;
  - `alt` text is real (decor `aria-hidden`); headings are in order;
  - without JS, content is visible and CTAs fall back to `tel:`.
- [ ] **Motion:** user-initiated only; reduced motion makes it instant.
- [ ] **No regressions:** the hero slider, Care Options flip, Section 03 player/tabs, header, footer and inquiry
  submission still work.
- [ ] **Gutter alignment:** at 1920/1440/1366/768/390, the leftmost and rightmost content of every section (cards,
  titles, panels) sit exactly on the header logo's x and its mirror (`--pad-x`: 76/72/68/38/24px). No boxed max-width wrappers.
- [ ] `php artisan test` passes, with new tests for the schema (rejects bad data) and rendering (intents, no form anchors).
- [ ] **Screenshots** in `../docs/<page>-<date>/`, compared with the mockup at the same aspect ratio. Never claim
  visual fidelity from compiling alone.

## Tooling that works here
- **Servers:**
  - `php artisan serve --host=127.0.0.1 --port=8010` (DB: `docker compose up -d`, MariaDB on 3307).
  - React reference: `cd ../missionvilla-ui-new && npx next dev -p 3000`.
- **Screenshots:** headless Playwright with the system Chrome (`executablePath: '/usr/bin/google-chrome'`).
  Skip the intro by clicking its skip button before measuring.
- **Throttle:** `POST /inquiries` allows 5 per minute per IP. Repeated local form tests can hit 429.
