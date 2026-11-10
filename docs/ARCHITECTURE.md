# Architecture — Mission Villa PHP Website

_Last updated: 2026-11-10 (Sections 05–07 corrected to the approved mockup; website-wide inquiry modal rule)_

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

- **Life gallery** (`life.gallery`, Section 03): the schema validates CMS copy and optional media
  overrides, then resolves media through `App\Content\Media\LifeGalleryManifest`, which reads
  `public/media/mission-villa/life-at-mission-villa/media-manifest.json` (contract:
  `docs/SECTION_03_VIDEO_CONTRACT.md`). Resolution order: CMS override → manifest → fallback still.
  A source is emitted only if its file exists on disk; an invalid manifest is logged and ignored.
  The player (`resources/js/sections/life-gallery.js`) attaches `<source>`/`<track>` only on
  Play, because Chrome downloads on `load()` even with `preload="none"`. CTA destinations that
  are not routed yet fall back to the visit dialog via `App\Support\InternalLink`.
  `php artisan missionvilla:life-media` validates a media delivery.

- **Why families** (`trust.why-families`, Section 04): a static composition. The schema enforces
  exactly 4 At a Glance facts and 4 values, whitelisted icons, per-field length caps, plain text
  everywhere except `<em>` in the heading, and site-relative/https/`#anchor` links only. The image
  declares `provenance` (`facility|illustrative`), `source_url` and `rights` (`cleared|unconfirmed`).
  These are emitted as `data-provenance`/`data-rights` on the `<figure>`. The optional tour CTA
  takes a `manifest` path: the schema asks `LifeGalleryManifest` whether any Section 03 film is
  playable and, if none is, marks the CTA `pending` (it shows `pending_note`). `primary_cta` takes an
  `intent` (form CTA → inquiry modal) or an `href`. The only script hides the tour link if its `#anchor`
  target is missing.

- **Suites & spaces** (`living.suites`, Section 05): exactly 3 options (label, icon, kicker, short caption,
  image). Each image declares `provenance`, `rights`, a visible `label`, `fit` (`cover` photo / `contain` floor
  plan) and `position`. No paragraphs or CTAs inside the photo. ARIA tabs with roving tabindex. Panels share
  one grid cell (stable frame) and inactive panels are `inert`. Up to 2 section `actions` below the composition
  (`style` primary/secondary, optional `icon`): an `intent` opens the inquiry modal (the selected suite rides
  along as `data-inquiry-suite`), an `href` is used only once `InternalLink` says the page is routed, otherwise
  `fallback_label` + `fallback_intent` (never a 404).
- **Featured FAQs** (`faq.featured`, Section 06): a structured entry list (≤40) with `order`, `enabled`,
  `featured`; the schema outputs the first 4 enabled + featured by order. Plain-text answers. Accordion
  markup is a `<button aria-expanded aria-controls>` inside an `h3` plus a `role=region` panel, all in one
  grouped card. Collapse styles apply only after JS sets `data-enhanced`, so no-JS visitors see every answer.
  Optional per-entry `actions` (≤2, label + intent) render under the answer and open the inquiry modal.
- **Final CTA** (`visit.cta`, Section 07): copy + up to 3 vertical intent actions (they open the inquiry
  MODAL, not the card beside them) + contact details from `config/missionvilla.php` + an optional inline
  inquiry card (`form.enabled|heading|lede`) that renders the shared form (`id="visit-form"`).

### Website-wide rule: form CTAs open the inquiry modal (2026-11-10)

Any CTA whose destination is a form opens the shared modal. Nothing scrolls to a form: no `href="#visit"`,
`#contact`, `#schedule-visit`, no `scrollIntoView()` to a form. Non-form anchors (e.g. "Take a Quick Tour"
→ the gallery, footer "Visit & Contact" navigation) and `tel:` links stay as they are.

