# 03 — Native Gutenberg Block Authoring Standard
## The Exact 1-to-1 Conversion Recipe (Blade + SectionSchema → Native WordPress Block)

> Follow this specification for **EVERY SINGLE ONE of the 71 blocks**. Consistency across all 71 blocks ensures every element on all 13 pages is natively editable without ever breaking the layout.

---

## 1. Naming & Registration Convention

Map every Laravel section `type` (dot notation) to a WordPress block name (`missionvilla/<kebab-case>`):

| Laravel Section `type` | WordPress Block Name | Folder Path |
|---|---|---|
| `intro.shutters` | `missionvilla/intro-shutters` | `blocks/intro-shutters/` |
| `hero.cinematic` | `missionvilla/hero-cinematic` | `blocks/hero-cinematic/` |
| `care.options` | `missionvilla/care-options` | `blocks/care-options/` |
| `life.gallery` | `missionvilla/life-gallery` | `blocks/life-gallery/` |
| `trust.why-families` | `missionvilla/why-families` | `blocks/why-families/` |
| `living.suites` | `missionvilla/suites-spaces` | `blocks/suites-spaces/` |
| `faq.featured` | `missionvilla/faq-featured` | `blocks/faq-featured/` |
| `visit.cta` | `missionvilla/visit-cta` | `blocks/visit-cta/` |
| `<page>.<section>` (all internal pages) | `missionvilla/<page>-<section>` | `blocks/<page>-<section>/` |

All 71 blocks register in custom block category `missionvilla` ("Mission Villa Sections") in `inc/blocks.php` via:
```php
foreach (glob(get_template_directory() . '/blocks/*/block.json') as $block_json) {
    register_block_type(dirname($block_json));
}
```

---

## 2. `block.json` Specification (API Version 3)

