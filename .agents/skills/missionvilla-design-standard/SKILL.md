---
name: missionvilla-design-standard
description: Approved Mission Villa Senior Living design standard, taken from the finished homepage (2026-11-10). Use it whenever you design, port, build or review ANY Mission Villa page, section, modal or component, in the Laravel site (missionvilla-php) or elsewhere: internal pages (/memory-care, /respite-care, /suites-and-floor-plans, /about, …), new sections, forms, CTAs, imagery, typography, colour, spacing or motion. Trigger words: Mission Villa, port page, new section, design standard, homepage style.
---

# Mission Villa: Design Standard

The **homepage in `missionvilla-php` is the approved design reference** (client-approved 2026-11-10).
Every other page must look and behave like it. This skill is the rulebook. The code is the proof:
when this text and the homepage disagree, inspect the homepage, follow it, and update this skill.

Works for any agent (Claude Code, Codex, Antigravity, …). Paths are relative to `missionvilla-php/`.

## Read these before you start

| File | What it holds |
|---|---|
| `references/tokens.md` | Colours, fonts, type scale, spacing, radii, shadows, breakpoints, motion values |
| `references/components.md` | Recipes: eyebrow, titles, buttons, tabs, cards, accordion, badges, icons, leaf, wave, photos, header, footer, inquiry modal/form |
| `references/sections.md` | Anatomy of each approved homepage section (00–07 + footer), to reuse as page patterns |
| `references/porting-checklist.md` | Step-by-step workflow for a new page/section and the verification you must run before you call it done |
| `references/brand-logo.md` | Official logo assets: canonical source, approved variants, header/footer usage, spacing, responsive sizes, contrast rules |

Live sources: `resources/css/app.css`, `resources/css/components/editorial.css` (shared `--mv-*` tokens),
`resources/css/sections/*.css`, `resources/views/sections/*`, `resources/views/components/*`,
`docs/ARCHITECTURE.md`, `docs/SECTION_STATUS.md`, `docs/NEXT_SESSION.md`.

## Non-negotiable rules

1. **Port, don't redesign.** The look is set. New pages reuse the homepage's palette, type scale, components
   and spacing. No new creative direction, fonts, colours, decorative widgets, sliders or floating cards
   unless the user approves a mockup that asks for them.
