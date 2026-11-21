# 01 — WordPress Architecture & Technical Stack
## Why Hybrid Theme + 71 Native Dynamic Gutenberg Blocks Guarantees 100% Design Fidelity

---

## 1. The Architectural Decision (Read Carefully)

Converting a bespoke editorial design system with **71 custom sections**, **47 Tailwind CSS v4 templates**, **36 interactive JS scripts**, **GSAP 3.12.5 choreography**, and a **shared `<dialog>` inquiry system** into WordPress fails if you choose the wrong architecture:

| Approach | Visual Fidelity | Native WP Editing | Verdict |
|---|---|---|---|
| **Page Builder (Elementor / Divi / Bricks)** | Drifts, heavy DOM bloat, breaks Tailwind v4 & GSAP | Non-native lock-in | **REJECTED** |
| **Core FSE Blocks Only (Group / Columns / Cover)** | Cannot preserve custom scrims, CSS masks, GSAP timelines, complex tabs/worksheets, or exact `--mv-*` tokens | Editors easily break layout spacing/margins | **REJECTED** |
| **Static PHP Page Templates + Custom Meta Boxes** | 100% visual fidelity | Clunky form-field editing, not native Block Editor | **REJECTED** |
| **Hybrid WP Theme (`theme.json` v3) + 71 Native Dynamic Gutenberg Blocks (`block.json` API v3 + `render.php` + `edit.js`)** | **100% photo-identical DOM, CSS, JS, & GSAP** | **100% native Block Editor: click-to-edit every text, image, card, FAQ, icon, and CTA intent** | **SELECTED** |

### Why This Architecture Is a 1-to-1 Mirror of the Laravel Repo

| Laravel Concept (`missionvilla-php-repo`) | Native WordPress Equivalent (`missionvilla` Theme) |
|---|---|
| `app/Content/Sections/*Section.php` (schema + defaults + validation) | `blocks/<slug>/block.json` (`attributes`, `supports`, `category: "missionvilla"`) |
| `resources/views/sections/<slug>/index.blade.php` | `blocks/<slug>/render.php` (server-rendered PHP template — **exact same HTML**) |
| `resources/css/sections/<slug>.css` | `blocks/<slug>/style.css` (auto-enqueued by WP ONLY when block is on the page!) |
| `resources/js/sections/<slug>.js` | `blocks/<slug>/view.js` (`viewScript` in `block.json` — auto-enqueued ONLY when block is on the page!) |
| Future CMS Editor (never built in Laravel) | `blocks/<slug>/edit.js` (Native Gutenberg React component using `<RichText>`, `<MediaUpload>`, `<InspectorControls>`) |
| `resources/views/components/layouts/site.blade.php` | `header.php` + `page.php` (`the_content()`) + `footer.php` |
| `config/missionvilla.php` (NAP, phone, license, inquiry config) | WordPress Options API + **Mission Villa Settings** WP Admin page (`inc/settings.php`) |
| `config/navigation.php` (Header dropdowns + descriptions + Footer columns) | Native WordPress Menus (`Appearance → Menus`) with custom `description` support + custom `MV_Header_Walker` |
| `POST /inquiries` (`InquiryController` + `lead_submissions`) | WordPress REST API `POST /wp-json/missionvilla/v1/inquiries` + `{$wpdb->prefix}mv_lead_submissions` table |
| `content/pages/*.php` (13 pages) | 13 WordPress `page` posts whose `post_content` contains native Gutenberg block comments (`<!-- wp:missionvilla/... -->`), seeded via WP-CLI |

---

## 2. Theme Directory Structure

Create the WordPress theme at `wp-content/themes/missionvilla/`:

