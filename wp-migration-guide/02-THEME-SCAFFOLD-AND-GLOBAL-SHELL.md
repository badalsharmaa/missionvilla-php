# 02 — Theme Scaffold & Global Shell Specification
## Phase 1 Blueprint: `theme.json`, `functions.php`, Header, Footer, Inquiry Modal & Helpers

---

## 1. `theme.json` (API Version 3)

Place at `wp-content/themes/missionvilla/theme.json`. This registers Mission Villa's exact design tokens natively in WordPress while preventing WordPress from adding boxed container widths.

```json
{
  "$schema": "https://schemas.wp.org/trunk/theme.json",
  "version": 3,
  "settings": {
    "appearanceTools": false,
    "useRootPaddingAwareAlignments": false,
    "layout": {
      "contentSize": "100%",
      "wideSize": "100%"
    },
    "color": {
      "defaultPalette": false,
      "defaultGradients": false,
      "palette": [
        { "slug": "plum-abyss", "color": "#180F17", "name": "Plum Abyss" },
        { "slug": "plum-deep", "color": "#241522", "name": "Plum Deep" },
        { "slug": "plum-surface", "color": "#2E1B2B", "name": "Plum Surface" },
        { "slug": "mv-plum", "color": "#47243D", "name": "Editorial Plum" },
        { "slug": "mv-plum-mid", "color": "#3A1A31", "name": "Editorial Plum Mid" },
        { "slug": "mv-ink", "color": "#2F1228", "name": "Editorial Ink" },
        { "slug": "mv-ink-soft", "color": "#6A5A5D", "name": "Soft Ink" },
        { "slug": "mv-cream", "color": "#FBF4EC", "name": "Warm Cream" },
        { "slug": "mv-cream-deep", "color": "#F4EAE0", "name": "Deep Cream" },
        { "slug": "mv-terracotta", "color": "#B6634B", "name": "Terracotta" },
        { "slug": "mv-terracotta-deep", "color": "#A85840", "name": "Terracotta Deep" },
        { "slug": "mv-peach", "color": "#EDBE96", "name": "Editorial Peach" },
        { "slug": "accent-peach", "color": "#F3C6B6", "name": "Hero Peach" },
        { "slug": "accent-sage", "color": "#6E8F7D", "name": "Sage" },
        { "slug": "text-ivory", "color": "#F9F5F0", "name": "Ivory" }
      ]
    },
    "typography": {
      "defaultFontSizes": false,
      "customFontSize": false,
      "fontFamilies": [
        {
          "slug": "sans",
          "name": "Plus Jakarta Sans",
          "fontFamily": "'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif"
        },
        {
          "slug": "serif",
          "name": "Newsreader",
          "fontFamily": "'Newsreader', Georgia, serif"
        },
        {
          "slug": "script",
          "name": "Allura",
          "fontFamily": "'Allura', cursive"
        }
      ]
    }
  }
}
```

---

## 2. Core Theme Setup (`inc/setup.php` & `inc/assets.php`)

