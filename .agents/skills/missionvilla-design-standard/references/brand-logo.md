# Brand logo: official artwork only

**All Mission Villa branding must use official approved logo assets. Do not recreate the wordmark using generic
HTML text or substitute typography.** No `<span>MISSION VILLA</span>`, no Newsreader/serif imitation, no
web-generated or AI-generated logo, no different leaf. The wordmark is custom lettering (enlarged initial M and V,
tightly set "MissionVilla", centred "SENIOR LIVING" between gold rules). No web font reproduces it.

## Canonical source

| File | What it is |
|---|---|
| `resources/brand/mission-villa-logo-honor.png` | **Master.** Official stacked logo, 1342×999, transparent. Byte-identical copy of `missionvilla-ui-new/public/brand/mission-villa-logo-honor.png` (official client logo, added in the React reference at `82a9d23`). Tagline: "The honor they deserve, the care you'll love." |
| `../missionvilla-ui-new/public/brand/mission-villa-logo-care-today.png` | Official alternate stacked logo (tagline "Care Today. A Brighter Tomorrow."). Not used on the site yet. |

There is **no SVG/vector and no official horizontal lockup** in the project. If the client supplies vector artwork,
rebuild the derivatives from it and update this file.

## Approved variants (all in `public/images/brand/`)

| File | Use | Built how |
|---|---|---|
| `mission-villa-logo-honor-560.webp` | Footer (stacked, official colours, with tagline) on its cream plate | Resize of the master |
| `mission-villa-logo-header-light.webp` (1046×168) | **Header / any dark surface** | `resources/brand/build-header-logo.py` |
| `mission-villa-logo-header-colour.webp` (1046×168) | Horizontal lockup on **light** surfaces (cream/ivory/white) | same script |
| `mission-villa-mark-160.webp` / `mission-villa-mark.webp` | Leaf mark alone: favicon, Section 04 accent, header fallback where the lockup can't fit | Official leaf |

The horizontal lockups are a **rearrangement of the official pixels, not a redraw**. The script crops the official
leaf, the "MissionVilla" wordmark and the "SENIOR LIVING" + gold-rules band, then sets the leaf to the left. Each
piece is scaled uniformly, so letterforms, spacing and proportions are untouched. The tagline is left out because it
is illegible at header size. The **light** variant changes only ink colour: wordmark plum → ivory `#F9F5F0`,
subtitle green → pale sage `#D6E0CB`. The leaf keeps its colours and the rules stay gold. To change a variant, edit
the script and rerun it (`python3 resources/brand/build-header-logo.py`). Never hand-edit the webp files.

## Header usage (`resources/views/components/site/header.blade.php`)

- `<picture>` with the light lockup; `alt=""` because the brand link carries `aria-label="Mission Villa Senior Living — Home"`.
- Sized by **height only** (`width: auto`), so it never stretches. The asset is ~3× the largest display height, so it stays sharp on retina.
- Heights (lockup width in brackets):

  | Viewport | Height | Shows |
  |---|---|---|
  | ≤369px | 1.75rem | leaf mark only |
  | 370–379 · 380–389 | 1.6rem (159px) | lockup |
  | 390–439 · 440–519 | 1.75rem (174px) | lockup |
  | 520–1023 | 2.5rem (249px) | lockup |
  | 1024–1279 (no desktop nav) | 3rem (299px) | lockup |
  | 1280–1365 | 2.6rem | **leaf mark only**: the full nav leaves no room for a legible lockup |
  | 1366–1439 | 1.7rem (169px) | lockup |
  | 1440–1535 | 2.3rem (229px) | lockup |
  | ≥1536 | 3rem (299px) | lockup |

- These bands were measured with no overlap, one-row nav and no overflow at 33 widths from 320 to 1920px.
  If you add a nav item or change the CTA, rerun that check and retune these heights. Don't shrink the nav.

## Footer usage (`resources/views/components/site/footer.blade.php`, `config/navigation.php` → `footer.logo`)

- Official stacked logo with tagline (`mission-villa-logo-honor-560.webp`) on the cream plate (`.sf__logo-plate`:
  `--mv-cream`, `0.8rem 1rem` padding, `--mv-radius-sm`). Width `clamp(9.5rem, 12vw, 11.5rem)`.
- This is the client-approved reference. Do not replace it, recolour it or remove the plate.
- `alt` spells out the name and tagline.

## Minimum spacing and size

- Clear space around any logo is at least the height of the "SENIOR LIVING" subtitle band (≈ ¼ of the lockup height).
  In the header, keep at least 16px between the logo and the nav or actions.
- Minimum lockup height is 25px (≈159px wide). Below that, use the leaf mark alone and keep the name in `aria-label`
  or visible text nearby.
- Stacked logo: minimum 150px wide (tagline legibility).

## Background contrast rules

- **Dark surfaces** (hero overlay, plum header glass `rgba(24,15,23,.92)`, plum sections `#2F1228`/`#3A1A31`): use the
  **light** lockup. Ivory wordmark on these plums is well above 7:1. Its `drop-shadow` keeps it legible over hero photos.
- **Light surfaces** (cream `#F6F0E8`, ivory, white): use the **colour** lockup (official plum and green ink), or the stacked logo.
- **Never** put the official-colour (plum) wordmark directly on a dark surface. If the stacked colour logo has to sit
  on a dark surface, put it on a cream plate (as in the footer).
- Don't place any logo on busy photography without the header's dark glass or a scrim.
- No filters other than the soft drop shadow. No opacity below 1, no recolouring in CSS, no outlines, no rotation.

## Responsive behaviour

- One `<picture>` element. Swap to the leaf mark only through `<source media>` (≤369px, 1280–1365px). Never hide the
  logo or replace it with text.
- Internal pages use the same header component (`variant="solid"`), so they get the same light lockup on the solid
  plum glass. No per-page logo markup.
