# Section Status

Workflow: **Reference (React) → Design approval → PHP implementation → Validation → Commit.**
React is never modified. Statuses: `Pending` · `In design review` · `Approved` · `Implemented in PHP` · `Tested`.

## Global

| Component | Status | Source of truth | Notes |
|---|---|---|---|
| Site header / navigation | **Tested** | React `components/HeaderAndUtilityBar.tsx` (structure, nav, logo) | Transparent overlay variant built for the cinematic hero. React's utility ribbon (address, Text Comfort A/A+/A++ control) is not ported yet. See open decisions |
| Footer | Pending | React `components/VisitAndFooterSection.tsx` | Not implemented. Awaiting decision |

## Homepage (`/`)

| # | Section | Status | Source / approval | Notes |
|---|---|---|---|---|
| 0 | Opening scene: French conservatory shutters | **Tested** | React `components/ConservatoryShutters.tsx` | Implemented 2026-11-09. Same timeline as React (readable beat at 1.05s, panels part at 1.35s over 1.35s, `expo.inOut`). Hero headline rises and content fades in as the seam parts. Skip Intro, Esc, reduced-motion and `?skipIntro=1` skip it. Editable copy, can be disabled in content |
| 1 | Cinematic hero + Care Guide preview | **Tested** | `mission_villa_cinematic_hero_final.html` (approved prototype) | Implemented 2026-11-09. Geometry verified identical to prototype. Desktop, mobile and interactions checked |
| 2 | Care options (React `CareOptionsSection`) | Pending | React reference | Not migrated. Awaiting keep / modify / redesign decision |
| 3 | Approach & life (React `ApproachAndLifeSection`) | Pending | React reference | Not migrated |
| 4 | Suites & family (React `SuitesAndFamilySection`) | Pending | React reference | Not migrated |
| 5 | Visit & footer (React `VisitAndFooterSection`) | Pending | React reference | Not migrated |

React's homepage `HeroStage` is superseded by the approved cinematic hero. The
`ConservatoryShutters` opening scene **is kept** and now plays in front of the cinematic hero.
(Phase 1 initially left it out by mistake; corrected the same day.)

## Internal pages

All internal pages exist only in the React reference (`draft-for-review` there) and are
**Pending** for PHP: `/living-options`, `/memory-care`, `/respite-care`, `/suites-and-floor-plans`,
`/life-at-mission-villa`, `/services-and-amenities`, `/gallery`, `/about`, `/financial-planning`,
`/for-families`, `/resources`, `/contact`. `/blog` is not started anywhere.

## Validation log

| Date | Section | Checks | Result |
|---|---|---|---|
| 2026-11-09 | Header + hero | Geometry vs prototype at 1920×796; header fit at 320, 360, 375, 390, 414, 768, 1024, 1280, 1366, 1440, 1536, 1700, 1920; no horizontal overflow; autoplay, chapter tabs, pause, header CTA → visit dialog, demo submit ("nothing was sent"), Esc close + focus return, Care Guide quick question + free text, desktop dropdowns, mobile drawer + scroll lock, image-failure fallback; no console errors; 18 automated tests | Pass. Fixed during validation: small-phone header overflow, translucent mobile drawer |
| 2026-11-09 | Opening shutters | Timeline sampled against wall-clock (desktop): closed → taglines fade → part → open → overlay removed, at React timings (+~0.7s page load); hero autoplay starts only after opening; Skip Intro; `?skipIntro=1`; 390px and 768px layout; 20 automated tests | Pass. Note: at ≤390px the centred Skip pill overlaps the bottom footer lines (same as React) |
| 2026-11-09 | Hero | `prefers-reduced-motion` path | **Not browser-verified** (logic ported unchanged from prototype) |