Every block MUST use `"apiVersion": 3` (enables WordPress's isolated iframe editor canvas!).

```json
{
  "$schema": "https://schemas.wp.org/trunk/block.json",
  "apiVersion": 3,
  "name": "missionvilla/about-core-values",
  "version": "1.0.0",
  "title": "About: Core Values",
  "category": "missionvilla",
  "icon": "heart",
  "description": "Mission Villa About page core values editorial grid.",
  "supports": {
    "html": false,
    "reusable": true,
    "align": false,
    "anchor": true
  },
  "attributes": {
    "sectionId": { "type": "string", "default": "core-values" },
    "eyebrow": { "type": "string", "default": "" },
    "heading": { "type": "string", "default": "" },
    "intro": { "type": "string", "default": "" },
    "values": {
      "type": "array",
      "default": []
    }
  },
  "editorScript": "file:../../build/blocks/about-core-values/index.js",
  "style": "file:./style.css",
  "render": "file:./render.php"
}
```

### Rules for `viewScript` (Interactive JS Blocks — 36 of 71 Blocks)
- For the **36 blocks** that have a `resources/js/sections/<name>.js` file:
  - Compile the script with Vite (so GSAP 3.12.5 or shared helpers bundle cleanly) OR register a handle in `inc/assets.php` (e.g. `mv-view-hero-cinematic`) and reference `"viewScript": "mv-view-hero-cinematic"` in `block.json`!
  - WordPress then automatically enqueues that script **ONLY on pages that contain that block** — identical to Laravel's `@push('section-assets')`!
  - **Important for `view.js`:** Wrap initialization cleanly so it works on `DOMContentLoaded` and never double-initializes (`if (el.dataset.mvInit) return; el.dataset.mvInit = '1';`).

---

## 3. Attribute Mapping Rules (`SectionSchema` → `block.json`)

Inspect `app/Content/Sections/<Name>Section.php` before writing `block.json`:
1. **Plain Text Fields** (`eyebrow`, `title`, `label`, `kicker`, `footnote`, etc.) → `{ "type": "string", "default": "<from content/pages/*.php>" }`.
2. **Inline-Formatted Text Fields** (fields rendered with `InlineText::render()` in Blade, e.g. headings with `<em>` terracotta italic line breaks or body text with `<strong>`) → `{ "type": "string", "default": "..." }`, edited with `<InlineRichText />` (`allowedFormats={['core/italic', 'core/bold']}`) and sanitized in `render.php` with `mv_inline_text()`.
3. **Image Objects** → Store as structured object attribute:
   ```json
   {
     "id": 0,
     "url": "/images/...",
     "mobileId": 0,
     "mobileUrl": "/images/...",
     "alt": "...",
     "provenance": "facility",
     "provenanceLabel": "Mission Villa · Daly City",
     "sourceUrl": ""
   }
   ```
   When an editor swaps an image via `<MediaUpload>`, update both `id` (WP attachment ID) and `url`. `render.php` resolves `wp_get_attachment_image_url($id, 'full')` first, falling back to theme/site URL so seeded pages work even before manual edits.
4. **CTA / Action Objects** → Store `{ label, href, intent, care, suite, icon, primary, source }`:
   - If `intent` is non-empty (`schedule_visit`, `request_pricing`, `request_availability`, `request_callback`, `general_inquiry`), `render.php` outputs `href="tel:16507561995" data-inquiry="<intent>"` (Design Standard Rule #4!).
   - If `intent` is empty, `render.php` outputs standard `href="<?php echo esc_url(mv_url($cta['href'])); ?>"`.
5. **Repeater Arrays** (`slides`, `items`, `cards`, `faqs`, `pillars`, `steps`, `formats`, `photos`, `tabs`) → `{ "type": "array", "default": [...] }`. Enforce the exact `min` and `max` item counts from `app/Content/Sections/<Name>Section.php` inside `edit.js` (disable "Add" button at max, disable "Remove" button at min) so editors can NEVER break the grid geometry!

---

## 4. Porting Blade → `render.php` (Zero DOM Drift)

Every `blocks/<slug>/render.php` receives `$attributes`, `$content`, and `$block` from WordPress.

### Mandatory Blade → PHP Translation Cheat Sheet

| Laravel Blade Syntax | WordPress `render.php` Equivalent |
|---|---|
| `{{ $var }}` | `<?php echo esc_html($var); ?>` |
| `href="{{ $url }}"` | `href="<?php echo esc_url(mv_url($url)); ?>"` |
| `{{ asset(ltrim($src, '/')) }}` | `<?php echo esc_url(mv_img_url($src)); ?>` |
| `{!! \App\Content\InlineText::render($val, $cls) !!}` | `<?php echo mv_inline_text($val, $cls); ?>` |
| `config('missionvilla.phone.href')` | `mv_site_config('phone.href')` |
| `config('missionvilla.phone.display')` | `mv_site_config('phone.display')` |
| `config('missionvilla.address.street')` | `mv_site_config('address.street')` |
| `@include('partials.icon', ['name' => $n, 'class' => $c, 'stroke' => $s])` | `<?php echo mv_icon($n, $c, $s); ?>` |
| `@include('sections.care-options.icon', [...])` | `<?php mv_section_partial('care-options-icon', [...]); ?>` |
| `@json($arr)` | `<?php echo wp_json_encode($arr, JSON_UNESCAPED_UNICODE \| JSON_HEX_TAG \| JSON_HEX_AMP); ?>` |
| `<x-inquiry.form instance="inline" ... />` | `<?php get_template_part('template-parts/inquiry-form', null, [...]); ?>` |
| `@push('preload')` (only in `hero-cinematic`) | Register via `wp_head` hook in `inc/assets.php` when `has_block('missionvilla/hero-cinematic')` |
| `@push('section-assets')` | Handled automatically by `block.json` `"style"` and `"viewScript"`! |

### Critical `render.php` Verification Rule
Do **NOT** add `<div <?php echo get_block_wrapper_attributes(); ?>>` around `<section>` if it alters CSS sibling selectors (like `.visit-cta` wave overlap or `main > section`). Instead, pass the existing section classes into `get_block_wrapper_attributes(['class' => 'existing-section-class', 'id' => $section_id])` directly ON the `<section>` element itself!

---

## 5. Building Native `edit.js` (True WYSIWYG + Full Element Editability)

Every single block's `edit.js` must provide **two seamless editing layers** so non-technical editors feel like they are editing directly on the live page:

### Layer 1: Direct On-Canvas Editing (Inside the Actual Section Layout)
Render the **exact same HTML structure and CSS classes** inside `edit.js` as `render.php`, replacing static text/images with native Gutenberg interactive primitives:
- **Headings, Eyebrows, Paragraphs, Captions, Card Titles, FAQ Q&As:**
  Use `<InlineRichText>` (wraps `@wordpress/block-editor`'s `<RichText>` with `allowedFormats={['core/italic', 'core/bold']}` and `withoutInteractiveFormatting`). Clicking any text on the page edits it inline right in place!
- **Images:**
  Wrap every `<img>` with a subtle hover overlay button (`Change Photo`) wired to `<MediaUpload>` so editors can click any photo on the canvas to pick a replacement from the WordPress Media Library.
- **Interactive Tabs / Accordions / Slides inside the Editor:**
  Maintain local React state `const [activeTab, setActiveTab] = useState(0);` inside `edit.js` so clicking Slide 2, Tab 3, or FAQ 4 in the Block Editor switches to that item and lets the editor edit its content inline!
- **Disable Live Navigation/Modals in Editor:**
  Render buttons/links as `<span className="mv-btn ...">` or `onClick={(e) => e.preventDefault()}` inside `edit.js` so clicking a CTA edits its label instead of triggering a `tel:` link or modal.

### Layer 2: Structured Sidebar Controls (`<InspectorControls>`)
Put structural, metadata, and repeater controls in the right-hand Block Inspector sidebar using shared components from `src/block-editor/shared/`:
1. **Repeater Panels (`RepeaterControl.js`):** Add Item (up to schema `max`), Remove Item (down to schema `min`), Move Up / Move Down for slides, cards, FAQs, checklist items, gallery photos, timeline steps, and tabs.
2. **CTA & Link Controls (`InquiryCtaControl.js`):** Toggle between **Inquiry Modal Trigger** (dropdown: `schedule_visit`, `request_pricing`, `request_availability`, `request_callback`, `general_inquiry` + optional `care` & `suite` preselect) OR **Page / Custom URL Link**.
3. **Media & Provenance Controls (`ImageControl.js`):** Desktop image, optional Mobile image (`<=1023px`), Alt text, Provenance (`facility` vs `illustrative`), and Provenance badge label (enforcing Design Standard Rule #5!).
4. **Icon Picker (`IconPicker.js`):** Dropdown of the whitelisted Lucide icon keys for that section.
5. **Section Settings:** HTML Anchor (`sectionId`), optional toggle flags (e.g. `show_contact`, `show_form` on `visit-cta`, `autoplay_seconds` on `hero-cinematic`).

### Example Shared Primitive (`src/block-editor/shared/InlineRichText.js`)
```jsx
import { RichText } from '@wordpress/block-editor';

export function InlineRichText({
  tagName = 'p',
  className = '',
  value = '',
  onChange,
  placeholder = 'Enter text…',
  allowFormatting = true,
  maxLength = null,
}) {
  return (
    <RichText
      tagName={tagName}
      className={className}
      value={value}
      onChange={(next) => {
        if (maxLength && next.replace(/<[^>]+>/g, '').length > maxLength) {
          return;
        }
        onChange(next);
      }}
      allowedFormats={allowFormatting ? ['core/italic', 'core/bold'] : []}
      placeholder={placeholder}
    />
  );
}
```

---

## 6. Editor CSS Isolation Rules (`src/css/editor-bridge.css`)

1. Because all 71 blocks use `apiVersion: 3`, WordPress renders the post canvas inside an iframe.
2. In `src/css/editor-bridge.css`:
   - Set `.editor-styles-wrapper { background: var(--plum-abyss); color: var(--text-ivory); padding: 0 !important; }`
   - Remove Gutenberg's default `max-width` on `.wp-block` (`margin-left: 0; margin-right: 0; max-width: none !important;`) so every Mission Villa block renders edge-to-edge full-bleed inside the editor, matching the frontend 1-to-1!
   - Keep `intro-shutters` collapsed into a clean, compact editorial preview banner inside the editor (`height: auto; position: relative;`) so the fullscreen shutter overlay NEVER blocks editing the homepage in Gutenberg!
   - Disable fixed/sticky positioning conflicts inside the editor canvas (`position: relative` on any `position: fixed` block overlay).
