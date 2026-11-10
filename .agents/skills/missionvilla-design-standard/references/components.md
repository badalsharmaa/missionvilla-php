# Component recipes

Reuse the existing classes before writing new CSS. Shared classes live in `resources/css/components/`
(`editorial.css`, `inquiry.css`, `header.css`, `footer.css`). Section-specific classes are prefixed
(`ss-`, `faq-`, `vc__`, `wf-`, `care-`, `life-`). Copy their pattern, don't restyle them.

## Eyebrow + title + intro (every section head)
- `.mv-eyebrow` has `.mv-eyebrow__rule` (1px terracotta-rule line, `clamp(1.75rem,3.2vw,3.25rem)` wide) before
  uppercase text. Centred heads (02/03) put a rule on both sides.
- `.mv-title`: Newsreader 500, `--mv-fs-title`. Write the heading as `Plain words <em>Italic Phrase</em>`; the
  `<em>` becomes italic terracotta on its own line. Render it with `InlineText::render()` (allows `<em>` only).
- Intro: `--mv-fs-body`, line-height 1.6, `--mv-ink-soft`, max ≈ 34rem.
- On plum: a script eyebrow (Allura, peach, `clamp(1.9rem,2.5vw,2.6rem)`) above an ivory Newsreader title.

## Buttons (`.mv-btn` in editorial.css)
| Variant | Look | Use |
|---|---|---|
| `.mv-btn--primary` | Terracotta gradient pill, ivory text, warm shadow | Main conversion action (Schedule a Visit) |
| `.mv-btn--ghost-light` | Transparent pill with an `rgba(251,245,239,.62)` border | Secondary actions on plum |
| `.mv-btn--plum` | Solid `#47243D` | Secondary actions on cream |
| `.ss-action--secondary` | `#FFFDFB` pill, `--mv-line` border, ink text, terracotta arrow | Quiet secondary on cream |
| `.ss-action--primary` | Plum gradient pill, peach icon | Strong action on cream |
| `.vc__btn` | `.mv-btn` with radius `--mv-radius-sm`, left-aligned, max 22rem, stacked | Vertical CTA stack on plum |

Every button:
- Optional leading icon (`1.15–1.3em`). Trailing up-right `arrow` icon (`.95em`, stroke 2).
- Weight 600, `--mv-fs-ui`, min-height 3–3.1rem.
- Visible focus ring.
- Phones (<480px): stack at full width.

## Option tabs (Section 05 pattern)
- Three compact horizontal buttons, `role="tab"` in a `role="tablist"`, with roving tabindex. Arrow keys,
  Home and End move between tabs and select.
- **Inactive:** `rgba(255,255,255,.55)`, `--mv-line` border, terracotta icon.
- **Active:** plum gradient, ivory text, peach icon, plum shadow.
- All panels share one grid cell, so the frame never resizes. Only the opacity cross-fades. Inactive panels are `inert`.
- Phones (<480px): icon stacks above the label, centred.
- JS: `resources/js/sections/suites-spaces.js`.

## Photo frame
- `border-radius: --mv-radius`, `overflow: hidden`, plum fallback background, card shadow.
- Lower gradient `0deg rgba(36,14,32,.78) 0% → .38 28% → 0 52%`.
- Caption bottom-left: a kicker (peach, uppercase) plus ONE italic Newsreader line.
  **No paragraphs or buttons inside photos.**
- Floor plans and artwork use `fit: contain` on a white sheet, with the caption in ink.
- Provenance badge top-left: pill `rgba(47,18,40,.5)` + `blur(6px)`, `.7rem`, text such as
  "Mission Villa photo" or "Illustrative image · not actual residents".
- Images get `width`/`height`, `loading="lazy"`, `decoding="async"`, a mobile `srcset` source, an
  `object-position` from content, and a provenance HTML comment plus `data-provenance` / `data-rights`.

## Accordion (Section 06 pattern)
- One grouped card: `--mv-radius`, `--mv-line` border, `rgba(255,255,255,.62)`, padding `.35rem`.
- Rows are divided by `--mv-line-soft` hairlines. The open row is a tinted inset `#F5EDE3` with an inset `#E8D9C8` ring.
- Each row is a `<h3><button aria-expanded aria-controls>`: terracotta icon, Newsreader 600 question,
  plus/minus toggle. The answer panel has `role="region"`.
- One row open at a time; the first is open by default. Panels collapse with `grid-template-rows 0fr → 1fr`
  only after JS adds `data-enhanced`, so without JS every answer shows. ↑/↓/Home/End move focus.
- Optional answer actions are underlined links with a terracotta arrow and `data-inquiry`, so they open the modal.
- JS: `resources/js/sections/faq-featured.js`.

## Cards and panels
- **On cream:** `rgba(255,255,255,.55–.62)` or `#FFFDFB`, `--mv-line` border, `--mv-radius`, soft plum shadow.
- **Glass panel over a photo (04):** `rgba(251,247,242,.9–.95)`, `blur(14px) saturate(1.1)`, `1px rgba(255,255,255,.7)`.
- **Cream card on plum (07 form):** `linear-gradient(180deg,#FDF8F2,#F7EDE2)`, `1px rgba(251,245,239,.65)`, deep shadow.
- **Plum card (02):** plum fill, peach kicker; icon tiles `rgba(255,233,214,.09)` with a `.12` border.

