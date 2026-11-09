# Architecture — Mission Villa PHP Website

_Last updated: 2026-11-09 (Phase 1: foundation, header, approved hero)_

## 1. Two-site model

| | React reference (`../missionvilla-ui-new`) | PHP website (this repo) |
|---|---|---|
| Role | Design reference: existing sections, imagery, copy, interactions | Production destination |
| Changes | None. Never modified when sections are approved for PHP | Every approved section is implemented here |
| Runtime | Next.js dev server, port 3000 | Laravel, port 8010 (dev) |
| Git | Own repo, `Promotix21/missionvilla-ui-new` | Own repo (local, no remote yet) |

## 2. Why Laravel

**Hosting constraints found:** the existing Mission Villa site runs on Hostinger shared hosting
(SSH and PHP available, MySQL/MariaDB available, no Node runtime assumed). The full CMS vision
needs authentication, RBAC, CSRF, secure sessions, validation, migrations, queues for lead
delivery retries, encryption and audit logging.

Laravel provides all of these as maintained, documented framework features. A custom framework
would mean rebuilding and maintaining security-critical code. Laravel runs on Hostinger shared
hosting when the domain document root points at `public/`.

| Decision | Choice | Reason |
|---|---|---|
| Framework | Laravel 13 (PHP ≥ 8.3) | Established security primitives, migrations, queues, validation |
| Database | MySQL/MariaDB (local: MariaDB 11.4 in Docker on :3307) | Matches Hostinger. Local PHP has no `pdo_sqlite` |
| Templates | Blade components, one view per section | Server-rendered HTML for SEO and fast first paint |
| CSS | Tailwind v4 via Vite + verbatim section CSS | Same Tailwind major as the approved prototype's compiled CSS |
| JS | Vanilla ES modules, per-section bundles, GSAP from npm | No React in production. Hero JS loads only where the hero renders |
| Admin UI | **Not built yet.** Recommended: Filament (Laravel admin) | See §6 and open decisions |

## 3. Request flow

```
GET /  →  PageController::home()
       →  ContentRepository::findPublishedPage('home')
            FileContentRepository      (CONTENT_SOURCE=file, default: content/pages/home.php)
            DatabaseContentRepository  (CONTENT_SOURCE=database: pages/page_sections, published data)
       →  SectionRegistry::instantiate() → SectionSchema::normalize()  (validation + sanitising)
       →  pages/page.blade.php: layout + header, then each enabled section's Blade view
```

Both repositories return the same `PageDefinition`. Content is validated through the section
schema on every read, so a bad CMS row cannot render outside the approved component limits.

## 4. Section component model

A section is three things:

1. **Schema** (`app/Content/Sections/*Section.php`, implements `SectionSchema`): editable fields,
   validation rules, and limits that protect the layout (e.g. the hero requires exactly 3 chapters
   and caps headline length to 60 chars).
2. **View** (`resources/views/sections/<name>/`): owns all markup and presentation.
3. **Optional assets** (`resources/css/sections/<name>.css`, `resources/js/sections/<name>.js`):
   pushed into the page `<head>` only when the section renders.

Editors can change approved text and media, reorder sections, and enable/disable them. They
cannot write arbitrary HTML or invent layouts. Rich text is limited to `<em>`/`<strong>`
(`App\Content\InlineText`). Every other tag and every attribute is stripped, and text is escaped.

**Image honesty guard:** every image declares `provenance: facility|illustrative`, plus an
optional source URL. Schemas reject images without provenance. The current hero images are
illustrative Pexels photographs, **not** Mission Villa facility photography.

## 5. Data model (migrated, Phase 1)

| Table | Purpose |
|---|---|
| `users` (+ `role`, `is_active`, `last_login_at`) | Admin and editor accounts |
| `pages` | Slug, title, `seo_draft` / `seo_published`, publish metadata |
| `page_sections` | Ordered section instances: `type`, `key`, `position`, `enabled`, `draft_data`, `published_data` |
| `section_revisions` | Immutable snapshots on save / publish / rollback |
| `media_assets` | Uploaded files with checksum, dimensions, alt text, provenance, credit |
| `redirects` | 301/302 management |
| `audit_logs` | Who did what to which record (no secrets or full PII payloads) |
| `lead_submissions` | Durable lead outbox (contact data encrypted at rest) |
| Laravel defaults | `sessions`, `cache`, `jobs`, `failed_jobs`, `password_reset_tokens` |

