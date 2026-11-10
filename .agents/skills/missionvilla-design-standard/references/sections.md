# Approved homepage sections: patterns to reuse

Order and register (C = cream band, P = plum band):

| # | Section (`type`) | Register | Height (desktop) | Pattern to reuse on internal pages |
|---|---|---|---|---|
| 00 | Opening shutters (`intro.shutters`) | Dark | Overlay | Homepage only. Plays once, skippable, off for reduced motion |
| 01 | Cinematic hero (`hero.cinematic`) | Dark plum `#180F17`, photo with scrim | 100svh | **Page hero** pattern: photo, left-weighted plum scrim (90deg .96 → 0), serif headline with peach italic `<em>`, terracotta primary CTA. Internal pages may use a shorter (≈60–70svh) static version with no slider |
| 02 | Care Options (`care.options`) | C | min 100svh | **Two-option comparison**: centred eyebrow/title, two plum flip cards (front photo dissolving into plum, back benefits + CTA), outline pill "Schedule a Visit" below |
| 03 | Life at Mission Villa (`life.gallery`) | C | min 100svh | **Chaptered media**: vertical tab list + 16:9 player + info card per chapter, provenance badge, "film in production" state |
| 04 | Why Families (`trust.why-families`) | C into P strip | min 100svh | **Story + facts**: wide photo with cream wash, narrative + CTA left, glass "At a Glance" panel, plum values strip with a wave edge |
| 05 | Suites & Living Spaces (`living.suites`) | C | content (≈75vh) | **Option selector**: narrative + 3 compact tabs left, large photo frame right (kicker + one-line caption), 2 centred actions below |
| 06 | FAQs (`faq.featured`) | C (separated by hairline) | content (≈53vh) | **Q&A**: intro + leaf left, one grouped accordion card right, answer links open the modal |
| 07 | Come See Mission Villa (`visit.cta`) | P with wave top | content (≈85vh) | **Closing conversion**: script eyebrow + title + invitation, 3 vertical CTAs, address/phone left; divider; cream inline inquiry card right. **End every internal page with this section** (reuse the `visit.cta` type) |
| — | Footer (`<x-site.footer>`) | P `#3A1A31` | content | Global |

Rhythm: cream bands with one strong plum moment in the middle (04's strip) and a plum close (07 + footer).
Internal pages should keep that rhythm: dark or photo hero, then cream content bands, then the plum
`visit.cta` close, then the footer.

## Desktop composition rules seen across the homepage
- **Two columns, text first.** Narrative on the left, media or interactive object on the right
  (02 and 03 centre their heads instead). Columns align to centre vertically.
- **One focal object per section:** a photo frame, a card pair, a player or an accordion. Never two competing ones.
- **CTAs:** one primary per section, at most two actions in a row, always ending with an up-right arrow.
- **Copy density:** heading, intro of 1–2 sentences, then the object. Answers and captions stay short (FAQ answer
  ≤ 420 chars, photo caption ≤ 56 chars, card copy 2–3 sentences).

## Mobile composition
- Everything stacks in source order (text, then media, then actions). No viewport-height rules.
- Tabs stay a 3-up row (icon over label under 480px). Buttons go full width. Form fields go one per row under 480px.
- The fixed header is 4.5rem tall; nothing important hides under it.

## Copy voice
Warm, plain, reassuring, never salesy or clinical. "Your loved one", "families", "unhurried".
Product names stay exact: **Legacies™ Memory Care**, **Short-Term Respite Care**. Facts come only from
`config/missionvilla.php`: 995 East Market Street, Daly City, CA 94014; (650) 756-1995; CA RCFE License #415601046.
