# Mission Villa Senior Living — PHP Website

Production-destination website for Mission Villa Senior Living (Daly City, CA):
a Laravel 13 application with reusable, validated section components and a
CMS-ready content model.

> **React is the reference. PHP is the destination.** The React/Next.js app in
> `../missionvilla-ui-new` is a design reference only. Every newly approved
> section is implemented here, never in React first. See
> [`docs/SECTION_STATUS.md`](docs/SECTION_STATUS.md).

## Local previews

| Site | URL | Start command |
|---|---|---|
| React design reference | http://localhost:3000 | `cd ../missionvilla-ui-new && npx next dev -p 3000` |
| **PHP website** | http://127.0.0.1:8010 | `php artisan serve --host=127.0.0.1 --port=8010` |

## Requirements

- PHP **8.3+** (Laravel 13), extensions: `pdo_mysql`, `mbstring`, `openssl`, `intl`, `fileinfo`, `gd`
- Composer 2, Node 20+ / npm
- Docker (local MariaDB only), or any MySQL 8 / MariaDB 10.6+ database

## First-time setup

```bash
composer install
npm install
cp .env.example .env            # then set DB_PASSWORD (local default: see docker-compose.yml)
php artisan key:generate
docker compose up -d            # local MariaDB 11.4 on 127.0.0.1:3307 (dev only)
php artisan migrate
npm run build                   # or `npm run dev` for hot reload while editing CSS/JS
php artisan serve --host=127.0.0.1 --port=8010
```

Tests use a separate database, `missionvilla_test`, in the same container:

```bash
docker exec missionvilla-php-db mariadb -uroot -p"$DB_ROOT_PASSWORD" \
  -e "CREATE DATABASE IF NOT EXISTS missionvilla_test; GRANT ALL ON missionvilla_test.* TO 'missionvilla'@'%';"
php artisan test
```

## Frontend assets

- Vite + Tailwind CSS v4 (`resources/css`, `resources/js`), built to `public/build/` (git-ignored).
- Global bundle: `resources/css/app.css` (tokens, base, header) + `resources/js/app.js` (header).
- Section bundles load only on pages that include the section, e.g.
  `resources/css/sections/hero-cinematic.css` + `resources/js/sections/hero-cinematic.js`.
- GSAP is installed from npm (pinned to `3.12.5`, the version the approved prototype used) and bundled locally.
- Hero photography lives in `public/images/hero/` as optimised WebP (2000px desktop, 1200px mobile).
- Fonts: Newsreader + Plus Jakarta Sans from Google Fonts (same request as the approved prototype).

Production hosting cannot run Node, so `npm run build` happens before deployment and
`public/build/` ships as a build artifact.

## Project layout

```
app/Content/                 Content model: SectionRegistry, section schemas, repositories, InlineText
app/Content/Sections/        One schema class per approved section (fields + layout-protecting limits)
app/Integrations/Leads/      Lead outbox + destination adapter boundary (Synergy Hub later)
app/Integrations/Concierge/  Care Guide / Hiraya Bridge boundary (interface only)
app/Models/                  Page, PageSection, SectionRevision, MediaAsset, AuditLog, LeadSubmission, User (roles)
config/missionvilla.php      Verified business facts (NAP, phone, license) + content source switch
config/navigation.php        Primary navigation (mirrors the React header)
content/pages/home.php       Phase 1 homepage content (git-reviewed), validated before render
resources/views/components/  layouts/site (document shell), site/header (global header)
resources/views/sections/    One folder per approved section component
resources/views/pages/page   Generic renderer: outputs enabled sections in order
docs/                        Architecture, section status, integration plan, next session
```

## Adding an approved section (the permanent workflow)

1. Section is approved (`docs/SECTION_STATUS.md` → *Approved*).
2. Create `app/Content/Sections/<Name>Section.php` implementing `SectionSchema`.
3. Create `resources/views/sections/<name>/index.blade.php` (+ optional section CSS/JS bundle, added to `vite.config.js`).
4. Register the schema in `AppServiceProvider::register()`.
5. Append the section to `content/pages/<page>.php`.
6. Validate desktop, mobile, interactions, accessibility and prior sections. Add or extend tests.
7. Commit, and update `docs/SECTION_STATUS.md`.

## Safety

- **No deployment is configured.** See `.deploy-policy.yml`. Nothing in this repo authorises a deploy.
- Never commit `.env`. Secrets (DB, Synergy Hub tokens) live only in server-side environment config.
- The live site (missionvilla.hiraya.digital) is a static deployment from the parent project. It is unaffected by this app.
