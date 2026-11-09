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
| 2 | Care options: "Two Paths. One Commitment to Care." (`care.options`) | **Tested** | Approved mockups (2026-11-09): default faces + hover-flipped Memory Care card. Copy condensed from React `CareOptionsSection` / `CARE_PROGRAMS` | Implemented 2026-11-09. Full-bleed, ~100svh on desktop, stacked on mobile. Two independent flip cards: hover (fine pointers), corner toggle (keyboard/mouse/touch), tap on touch, Esc to return; hidden face is `inert`. Respite back face designed to mirror the Memory Care mockup. Schedule a Visit and Care Guide reuse the hero dialogs. Leaf shadows from `public/images/decor/botanical-leaf-shadow.svg` with CSS blur/opacity. No scroll-driven or automatic motion. Images are React's illustrative `care-memory` / `care-respite` (AI, labelled `illustrative`) |
| 3 | Life at Mission Villa: "A Closer Look at Life Here" (`life.gallery`) | **Tested** (films pending) | Approved mockup "Life at Mission Villa: A Closer Look" (2026-11-09). Copy condensed from verified React content (`lib/mission-villa-data.ts`: suites, dining, daily engagement, Legacies™ life-story approach) | Implemented 2026-11-09. Three ARIA-tab chapters (vertical on desktop, compact row on mobile) share one 16:9 custom HTML5 player plus an info card. User-initiated only: no autoplay, scroll triggers or cycling. Films are delivered separately per `docs/SECTION_03_VIDEO_CONTRACT.md` (manifest + files in `public/media/mission-villa/life-at-mission-villa/`); until then each chapter shows an illustrative fallback still (`public/images/life/`, AI images from the React set) with a "Film in production" notice. Chapter CTAs link to `/suites-and-floor-plans`, `/life-at-mission-villa`, `/memory-care` once those routes exist, and open the hero visit dialog until then. Schedule a Visit and Care Guide reuse the hero dialogs. Typography follows the Section 03 mockup (Newsreader 600, plum `#380C34`) |
| 3b | Approach & life (React `ApproachAndLifeSection`) | Pending | React reference | Not migrated. Partly overlaps Section 03; decide keep / drop |
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
| 2026-11-09 | Care options | Section height vs viewport (iframe harness): 1280×720, 1366×768, 1440×800, 1440×900, 1536×864, 1672×941 (mockup size), 1920×950, 2560×1440 = exactly 100svh; 1920×1080 = 1084px (+4); 1366×650 = 711px (short screen, accepted). No horizontal overflow at 320–2560. No clipped face content at 320, 390, 768, 1024, 1280, 1440, 1920. Default + flipped states compared against both mockups at 1672×941. Hover hand-off between cards (real mouse); keyboard toggles flip both cards independently, focus moves into the visible back face only; Esc; tap toggle at 390px; Schedule a Visit → hero visit dialog (focus to care select, Esc closes, focus returns); Care Guide link → hero Care Guide dialog; no console errors; 30 automated tests | Pass. Adjusted during validation: compact back face (audience beside button) for desktop heights ≤960px; height-aware padding; tile contrast over photos on mobile |
| 2026-11-09 | Care options | `prefers-reduced-motion` (cross-fade instead of rotation) and real iOS/Android touch | **Not browser-verified** (CSS/JS paths present; mobile checked in iframe harness with scripted taps) |
| 2026-11-09 | Life at Mission Villa | Headless Chrome (Playwright, system Chrome for H.264). Section height: 1280×720, 1366×768, 1440×900, 1672×941 (mockup), 1920×800, 1920×1080, 2560×1440 = exactly 100svh. 1024×768, 768×1024, 390×844, 360×740, 320×640 flow naturally. No horizontal overflow at 320–2560. Geometry at 1672×941 vs mockup: player 846×476 at x=398 (mockup 843×474 at x=392). 43 scripted interaction checks with a temporary 12 s test clip served with HTTP Range (removed before commit): no mp4/vtt request before Play; play/pause; controls auto-hide; K/J/←/→/M/F keys; seek slider + aria-valuetext; volume; captions (cues lifted above controls); fullscreen enter/exit; chapter switch pauses, fades, swaps source/poster/captions/info; missing-file chapter shows the unavailable notice with no `<source>`; per-chapter resume; player + info heights stable across chapters; arrow-key tabs (wrap); fallback CTA + Schedule a Visit open the hero visit dialog, Esc closes; Care Guide link revealed; 404 film → error state with Try again; reduced-motion switch is instant; mobile tap play/tab, horizontal tablist, mute-only; no console errors. 55 automated tests | Pass. Fixed during validation: Chrome downloads on `load()` despite `preload="none"` (sources now attach on Play); captions overlapped the control bar; typography matched to the mockup (weights, sizes, plum ink); short-screen height budget |
| 2026-11-09 | Life at Mission Villa | Real films, real iOS/Android devices, screen readers (NVDA/VoiceOver) | **Not verified**. Films not produced yet. iOS uses native video fullscreen (code path present, untested on a device) |