**Draft → preview → publish:** editors write `draft_data`. Preview renders drafts for
authenticated users. Publish copies draft to `published_data` and writes a `section_revisions`
row. Rollback copies a revision back into draft, then publishes. *(Tables exist; the workflow UI
and service are not built yet.)*

## 6. Administration & security

**Implemented**

- RBAC gates in `AppServiceProvider`: `edit-content`, `manage-media` (editor+); `publish-content`,
  `manage-users`, `manage-settings`, `view-leads` (admin)
- Encrypted sessions (`SESSION_ENCRYPT=true`), database session driver, Laravel CSRF middleware on web routes
- Security headers middleware: `nosniff`, `SAMEORIGIN`, referrer policy, permissions policy
- Server-side validation of all section content; sanitised inline markup
- Lead contact data encrypted at rest (`encrypted:array` cast, keyed by `APP_KEY`)
- Environment-based configuration (`.env`, never committed); `.env.example` documented

**Planned (not built)**

- Admin UI. Recommended: **Filament**, giving a client-friendly editing interface on the existing models.
  Section forms are generated from each schema's fields.
- Login with rate limiting, optional 2FA for admins, `last_login_at` and audit entries
- Media upload pipeline: MIME/extension allow-list, size and dimension limits, re-encoding to
  WebP, checksum de-duplication, EXIF stripping
- Content Security Policy header (currently blocked by Google Fonts and the inline JSON data block; needs nonces)
- Sitemap generation from published pages, redirect middleware
- Backups: nightly `mysqldump` + `storage/app` archive off-server, plus a restore runbook

## 7. Frontend notes

- The hero CSS is the prototype's custom CSS **verbatim**. Removed: unused `.aperture-*` rules and the
  developer safe-zone overlay. Global tokens and base rules moved to `app.css` unchanged.
- Hero markup was extracted programmatically from the prototype so class strings are identical.
  Inline `onclick` handlers became `data-hero-action` attributes handled by one delegated listener.
- Measured on 2026-11-09 at 1920×796: positions and sizes of pill, headline, body copy, CTA,
  Care Guide card, chapter tabs and controls are identical to the prototype. The only difference
  is a ±2px pointer-parallax offset on the card.
- The global header CTA opens the hero's visit dialog via `window.MissionVilla.openVisit`.
  On pages without the dialog, it links to `/contact#schedule-visit`.

- **Opening scene** (`intro.shutters`): a tiny pre-paint script in `<head>` adds
  `html.mv-intro-active`, unless reduced motion or `?skipIntro=1` applies, so the shutters cover
  the page from first paint with no flash. Without JavaScript the overlay never shows, and a 4s
  safety timer removes it if the intro script fails to start. The intro emits
  `missionvilla:intro-open`, and the hero waits for it before starting chapter 1's timer.
  Choreography targets on the hero are attribute-only (`data-intro-fade`, `data-intro-portal`).
  Fonts Allura and Lora italic load only with this section, matching the React reference.

## 8. Known limitations

- Short desktop viewports (< ~700px tall at ≥1024px wide): the Care Guide card sits close to the
  chapter bar. The approved prototype has the same 100svh geometry, so this was left unchanged.
- Navigation links point to internal pages that are not built in PHP yet. They return Laravel's
  default 404 until each page is approved and implemented.
- The hero's modal copy (visit, concierge, chat) repeats business facts in template text. It is
  not CMS-managed yet.
- The concierge modal from the prototype is ported intact but, as in the prototype, has no visible trigger.
- Google Fonts are loaded from Google, as in the prototype. Self-hosting is a recommended follow-up.
- React's "Replay Intro" button lived in its utility ribbon, which is not ported yet. In PHP the
  intro replays on page load (and can be skipped).