2. **One type scale.** Use the `--mv-fs-*` tokens (Section 02's scale). Take layout, ink colours and character
   from a mockup, **never its pixel font sizes**. Scaling type from a mockup image is a known failure: it came out 25–30% too big.
3. **Shared tokens for new work.** Use `--mv-*` (editorial.css). Don't copy the per-section variants from
   Sections 02–04 (`#380C34`, `#B95A45`, …). They are known inconsistencies, listed in `tokens.md`.
4. **Form CTAs open the inquiry modal. Nothing scrolls to a form.** Any CTA whose destination is a form
   (visit, pricing, availability, callback, "ask our team", …) is
   `<a href="tel:16507561995" data-inquiry="<intent>">`. Never use `href="#visit"`, `#contact`, `#schedule-visit` or
   `scrollIntoView()` to reach a form. Leave non-form anchors and direct `tel:` links alone. Use ONE form partial
   (`<x-inquiry.form>`) and ONE endpoint (`POST /inquiries`). Never fork the submission logic. See `components.md` → Inquiry.
5. **Honesty.**
   - Never show fabricated prices, availability, clinical services, guarantees, awards, statistics or testimonials.
     Copy comes from verified content: the React reference data (`../missionvilla-ui-new/lib/mission-villa-data.ts`)
     and `config/missionvilla.php` (address, phone, licence).
   - Every image declares `provenance` (`facility` | `illustrative`) and `rights` (`cleared` | `unconfirmed`), and
     shows a small visible label.
   - Never present AI or stock imagery as the real community.
   - Forms never say "sent" unless it was. Today they say "saved, not yet sent".
6. **Content-driven height.** Use only the heights the homepage uses. Full-screen (100svh) bands are only for
   hero-like openers. Everything else takes its natural height plus padding. No `height: 100vh` on content
   sections, and no parent `overflow: hidden` that clips content.
7. **Restrained motion.** Only user-initiated motion: hover, tab or option cross-fades of about 0.2–0.45s ease,
   the accordion, the card flip. No scroll-triggered, parallax or auto-cycling animation (the hero slider is
   the only autoplay). Always honour `prefers-reduced-motion`.
8. **Accessible by default.**
   - Real `<button>`s and links; ARIA tabs/accordion patterns as on the homepage.
   - Visible focus rings: terracotta on cream, peach on plum.
   - Tap targets ≥ 44px; form inputs ≥ 16px.
   - Native `<dialog>` for modals.
   - No horizontal scroll at 320–1920px.
9. **CMS-ready, constrained content.** Each section is a schema class (`app/Content/Sections/*Section.php`)
   with strict validation limits that protect the layout, plus a Blade view and optional CSS/JS bundle. No
   free HTML: inline text allows `<em>` only.
10. **Don't silently drop reference features.** When porting from the React reference, list what you will not
    port and ask the user first.
11. **Never modify the React reference** (`missionvilla-ui-new`). **Never deploy** as a side effect. Deploying needs an explicit request.
12. **Official logo artwork only.** All Mission Villa branding must use official approved logo assets. Do not
    recreate the wordmark using generic HTML text or substitute typography. Use the light lockup on dark surfaces,
    the colour lockup or stacked logo on light ones, and never use a different leaf. See `references/brand-logo.md`.

## The look in one paragraph

Warm, editorial and residential. The page alternates **warm cream bands** (`#FBF4EC`, ink `#2F1228`) with
**deep plum bands** (`#47243D → #3A1A31`).
- **Accents:** terracotta (`#B6634B`; buttons `#C2705A → #A85840`) and peach (`#EDBE96`) on plum.
- **Titles:** Newsreader serif 500, with an italic terracotta `<em>` phrase on its own line ("Comfortable
  Suites & *Welcoming Spaces*").
- **Eyebrows:** Plus Jakarta Sans 600, uppercase, letter-spacing 0.34em, after a short terracotta rule.
- **Body:** Plus Jakarta Sans, soft ink `#6A5A5D`, line-height 1.6.
- **Shapes:** rounded corners (`--mv-radius` ≈ 18–26px), soft plum-tinted shadows, natural photography with
  a gentle lower gradient and a one-line italic caption.
- **Decoration:** a faint warm botanical leaf in a corner; a soft wave edge where cream meets plum.

## Minimal starter for a new cream section

```blade
<section class="xyz" id="xyz" aria-labelledby="xyz-title">
  <span class="mv-leaf xyz__leaf" aria-hidden="true"></span>
  <div class="xyz__inner">
    <p class="mv-eyebrow"><span class="mv-eyebrow__rule" aria-hidden="true"></span><span>{{ $data['eyebrow'] }}</span></p>
    <h2 id="xyz-title" class="mv-title">{!! \App\Content\InlineText::render($data['heading']) !!}</h2>
    <p class="xyz__intro">{{ $data['intro'] }}</p>
    <a href="{{ config('missionvilla.phone.href') }}" class="mv-btn mv-btn--primary" data-inquiry="visit">
      @include('partials.icon', ['name' => 'calendar', 'class' => 'mv-icon', 'stroke' => 1.6])
      <span>Schedule a Visit</span>
      @include('partials.icon', ['name' => 'arrow', 'class' => 'mv-icon mv-btn__arrow', 'stroke' => 2])
    </a>
  </div>
</section>
```
```css
.xyz { position: relative; isolation: isolate; background: var(--mv-cream); color: var(--mv-ink); }
.xyz__inner { display: grid; gap: clamp(1.75rem, 4vw, 2.75rem); padding: clamp(3rem, 9vw, 4.25rem) var(--mv-gutter); }
.xyz__intro { font-size: var(--mv-fs-body); line-height: 1.6; color: var(--mv-ink-soft); max-width: 34rem; }
@media (min-width: 1024px) { .xyz__inner { grid-template-columns: minmax(0, .92fr) minmax(0, 1.08fr); align-items: center;
  padding-block: clamp(3.25rem, 8svh, 5.5rem) clamp(3rem, 7svh, 4.75rem); } }
```

Then follow `references/porting-checklist.md` from step 1.