```
wp-content/themes/missionvilla/
├── style.css                      # Theme metadata header only
├── theme.json                     # WP theme.json v3 (Mission Villa color palette, fonts, layout, disables conflicting WP defaults)
├── functions.php                  # Bootstraps all inc/*.php modules + auto-registers all 71 blocks
├── header.php                     # Exact port of layouts/site.blade.php <head> + site/header.blade.php
├── footer.php                     # Exact port of site/footer.blade.php + inquiry/dialog.blade.php + wp_footer()
├── page.php                       # Renders <main id="main" tabindex="-1"><?php the_content(); ?></main>
├── front-page.php                 # Same clean shell as page.php (renders Home Gutenberg blocks)
├── 404.php                        # Branded Mission Villa 404 page using --mv-* tokens
├── package.json                   # Dual build: Vite (Tailwind v4 + frontend CSS/JS + GSAP) & @wordpress/scripts (block edit.js)
├── vite.config.js                 # Compiles src/css/app.css (Tailwind v4), src/js/app.js, and section view scripts
│
├── inc/
│   ├── setup.php                  # Theme supports, nav menu locations, image sizes, Google Fonts, clean WP head
│   ├── assets.php                 # Vite manifest loader + conditional block asset enqueuing + editor styles
│   ├── blocks.php                 # Auto-registers all blocks/*/block.json + registers "Mission Villa" block category
│   ├── settings.php               # WP Admin "Mission Villa Settings" (NAP, phone, license, inquiry mode/intents, social URLs)
│   ├── nav-walker.php             # Custom Walker_Nav_Menu producing exact .site-nav & .site-mobile-nav markup
│   ├── helpers.php                # mv_inline_text(), mv_icon(), mv_site_config(), mv_img_url(), mv_media_manifest()
│   ├── inquiries-db.php           # Creates wp_mv_lead_submissions table + Lead storage + Admin Leads viewer page
│   ├── inquiries-rest.php         # REST route POST /wp-json/missionvilla/v1/inquiries (validation, rate-limit, honeypot)
│   ├── seo.php                    # Lightweight title/meta/OG/canonical fallback (defers cleanly if Yoast/RankMath active)
│   └── cli-seeder.php             # WP-CLI commands: `wp mv import-media`, `wp mv seed-page <slug>`, `wp mv seed-all`, `wp mv seed-menus`
│
├── template-parts/
│   ├── site-header.php            # Exact port of resources/views/components/site/header.blade.php
│   ├── site-footer.php            # Exact port of resources/views/components/site/footer.blade.php
│   ├── inquiry-dialog.php         # Exact port of resources/views/components/inquiry/dialog.blade.php
│   ├── inquiry-form.php           # Exact port of resources/views/components/inquiry/form.blade.php
│   └── partials/
│       ├── icon.php               # Exact port of resources/views/partials/icon.blade.php
│       ├── care-options-icon.php  # Port of sections/care-options/icon.blade.php
│       ├── life-gallery-icon.php  # Port of sections/life-gallery/icon.blade.php
│       ├── why-families-icon.php  # Port of sections/why-families/icon.blade.php
│       ├── hero-care-chat.php     # Port of sections/hero-cinematic/care-chat.blade.php
│       └── hero-concierge.php     # Port of sections/hero-cinematic/concierge.blade.php
│
├── src/
│   ├── css/
│   │   ├── app.css                # Tailwind CSS v4 (@import 'tailwindcss'; + @source '../../blocks/**/*.php';) + tokens
│   │   ├── editor-bridge.css      # Scoped design tokens & Tailwind utilities for Gutenberg iframe canvas
│   │   └── components/            # Copied verbatim: header.css, editorial.css, inquiry.css, footer.css
│   ├── js/
│   │   ├── app.js                 # Imports site-header.js + inquiry-dialog.js
│   │   └── components/            # site-header.js, inquiry-dialog.js (adapted for WP REST URL + wp_rest nonce)
│   └── block-editor/
│       └── shared/                # Reusable React editor primitives for ALL 71 blocks:
│           ├── RepeaterControl.js # Add / Remove / Move Up / Move Down for cards, FAQs, slides, items
│           ├── ImageControl.js    # MediaUpload + Provenance ('facility'|'illustrative') + Alt + Mobile src
│           ├── IconPicker.js      # Visual dropdown of all whitelisted Lucide icons from partials/icon.php
│           ├── InquiryCtaControl.js # CTA label + intent selector + optional care/suite preselect
│           └── InlineRichText.js  # Pre-configured <RichText allowedFormats={['core/italic', 'core/bold']} />
│
├── blocks/                        # 71 self-contained Native Gutenberg Blocks
│   ├── visit-cta/
│   │   ├── block.json
│   │   ├── edit.js                # Source (compiled by @wordpress/scripts → build/blocks/visit-cta/index.js)
│   │   ├── render.php             # Exact HTML output matching visit-cta/index.blade.php
│   │   └── style.css              # Exact CSS matching resources/css/sections/visit-cta.css
│   ├── hero-cinematic/
│   │   ├── block.json
│   │   ├── edit.js
│   │   ├── render.php
│   │   ├── style.css
│   │   └── view.js                # Exact JS matching hero-cinematic.js (imports gsap 3.12.5)
│   └── ... (69 more blocks)
│
├── assets/
│   ├── images/                    # Copied from public/images/ (source for WP Media Library importer + static brand fallback)
│   └── media/                     # Copied from public/media/ (video manifest & films)
│
└── build/                         # Compiled output (committed or built in CI; production WP needs zero Node)
    ├── vite/                      # Vite manifest + compiled Tailwind v4 app.css, app.js, section view scripts
    └── blocks/                    # @wordpress/scripts compiled block edit.js + asset.php dependency manifests
```

