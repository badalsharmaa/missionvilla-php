# 06 — Visual QA, Functional & Gutenberg Parity Checklist

Each phase and page should pass all four verification stages below before advancing in `PROGRESS-TRACKER.md`.

---

## Stage 1: Side-by-Side Visual Parity (Laravel `:8010` vs Local WordPress)

Run the Laravel reference at `http://127.0.0.1:8010` alongside your local WordPress instance and compare screenshots across four primary viewports (`375×812`, `768×1024`, `1366×768`, `1920×1080`), plus overflow checks at `320px` and `1280px`.

### Recommended Automated Playwright Check Outline
1. Launch Chromium with `reducedMotion: 'reduce'` so GSAP timelines and CSS transitions settle cleanly for screenshot comparison.
2. Wait for `document.fonts.ready`, `networkidle`, and all `<img>` elements to finish loading.
3. Verify `document.documentElement.scrollWidth <= window.innerWidth` at every viewport (zero horizontal overflow).
4. Confirm zero browser `console.error` entries and zero HTTP `>= 400` asset requests.
5. Compare computed styles (`fontFamily`, `fontSize`, `fontWeight`, `lineHeight`, `color`, `backgroundColor`) on `h1`, `h2`, `p`, `.mv-eyebrow`, `.site-header`, and `.site-footer`.
6. Capture full-page screenshots for both sites and run a pixel diff (`pixelmatch`); target `< 0.5%` diff and inspect any discrepancy over `0.2%`.

---

## Stage 2: Interactive & Functional Parity

Verify these behaviors on every migrated page:

1. **Global Header:**
   - Transparent overlay at scroll `0px` transitioning to compact solid plum bar past `88px` (`.is-scrolled.is-compact`).
   - Desktop dropdown menus (`Living Options`, `Life at Mission Villa`, `Resources`) show item descriptions and `↗` arrows, and close on Escape or outside click.
   - Responsive logo swaps to `mission-villa-mark-160.webp` at `<=369.98px` and `1280–1365.98px`.
   - Mobile drawer toggles cleanly below `1280px` and closes before opening the Inquiry Modal.
2. **Global Inquiry Modal & Inline Form:**
   - Every `[data-inquiry]` CTA opens `<dialog id="inquiry-dialog">` with the matching `intent`, `source`, `care`, and `suite` preselected (never scrolls to a form anchor).
   - Invalid submission returns HTTP `422` with inline error messages and `aria-invalid="true"`.
   - Valid submission returns HTTP `201` with an 8-character reference code, writes an encrypted row to `wp_mv_lead_submissions`, and displays the honest delivery status message.
   - Duplicate submission with the same `idempotency_key` does not insert a duplicate row.
   - Populating the hidden `company_website` honeypot returns HTTP `422`.
   - Exceeding 5 submissions/minute or 20/day from one IP returns HTTP `429`.
3. **Section-Specific Scripts (36 Interactive Sections):**
   - Tabbed sections switch panels cleanly and update `aria-selected`.
   - FAQ accordions toggle and update `aria-expanded`.
   - Home GSAP shutters, 3-slide cinematic hero autoplay/pause/keyboard controls, and Care Chat modal function identically.
   - Gallery masonry category filters and lightbox modal (open, next, prev, Escape) function identically.
   - Financial Planning interactive worksheet calculations and For Families checklist states function identically.
   - Contact Studio tabs/steps and Directions selector function identically.

---

## Stage 3: Native Gutenberg Block Editor Round-Trip Test

Open each migrated page in WP Admin (`/wp-admin/post.php?post=<ID>&action=edit`) and verify:

1. **Clean Block Parsing:** Zero block validation warnings across all blocks on the page.
2. **Editor Canvas Fidelity:** All blocks render inside the Gutenberg `apiVersion: 3` iframe with Mission Villa's colors, Google Fonts (`Newsreader`, `Plus Jakarta Sans`, `Allura`), and full-bleed layout—with `intro-shutters` collapsed into a compact editable preview banner so it does not cover the page.
3. **Inline Text Editing:** Click directly on a heading (including an italic `<em>` span) and body paragraph, update the text, save the page, and confirm the frontend displays the updated text with intact styling.
4. **Media Library Replacement:** Swap an image via `<MediaUpload>`, update its alt text and provenance label (`facility` vs `illustrative`), save, and verify the updated image renders on the frontend.
5. **Repeater & Inspector Controls:** Add, reorder, or remove an item (card, FAQ, slide, or step) via the Block Inspector, confirm schema `min`/`max` guardrails work, save, and verify frontend grid alignment.
6. **Restore Seeded Content:** Re-run `wp mv seed-page <slug>` after QA so the page matches the verified repository content.

---

## Stage 4: Final Phase 15 Production Readiness Check

- [ ] `wp mv verify-blocks` passes across all 13 pages (84 block instances, 71 registered blocks, zero missing media IDs).
- [ ] Full 13-page Playwright parity sweep passes across all 4 viewports (52 comparisons).
- [ ] All internal links across header, footer, and page sections return HTTP `200`.
- [ ] `prefers-reduced-motion: reduce` disables motion cleanly.
- [ ] Production `npm run build` outputs self-contained `build/` assets requiring no Node.js runtime on the production server.
- [ ] Updating NAP, phone, or license in WP Admin → Mission Villa Settings propagates globally to Header, Footer, Hero, and Inquiry Modal.
- [ ] WP Admin → Mission Villa → Inquiries lists decrypted leads for Administrators only.