### `inc/setup.php` Requirements
1. Register theme supports:
   - `title-tag`
   - `post-thumbnails`
   - `html5` (`search-form`, `gallery`, `caption`, `style`, `script`)
   - `editor-styles` (enables loading `build/vite/app.css` inside Gutenberg's iframe canvas!)
   - `responsive-embeds`
   - `disable-custom-colors`, `disable-custom-font-sizes` (protects design consistency)
2. Register 4 native WordPress Navigation Menus (`register_nav_menus`):
   - `primary` — Primary Header Navigation (supports 2-level dropdowns + WP Menu Item `description` field!)
   - `footer_care` — Footer Column 1 ("Care & Living")
   - `footer_explore` — Footer Column 2 ("Explore")
   - `footer_legal` — Footer Legal Bar ("Privacy Policy", "Terms of Use", "Accessibility Statement")
3. Enqueue Google Fonts identically to `layouts/site.blade.php`:
   - Global: `https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;0,6..72,600;1,6..72,400;1,6..72,500&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap`
   - Script font (`Allura`, used by `intro-shutters` & `visit-cta`): `https://fonts.googleapis.com/css2?family=Allura&display=swap` (enqueue conditionally when `has_block('missionvilla/intro-shutters') || has_block('missionvilla/visit-cta')`, and always inside the Block Editor).
4. Add `<link rel="preconnect" href="https://fonts.googleapis.com">` and `<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>` via `wp_resource_hints` or `wp_head` priority 1.
5. Add `<meta name="theme-color" content="#180F17">` and WebP favicon (`images/brand/mission-villa-mark-160.webp`) in `wp_head`.
6. **Clean WP Head:** Remove WP emoji scripts (`print_emoji_detection_script`) and dequeue `classic-theme-styles` on frontend so zero WordPress default styles interfere with Mission Villa CSS.

### `inc/assets.php` Requirements (Vite Manifest Loader)
- Read `get_template_directory() . '/build/vite/manifest.json'` once per request (cached in a static variable).
- Helper `mv_vite_asset(string $entry): ?string` returns the URL to the built file.
- Enqueue global bundle on every frontend page:
  - CSS: `src/css/app.css` (compiled Tailwind v4 + `header.css` + `editorial.css` + `inquiry.css` + `footer.css`)
  - JS: `src/js/app.js` (with `type="module"` via `script_loader_tag` filter, deferred)
- Pass runtime config to `src/js/app.js` via `wp_localize_script` (or `wp_add_inline_script` before module):
  ```php
  window.MissionVillaConfig = {
      restUrl: esc_url_raw(rest_url('missionvilla/v1/inquiries')),
      nonce: wp_create_nonce('wp_rest'),
      phone: mv_site_config('phone.display'),
      inquiryMode: mv_inquiry_mode(), // 'local' | 'live' | 'preview'
  };
  ```
- **Editor Canvas Styles:** Hook `enqueue_block_editor_assets` and `after_setup_theme` (`add_editor_style`) to load:
  - Google Fonts (`Newsreader`, `Plus Jakarta Sans`, `Allura`)
  - Compiled `build/vite/app.css`
  - `src/css/editor-bridge.css` (ensures `.editor-styles-wrapper` has `background: var(--plum-abyss); padding: 0;`, full-width block wrappers, and clean outline indicators for selected blocks).

---

## 3. Global Site Settings Page (`inc/settings.php`)

Replace `config/missionvilla.php` with an editable WordPress Admin Settings Page (**WP Admin → Mission Villa**):
- **Business Identity (NAP):**
  - Site Name (`Mission Villa Senior Living`), Short Name (`Mission Villa`), Locality (`Daly City, California`)
  - Street (`995 East Market Street`), Street Short (`995 East Market St`), City (`Daly City`), Region (`CA`), Postal Code (`94014`)
  - Phone Display (`(650) 756-1995`), Phone Href (`tel:16507561995`)
  - License Label (`CA RCFE License`), License Number (`415601046`)
- **Brand Assets (Editable via WP Media Picker, seeded with official defaults):**
  - Header Logo Light (`mission-villa-logo-header-light.webp`, 1046×168)
  - Header Mark Compact (`mission-villa-mark-160.webp`, 160×102)
  - Footer Stacked Logo (`mission-villa-logo-honor-560.webp`, 560×417)
- **Footer Copy & Social Links:**
  - Footer Description text
  - Facebook, Instagram, LinkedIn URLs (defaults to `#`)
- **Inquiry Engine Settings:**
  - Mode: `local` (save to WP DB, show "saved locally" notice) | `live` (save + webhook/email) | `preview` (no save)
  - Consent version string (`inquiry-consent-2026-11-10`)
  - Rate limits: `per_minute` (5), `per_day` (20)
  - Webhook / Synergy Hub endpoint URL (optional, blank until connected)
- Helper function `mv_site_config(?string $dot_key = null)` reads from `get_option('mv_site_settings', $defaults)` with exact fallback to the verified `config/missionvilla.php` values so the site works immediately on activation.

---

## 4. Global Header (`template-parts/site-header.php` + `inc/nav-walker.php`)

Port `resources/views/components/site/header.blade.php` **character-for-character** in DOM structure and class names:
- Supports `data-variant="overlay"` (default on all 13 pages; can also be overridden per page via a `Page Meta` sidebar toggle in Gutenberg!).
- **CRITICAL LOGO RULE (Design Standard Rule #13):** Keep the exact `<picture class="site-header__logo-wrap">` with `<source media="(max-width: 369.98px), (min-width: 1280px) and (max-width: 1365.98px)">` swapping to `mission-villa-mark-160.webp` and `<img>` using `mission-villa-logo-header-light.webp`. Never replace with HTML text.
- **Custom Nav Walker (`MV_Primary_Nav_Walker`):**
  - Reads the `primary` WP Nav Menu.
  - Top-level items WITH children render `<button type="button" class="site-nav__link site-nav__toggle ..." aria-expanded="false" aria-controls="site-nav-menu-N" data-nav-toggle>` + `<div class="site-nav__menu" id="site-nav-menu-N" hidden><ul class="site-nav__panel">...`.
  - Child items render `<span class="site-nav__menu-label">`, `<span class="site-nav__menu-desc">` (populated from WordPress's native Menu Item `description` field!), and `<span class="site-nav__menu-arrow" aria-hidden="true">↗</span>`.
  - Active page detection sets `.is-active` and `aria-current="page"`.
- **Mobile Drawer (`MV_Mobile_Nav_Walker`):**
  - Renders `#site-mobile-nav` with the exact `.site-mobile-nav__group`, `.site-mobile-nav__heading`, `.site-mobile-nav__sublink`, deduplicating standalone top-level links that already appear inside a dropdown group (mirroring line 85 of `header.blade.php`).
- **Header Actions:** Phone link (`tel:16507561995`), `Schedule a Visit` CTA (`data-inquiry="schedule_visit" data-inquiry-source="header"`), and hamburger toggle (`data-mobile-nav-toggle`).
- **JS:** Copy `resources/js/components/site-header.js` verbatim into `src/js/components/site-header.js` — zero changes needed!

---

## 5. Global Footer (`template-parts/site-footer.php`)

Port `resources/views/components/site/footer.blade.php` verbatim:
- Uses `footer_care`, `footer_explore`, and `footer_legal` WP Nav Menus (editable in WP Admin → Appearance → Menus).
- Uses `mv_site_config()` for logo, description, social links, Daly City address, phone, CA RCFE License `#415601046`, dynamic copyright year `date('Y')`, and `Schedule a Visit` CTA (`data-inquiry="schedule_visit"`).
- Renders all SVG icons via `mv_icon($name, $class, $stroke)`.

---

## 6. Shared PHP Helpers (`inc/helpers.php`)

Port these exact Laravel helpers so every block's `render.php` stays clean and 1-to-1 with Blade:

1. **`mv_inline_text(string $value, array $classes = []): string`**
   - Exact port of `App\Content\InlineText::render()`.
   - Strips all tags except `<em>` and `<strong>` (no attributes allowed), escapes text, and optionally injects presentation classes on `<em>`/`<strong>`.
2. **`mv_icon(string $name, string $class = 'mv-icon', float $stroke = 1.5): string`**
   - Exact port of `resources/views/partials/icon.blade.php` containing all 27 whitelisted Lucide SVG paths (`facebook`, `instagram`, `linkedin`, `bed`, `people`, `armchair`, `sprout`, `calendar`, `home`, `phone`, `pin`, `file-text`, `heart`, `shield`, `book-open`, `compass`, `utensils`, `sparkles`, `moon`, `briefcase`, `heart-handshake`, `check-circle`, `arrow`, `plus`, `minus`, `check`, `x`).
3. **`mv_render_image(array $img, array $opts = []): string`**
   - Resolves an image attribute `{ id, url, mobileId, mobileUrl, alt, provenance, sourceUrl }` cleanly:
     - If `id` (WP Media Library attachment ID) is set, resolves `wp_get_attachment_image_url($id, 'full')` (and falls back to `url` if seeded/static).
     - Preserves exact `<picture>` / `<source media="(max-width: 1023px)">` / `<img>` attributes (`decoding="async"`, `loading`, `fetchpriority`, `width`, `height`, `class`).
4. **`mv_url(string $path): string`**
   - Converts site-relative paths like `/memory-care` or `/#care-options` to `home_url($path)` while leaving `tel:`, `mailto:`, `#`, and `https://` untouched.
5. **`mv_section_partial(string $name, array $args = []): void`**
   - Thin wrapper around `get_template_part("template-parts/partials/{$name}", null, $args)` for the 5 extra Blade sub-partials (`care-options-icon`, `life-gallery-icon`, `why-families-icon`, `hero-care-chat`, `hero-concierge`).

---

## 7. Page Shell (`header.php`, `page.php`, `front-page.php`, `footer.php`)

- **`header.php`:** Outputs `<!DOCTYPE html>`, `<html <?php language_attributes(); ?>>`, `<head>` (`wp_head()`), `<body <?php body_class('site-body'); ?>>`, `wp_body_open()`, skip-link `<a href="#main" class="skip-link">Skip to main content</a>`, and `get_template_part('template-parts/site-header')`.
- **`page.php` & `front-page.php`:**
  ```php
  <?php get_header(); ?>
  <main id="main" tabindex="-1">
      <?php
      while (have_posts()) :
          the_post();
          the_content();
      endwhile;
      ?>
  </main>
  <?php get_footer(); ?>
  ```
- **`footer.php`:** Outputs `get_template_part('template-parts/site-footer')`, `get_template_part('template-parts/inquiry-dialog')`, `wp_footer()`, `</body></html>`.
- **CRITICAL:** Notice there is NO wrapping `.entry-content` or `.wp-site-blocks` padding container around `the_content()`. Every Gutenberg block renders its own `<section class="...">` directly inside `<main id="main">` — 100% identical DOM hierarchy to Laravel's `resources/views/pages/page.blade.php`!