---

## 3. Solving the Two Hardest Technical Challenges

### Challenge A: Tailwind CSS v4 Inside WordPress (47 of 71 Sections Use Tailwind)
- **Problem:** 47 Blade templates use Tailwind CSS v4 utility classes (`flex`, `grid`, `lg:mb-[2svh]`, `bg-[#F9F5F0]/10`, `px-[var(--pad-x)]`). If Tailwind v4 is not scanning the WordPress `render.php` AND `edit.js` files, those classes will silently vanish.
- **Solution:**
  1. Keep `tailwindcss: ^4.0.0`, `@tailwindcss/vite: ^4.0.0`, `vite: ^8.0.0`, and `gsap: 3.12.5` in the theme's `package.json`.
  2. In `src/css/app.css`, explicitly declare Tailwind v4 `@source` directives pointing to every PHP and JS file in the theme:
     ```css
     @import 'tailwindcss';
     @import './components/header.css';
     @import './components/editorial.css';
     @import './components/inquiry.css';
     @import './components/footer.css';

     @source '../../template-parts/**/*.php';
     @source '../../blocks/**/*.php';
     @source '../../blocks/**/*.js';
     @source '../../inc/**/*.php';
     ```
  3. Build with `vite build` (outputs `build/vite/manifest.json` + hashed CSS/JS files). WordPress loads them via `inc/assets.php` reading `manifest.json` — zero Node runtime required on production hosting!

### Challenge B: Preventing WordPress Core CSS From Polluting the Pixel-Identical Design
- **Problem:** WordPress injects `wp-block-library`, `global-styles`, and `classic-theme-styles` stylesheets that can override `box-sizing`, `p` margins, `h1-h6` line-heights, button resets, or link underlines.
- **Solution:**
  1. Dequeue `wp-block-library`, `wp-block-library-theme`, and `classic-theme-styles` on Mission Villa custom-block pages (or keep `wp-block-library` ONLY if standard core blocks like Paragraph/Heading are also allowed, while wrapping our tokens cleanly—recommended: dequeue `classic-theme-styles` and set `theme.json` `styles` to match `app.css` tokens so there is zero conflict).
  2. Configure `theme.json` v3 with `"layout": { "contentSize": "100%", "wideSize": "100%" }` so WordPress NEVER boxes Mission Villa sections into a centered `650px` or `1200px` container (respecting Design Standard Rule #12: *"One side padding, full width"*).
  3. Inside the Gutenberg Editor, WordPress 6.3+ renders blocks inside an **isolated `<iframe>` canvas** when all registered blocks use `apiVersion: 3`. This means our `app.css` + section `style.css` can load inside the editor iframe (`add_editor_style()` + `block.json` `style`) **without breaking WP Admin sidebar/toolbar styles**!

### Challenge C: Dual Build Pipeline (`package.json`)
Use two clean, non-conflicting npm scripts:
- `npm run build:frontend` → Runs `vite build` (compiles `src/css/app.css` with Tailwind v4, `src/js/app.js`, and all 36 `blocks/*/view.js` scripts including bundled GSAP 3.12.5).
- `npm run build:blocks` → Runs `wp-scripts build` (compiles all 71 `blocks/*/edit.js` React Gutenberg editor components with `@wordpress/blocks`, `@wordpress/block-editor`, `@wordpress/components` externals and generates `index.asset.php`).
- `npm run build` → Runs both sequentially (`npm run build:frontend && npm run build:blocks`).