## Icons
- `@include('partials.icon', ['name' => …, 'class' => …, 'stroke' => 1.4–1.6])`.
- Lucide geometry: 24 viewBox, `stroke: currentColor`, round caps.
- Available names: bed, people, armchair, sprout, calendar, home, phone, pin, file-text, heart, shield, arrow, plus,
  minus, check, x. Add new icons to that partial, in Lucide style.
- Colour: terracotta on cream, peach on plum. Size 1.3–2.1rem in tabs and lists, 1em inline.

## Decoration
- **Botanical leaf:** `<span class="mv-leaf …" aria-hidden="true">`. It's a CSS mask of
  `/images/decor/botanical-leaf-shadow.svg` tinted `#D9BFA6`.
  - Place it in a corner (usually lower-left), `z-index:-1`, opacity .3–.5, about 6.5–10rem wide.
  - It must never sit behind text you need to read.
  - Older sections use blurred `<img>` leaves at opacity .05–.16. Use `.mv-leaf` for new work.
- **Wave edge (cream → plum):** an SVG `viewBox="0 0 1440 80" preserveAspectRatio="none"` path filled with plum,
  height `clamp(1.75rem,4.2vw,4.25rem)` (see 04 and 07). Use at most one per page transition.
- **Section separation:** two adjacent cream sections are separated by a `1px --mv-line-soft` border and/or a
  subtle gradient (`#FCF6EF → --mv-cream`). Never merge them into one block.

## Inquiry modal and form (website-wide)
- **Markup contract:** `<a href="{{ config('missionvilla.phone.href') }}" data-inquiry="visit|pricing|availability|callback|general"
  [data-inquiry-source="<section>"] [data-inquiry-suite="private|shared"] [data-inquiry-care="memory_care|respite_care|exploring"]>`.
  - Canonical intents are `schedule_visit`, `request_pricing`, `request_availability`, `request_callback`, `general_inquiry`
    (`config/missionvilla.php` → `inquiries`, `App\Support\InquiryIntents`).
  - To add a section source, add it to `inquiries.sources`.
- **Rendering:**
  - Modal: `<x-inquiry.dialog />`, rendered once by the layout (native `<dialog>`).
  - Inline: `<x-inquiry.form instance="inline" source="…" />` wrapped in an element with `data-inquiry-inline`.
  - JS: `resources/js/components/inquiry-dialog.js` (`window.MissionVilla.openInquiry(intent, opts)`).
- **Modal look:**
  - Cream card, max 38rem.
  - Header: terracotta kicker, plum Newsreader title that changes with the intent, a lede, and a round close button.
  - The body scrolls inside the dialog; it fits 375×667.
  - Terracotta submit.
- **Fields:** inset labels (a small label inside a 3.35rem field box, input text 16px).
  - First name required, last name optional.
  - Phone or email (callback needs phone).
  - "How can we help?" select, optional consent box, privacy line.
  - **No free-text field** (keeps medical details out).
- **Section schemas** take an `intent` for form CTAs and an `href` + `fallback_label` + `fallback_intent` for links
  to pages that may not be routed yet (`App\Support\InternalLink`). Never link to a 404.

## Header and footer (global, already built: reuse, don't rebuild)
- **Header** (`<x-site.header>`):
  - Fixed (`z-index: 40`). The inquiry `<dialog>` (top layer), the Care Guide backdrop (`z-index: 100`) and the
    mobile drawer (inside the header) all sit above it.
  - **Two states**, set by `resources/js/components/site-header.js`:
    1. **Initial** (top of page): transparent over the hero (solid plum glass on `variant="solid"` pages).
       The bar is 72px below 1024px and 88px from 1024px, with the larger logo.
    2. **Compact sticky** (scrolled more than 88px): `.is-compact` + `.is-scrolled`. Solid plum glass
       `rgba(24,15,23,.92)` with blur. The bar is 60px below 1024px and 64px from 1024px. The logo is about
       34–38px where the nav leaves room. The desktop nav gap tightens to `clamp(.8rem,1vw,1.25rem)` and the
       CTA padding to `.58rem 1.05rem`.
  - The state comes from an IntersectionObserver on an invisible 88px sentinel at the top of `<body>`: no scroll
    listener and no layout reads. It is correct after a refresh at any scroll position. The header is fixed, so the
    state change never moves page content.
  - Height, logo size, nav gap and CTA padding transition over 0.32s `cubic-bezier(.22,1,.36,1)`. Under
    `prefers-reduced-motion` the change is instant. No GSAP or scroll-driven effects on the header.
  - The bar height lives in `--header-bar-h`. Use it (not a hard-coded 4.5rem/5.5rem) for anything sized against
    the header, such as the mobile drawer's `max-height`.
  - Official logo artwork: the light horizontal lockup (`mission-villa-logo-header-light.webp`), never HTML text.
    Responsive heights and the leaf-only fallback are in `brand-logo.md`. Desktop nav from 1280px with dropdowns;
    mobile drawer below that.
  - Ivory "Schedule a Visit" CTA (opens the modal).
  - Internal pages should use `variant="solid"` unless they open with a hero.
- **Footer** (`<x-site.footer>`):
  - `#3A1A31` plum, logo on a cream plate.
  - Four columns at ≥1024px: brand, Care & Living, Explore, Visit & Contact.
  - Links resolve via `App\Support\FooterNavigation` (real page once routed, else a fallback anchor, else hidden).
