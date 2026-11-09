# Next Session

_Written 2026-11-09 at the end of Phase 1._

## Current state

- **PHP site:** Laravel 13 app with a global transparent header and the approved cinematic hero. The
  homepage has no other sections, by design. 18 automated tests pass.
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

1. **Next homepage section.** Review React's Care Options section and decide keep / modify / redesign.
2. **Header utility ribbon.** React has a top ribbon (address, license, Text Comfort A/A+/A++ size
   control). Phase 1 omitted it because the hero already shows address and license in its chapter
   bar. Should the Text Comfort control return, and where?
3. **Header CTA style.** The ivory "Schedule a Visit" button was chosen to stand apart from the hero's
   terracotta CTA. Approve or adjust.
4. **Admin UI.** Approve Filament as the CMS admin framework (recommended), or choose an alternative.
5. **Hosting target.** Confirm Hostinger plan, PHP version (≥ 8.3 required), and whether the domain
   document root can point at `public/`.
6. **Fonts.** Self-host Newsreader and Plus Jakarta Sans (privacy and performance), or keep Google Fonts.
7. **Imagery.** Replace illustrative Pexels hero photos with verified facility photography when available.

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
