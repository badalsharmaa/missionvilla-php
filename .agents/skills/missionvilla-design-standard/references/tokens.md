# Design tokens (approved homepage, 2026-11-10)

Canonical for new work: **`--mv-*` in `resources/css/components/editorial.css`** and the global tokens
in `resources/css/app.css`. Values below were read from the code. Re-check them there if in doubt.

## Fonts

Loaded once in `resources/views/components/layouts/site.blade.php` (Google Fonts, `display=swap`):

| Family | Weights | Use |
|---|---|---|
| **Newsreader** (serif, `font-optical-sizing: auto`) | roman 400/500/600, italic 400/500 | Section titles (500), card/modal titles, captions (italic 400), FAQ questions (600), nav labels. The logo wordmark is official artwork, never set in Newsreader (see `brand-logo.md`) |
| **Plus Jakarta Sans** (sans) | 400/500/600 | Body (default), eyebrows/kickers (600 uppercase), buttons (600), forms, nav, captions |
| **Allura** (script) | 400 | Only the script eyebrow ("A Place to Belong") and the intro shutters. Load per section |

- **Weight 700 is not loaded.** Some 02/04 buttons ask for 700 and get synthetic bold. New work uses **600**.
  Loading 700 site-wide is an open client decision.
- The client's Canva brand PDF names Lora + Poppins. They are **not** adopted. Don't introduce them.

## Colour

### Shared (`--mv-*`, use these)
| Token | Value | Role |
|---|---|---|
| `--mv-cream` | `#FBF4EC` | Cream band background |
| `--mv-cream-deep` | `#F4EAE0` | Deeper cream (tints, open-accordion feel `#F5EDE3`) |
| `--mv-ink` | `#2F1228` | Headings and primary text on cream |
| `--mv-ink-soft` | `#6A5A5D` | Body and supporting text on cream |
| `--mv-line` | `#E6D7C8` | Card and control borders on cream |
| `--mv-line-soft` | `#EFE4D8` | Hairlines and section separators |
| `--mv-terracotta` | `#B6634B` | Accent text, `<em>` in titles, icons on cream |
| `--mv-terracotta-deep` | `#A85840` | Deep accent, kicker on light |
| `--mv-terracotta-rule` | `rgba(182,99,75,.55)` | Eyebrow rule |
| `--mv-plum` | `#47243D` | Plum surfaces, active tab/button (top of gradient) |
| `--mv-plum-mid` | `#3A1A31` | Plum gradient end, footer background |
| `--mv-plum-deep` | `#2F1228` | Deepest plum |
| `--mv-peach` | `#EDBE96` | Accent on plum (icons, kickers, script) |
| `--mv-ivory` | `#FBF5EF` | Text on plum |

- **Primary (terracotta) button:** `linear-gradient(180deg,#C2705A,#A85840)`, text `#FFF8F2`; hover `#CB7A63 → #B0614A`.
- **Plum band:** `linear-gradient(180deg, var(--mv-plum), var(--mv-plum-mid))`.
- **Text on plum:** ivory `#FBF5EF`; body `rgba(251,245,239,.86)`; dividers `rgba(251,245,239,.2–.26)`.
- **Error red:** `#A23B2A` (text `#8C2F20`, background `rgba(162,59,42,.09)`).
- **Botanical leaf tint:** `#D9BFA6`.

### Dark hero/header register (`app.css` `--plum-*`, `--accent-*`; hero + header only)
- **Plums:** `--plum-abyss #180F17` (page background), `--plum-deep #241522`, `--plum-surface #2E1B2B`.
- **Text:** `--text-ivory #F9F5F0`, body `rgba(245,239,232,.94)`, subtle `rgba(235,225,214,.72)`.
- **Accents:** `--accent-terracotta #C86D51` (hover `#D67B5F`), `--accent-peach #F3C6B6`, `--accent-sage #6E8F7D`.
- **Scrolled header:** `rgba(24,15,23,.92)` + `blur(14px)` + `1px rgba(249,245,240,.1)` border.

### Known inconsistencies: do NOT copy into new pages
| Where | Value | Shared value to use |
|---|---|---|
| Section 03 ink / terracotta | `#380C34` / `#B95A45` | `#2F1228` / `#B6634B` |
| Section 02 plum card / warm card | `#3A1A31` / `#432826` | `--mv-plum` gradient |
| Hero terracotta / peach | `#C86D51` / `#F3C6B6` | Keep inside the hero only |
| Cream backgrounds 02/03/04 | `#F9F2EB`, `#F8F0E8` | `#FBF4EC` |
| Care Guide hard-coded colours | `#97513D`, `#A84C38`, `#486355` | Hero only |

Unifying these is an open decision (`docs/NEXT_SESSION.md` 1b(g), 1c(h)).

## Type scale (`app.css`; Section 02 is the reference)

| Token | Value | Use |
|---|---|---|
| `--mv-fs-eyebrow` | `clamp(.72rem,.9vw,.95rem)` | Eyebrows (600, uppercase, ls `.34em`; `.2em` ≤400px) |
| `--mv-fs-title` | `clamp(2.15rem, min(3.9vw,7.6svh), 4.75rem)` | Section titles: Newsreader 500, lh 1.06, ls `-.015em`, `text-wrap: balance` |
| `--mv-fs-body` | `clamp(.98rem,1.25vw,1.3rem)` | Section intro/lede, lh 1.6 |
| `--mv-fs-ui` | `clamp(.92rem,1vw,1.05rem)` | Buttons, tabs, FAQ answers, card body |
| `--mv-fs-button` | `clamp(1rem,1.2vw,1.25rem)` | Large pill CTAs only |
| `--mv-fs-small` | `clamp(.82rem,.85vw,.9rem)` | Contact lines, small print, lede inside cards |