- **Markup contract:** `<a href="tel:…" data-inquiry="<intent>" [data-inquiry-source="<section>"]
  [data-inquiry-suite="private|shared"] [data-inquiry-care="memory_care|respite_care|exploring"]>`. The `tel:`
  href is the no-JavaScript fallback. Source defaults to the enclosing section (header/footer detected).
- **Intents** (`config/missionvilla.php` → `inquiries.intents`, one vocabulary via `App\Support\InquiryIntents`):
  `schedule_visit` · `request_pricing` · `request_availability` · `request_callback` · `general_inquiry`, each with
  the lead `kind` stored in the outbox and the modal's title/lede/submit copy. Aliases `visit`, `pricing`,
  `availability`, `callback`, `general` are accepted in markup and content; schemas resolve them to canonical keys
  and the server only accepts canonical keys.
- **One form:** `<x-inquiry.form instance="modal|inline">` (fields, labels, hints, honesty notices, outcome view;
  ids prefixed `inq-<instance>-`). Rendered by `<x-inquiry.dialog />` (native `<dialog>`, once per page via the
  layout) and by Section 07's card. Fields: first name (required), last name (optional), phone/email (one of them;
  callback needs phone), "How can we help?" (intent select), optional marketing consent. The modal adds optional
  care / suite / time selects for the intents they apply to. No free-text field (no medical details on the site).
- **One controller:** `resources/js/components/inquiry-dialog.js` → `bindForm()` drives both instances (intent
  switching, fetch POST, 422/419/429/network errors, honest outcome, values kept on failure, idempotency key per
  opening). The modal adds open/close, focus to first field, focus restore, backdrop click, body scroll lock;
  Escape is native. API: `window.MissionVilla.openInquiry(intent, {source, suite, care})` and
  `openVisit(opts)`. The hero's visit actions call `openInquiry('schedule_visit', {source: 'hero', care})`; the
  hero's former demo dialog is removed.
- **One endpoint:** `InquiryRequest` (rules, honeypot, uuid idempotency key, `source` whitelist, attribution; no-JS
  errors redirect to `#visit-form` with old input) → `InquiryController` → `LeadIntake::accept()` (contact
  encrypted: `name`, `first_name`, `last_name`, `phone`, `email`; details: `intent`, `source`, `suite_preference`,
  `contact_time`). Throttle `inquiries` (5/min + 20/day per IP). Modes: `preview` (store off), `local` (stored, no
  destination: "saved, not sent"), `live` (destination bound: "received"). Synergy Hub delivery: see
  `docs/INTEGRATION_PLAN.md` (not built).
- **Global footer**: `<x-site.footer />` in the layout. `App\Support\FooterNavigation` validates hrefs
  (site-relative or https only) and resolves each link: routed page, else `fallback` anchor, else dropped.
- **Shared design tokens**: `resources/css/components/editorial.css` (`--mv-*`: cream, ink, terracotta, plum
  `#47243D → #3A1A31`, Section 02 type scale) used by Sections 05–07, the dialog and the footer.

## 8. Known limitations

- Short desktop viewports (< ~700px tall at ≥1024px wide): the Care Guide card sits close to the
  chapter bar. The approved prototype has the same 100svh geometry, so this was left unchanged.
- **Header** navigation links point to internal pages that are not built in PHP yet. They return Laravel's
  default 404 until each page is approved and implemented. (The footer avoids this through `FooterNavigation`.)
- The hero's modal copy (visit, concierge, chat) repeats business facts in template text. It is
  not CMS-managed yet.
- The concierge modal from the prototype is ported intact but, as in the prototype, has no visible trigger.
- Google Fonts are loaded from Google, as in the prototype. Self-hosting is a recommended follow-up.
- `php artisan serve` ignores HTTP Range requests, so seeking a Section 03 film beyond its buffered range
  snaps back locally. Production Apache/LiteSpeed supports Range.
- React's "Replay Intro" button lived in its utility ribbon, which is not ported yet. In PHP the
  intro replays on page load (and can be skipped).
