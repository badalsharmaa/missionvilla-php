---
trigger: always_on
description: Mission Villa design standard (approved homepage) — must be followed for every page/section port.
---

# Mission Villa design standard (always on)

Before designing, porting, building or reviewing ANY Mission Villa page, section, modal or component,
read and follow `.agents/skills/missionvilla-design-standard/SKILL.md` and its `references/` files.
They hold the approved homepage design rules: tokens, type scale, components, section patterns,
the porting workflow and the done-checklist.

Non-negotiables (details in the skill):
- Port, don't redesign. Reuse `--mv-*` tokens and the Section 02 type scale. Never size fonts from a mockup.
- Form CTAs open the shared inquiry modal (`data-inquiry="<intent>"` + `tel:` fallback). Never scroll to a form.
- Honesty: no fabricated facts or prices; every image carries provenance/rights + a visible label.
- Content-driven section heights. User-initiated motion only. Respect reduced motion.
- Official logo artwork only (`references/brand-logo.md`). Never recreate the wordmark as HTML text or substitute typography.
- Never modify the React reference (`missionvilla-ui-new`). Never deploy as a side effect.
