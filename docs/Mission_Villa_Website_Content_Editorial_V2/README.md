# Mission Villa Senior Living — Website Copy, Editorial V2

**Prepared:** November 19, 2026  
**Status:** Draft for content-writer review, client fact-check, then developer handoff. **Not production-approved.**

## Why this version exists
The supplied “Refined Working Copy” contains 13 Markdown pages but remains lengthy, repetitive, and written partly like a design specification. This version takes a stronger editorial approach: **short public copy first; supporting details in appropriate subpages, FAQs, and future blogs.**

The two ZIP uploads provided on November 19 were byte-identical. This revision is based on that source. No public website, server, repository, or existing page was edited.

## Package contents
- `pages/` — **13 rewritten page files**, with the same file names, route slugs, source PHP references, and retained section identifiers used in the writer's archive.
- `CONTENT_MAP.md` — What changed by page, including removed/merged sections.
- `BLOG_CONTENT_PLAN.md` — A focused plan for longer educational material removed from pages.
- `PUBLISHING_CHECKLIST.md` — Factual, operational, photo, inquiry-form and SEO confirmations to complete.

## Editorial rules followed
- Answer the visitor's immediate question in a clear headline and 1–2 short paragraphs.
- Use short image-led cards and no more than 2–4 helpful FAQs per page.
- Avoid “monograph,” “folio,” “ledger,” “journey,” grand care promises, made-up quotes, imagined staff testimonials, and overly sentimental stock wording.
- Keep the website **Memory Care / Short-Term Respite Care only**. Do not add standalone independent living or general assisted-living service pages.
- Preserve the source's community identity, core care descriptions, suite types, contact details, and existing paths where relevant. Do not fabricate rates, licensing facts, room details, promises, or medical services.
- Preserve the approved website layout direction: compact, visually led sections on desktop; mobile stacking; minimal long-scroll content.
- **Every form-intent CTA should open the shared inquiry modal with the matching request type/care interest preselected.** Non-form navigation should remain regular links. The current underlying form may be a demo; the developer must verify actual submissions before enabling production.
- Photographs marked “illustrative” must remain labelled, and real property photographs require approval/rights verification. Do not represent illustrations as actual residents or rooms.
- Future educational articles live in `/blog` or Resources only after they exist and are reviewed. These files do not invent live blog content.

## Handoff workflow
1. **Content writer** edits tone/wording, approves or revises headings and answers, and identifies needed client confirmations.
2. **Client/community director** confirms license, phone/email, offerings, suites, service claims, current visiting/booking policies, pricing disclosures, and assets.
3. **Developer** maps fields into existing templates by retained section key, removes sections retired in `CONTENT_MAP.md`, preserves working interactions and design, and tests mobile/desktop layouts. No requirement to rebuild the website.
4. **Marketing/QA** checks on-page content, image authenticity labels, SEO metadata, links, modal preselection, accessibility, and actual inquiry delivery.

### Important implementation note
These Markdown files are **editorial handoff documents**, not executable PHP or a CMS export. The source PHP paths and section keys are references. The developer must apply the approved copy to the website/CMS. Comments and publishing notes inside `.md` files are **not public page text**.