Other sizes on the scale:
- **Kicker:** `clamp(.68rem,.75vw,.8rem)` to `clamp(.72rem,.85vw,.9rem)`, 600, uppercase, ls `.24–.32em`
  (terracotta on light, peach on plum/photos).
- **Card / panel title:** Newsreader 500, `clamp(1.45rem, min(2vw,3.9svh), 2.4rem)` (03 info) or
  `clamp(1.55rem, min(2.1vw,4svh), 2.25rem)` (07 form card).
- **Photo caption line:** Newsreader italic 400, `clamp(1.3rem, min(1.8vw,3.4svh), 2rem)`, lh 1.15.
- **FAQ question:** Newsreader 600, `clamp(1.05rem,1.3vw,1.35rem)`, lh 1.3.
- **Section 07 heading** (deliberately a step down from section titles): `clamp(2rem, min(3vw,5.6svh), 3.25rem)`.
- **Title `<em>`:** italic 400, terracotta, `display: block` (own line) in `.mv-title`.
- **Hero only:** headline `clamp(2.25rem,3.4vw,3.35rem)` 600; body `clamp(.95rem,1.05vw,1.0625rem)`.
- **Measure:** intros max ≈ 30–34rem; body paragraphs ≤ 48rem.

## Spacing and layout

- **Gutter:** `--mv-gutter: clamp(1.25rem, 5vw, 4.75rem)` (hero/header `--pad-x: clamp(1.5rem,5vw,4.75rem)`).
  Sections 02/03 use narrower local gutters. New work uses `--mv-gutter`.
- **Fixed header:** 4.5rem tall, 5.5rem at ≥1024px.
  - Full-height sections pad the top with `calc(5.5rem + clamp(…))`.
  - Use `scroll-margin-top: 4.5rem` on section ids.
- **Section padding:**
  - Content-height cream sections: `clamp(3rem, 9vw, 4.25rem)` vertical on phones; desktop `clamp(3.25rem, 8svh, 5.5rem)`
    top and `clamp(3rem, 7svh, 4.75rem)` bottom.
  - Inner grid gap: `clamp(1.75rem, 4vw, 2.75rem)`; column gap on desktop `clamp(2rem, 3.6vw, 4.5rem)`.
- **Two-column desktop grids (≥1024px):** narrative `minmax(0,.92fr)` + media `minmax(0,1.08fr)` (05);
  intro `.78fr` + list `1.22fr` (06); story `.86fr` + divider `auto` + card `1.14fr` (07).
- **Heights:**
  - 01 hero is exactly 100svh.
  - 02/03/04 are `min-height: 100svh` on desktop (they may grow, never clip).
  - 05/06/07 take their content height (≈75/53/85vh at 1440×900).
  - Phones always flow naturally.
- **Breakpoints in use:**
  - 360, 400 (eyebrow tracking), 480 (form rows go 2-up, phone tabs).
  - 640, 768 (tablet; photo frames 16:9), 1024 (desktop two-column, 5.5rem header).
  - 1100 (03 three-column), 1200 (04 overlay), 1280 (desktop nav), 1600 (wide), 1700 (header phone).
  - Short desktops: `(min-width:1024px) and (max-height:820px)` tightens spacing; simplify layouts, never shrink type.

## Radii, borders, shadows

- **Radii:**
  - `--mv-radius: clamp(1.1rem,1.5vw,1.6rem)` for cards, photo frames, modal and FAQ group.
  - `--mv-radius-sm: clamp(.75rem,.9vw,1rem)` for tabs, accordion rows, vertical CTA buttons.
  - Pills `999px`; inputs `.7rem`; submit `.8rem`.
  - Hero/header: card 14px, inner 10px, button 9px, control 8px.
- **Card shadow on cream:** `0 30px 60px -40px rgba(47,18,40,.55)`; lighter `0 24px 48px -40px rgba(47,18,40,.5)`.
- **Button shadows:**
  - Plum: `0 16px 30px -18px rgba(47,18,40,.8)`.
  - Terracotta: `0 16px 30px -18px rgba(140,62,40,.75), inset 0 1px 0 rgba(255,255,255,.18)`.
- **Card on plum (form card):** `0 34px 70px -40px rgba(10,2,8,.85)`, border `1px rgba(251,245,239,.65)`.

## Motion

- **Hover and focus transitions:** `.2–.3s ease` (buttons `.25s`). Hover lift `translateY(-1px)`; arrow icon
  nudges `translate(2px,-2px)`.
- **Option / tab cross-fade:** `opacity .45s ease` (05 photo), `220ms` (03 chapters). Accordion:
  `grid-template-rows .32s ease`. Card flip (02): `.95s cubic-bezier(.2,.75,.2,1)`.
- **Modal entrance:** `.22s ease-out`, opacity + `translateY(8px) scale(.985)` to rest.
- **GSAP** only in the hero (slide reveal, 6s autoplay, disabled with reduced motion) and the intro shutters.
- **Reduced motion:** global `animation/transition-duration: .01ms !important` (`app.css`). Flips become cross-fades.
- **Focus:** global `2px solid` peach, offset 2px. Cream sections use terracotta, offset 3px.
