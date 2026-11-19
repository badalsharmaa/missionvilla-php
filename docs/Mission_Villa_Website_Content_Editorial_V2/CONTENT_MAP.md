# Website Copy V2 — Page-by-Page Change Map

Use this file to guide review and development. **The file names, URLs, and retained Section Keys match the November 19 source archive.** If a section key is absent from the revised page, the writer recommends hiding/removing that public-facing section rather than reusing the old lengthy copy. This is a content recommendation, not a code migration.

| Page | Main change | Removed/merged source sections | Target visitor experience |
|---|---|---|---|
| `home.md` | Shorter 3-slide hero; 2 care cards; 3 life tabs; 3 FAQs | None; all approved homepage sections retained but copy drastically condensed | Strong visuals, fast understanding, visit CTA |
| `about.md` | One short story; three principles; location and team introduction | `about-core-values` merged into philosophy; pet policy withheld | Know who we are without reading four essays |
| `memory-care.md` | Three Legacies™ points; sample daily rhythm; concise FAQs | Four long chapters condensed within `mc-legacies`; no section removal | Explain memory care without repeating other pages |
| `respite-care.md` | Three reasons for a stay; inclusions; three planning steps | `rc-story`, `rc-caregiver` merged into scenarios and planning | Check fit and dates quickly |
| `living-options.md` | Clear two-program comparison; suite snapshot | `lo-setting` moved to Life and Services | Decide between Memory Care and Respite |
| `suites-and-floor-plans.md` | Three formats, one conditional floor-plan image | `sfp-features` withheld until room-specific claims verified | Compare accommodation options visually |
| `life-at-mission-villa.md` | Three lifestyle pillars and a typical-day overview | `lmv-engagement` moved to future activity/blog content | Get a sense of life here without minute-by-minute detail |
| `services-and-amenities.md` | Four concise service groups; included-versus-extra explanation | `sa-diptych`; large itemized explorer shortened | Understand key offerings, ask about specifics |
| `gallery.md` | Five source-labelled property images and short captions | `gallery-pathways`; 10 photo essays reduced to five | Let photography speak |
| `financial-planning.md` | Four pricing factors; inclusions; compact optional worksheet | `fp-pathways` moved to specialist-reviewed articles | Ask for accurate quotes, avoid fabricated savings |
| `for-families.md` | Three starting options; three tour questions; four FAQs | `ff-bridge` and large guides removed | Help families take the first step |
| `resources.md` | Four useful links; request for real materials | `res-faq`; technical brochure/blog-status interface removed | A clean gateway to help, not a development log |
| `contact.md` | Contact details, four inquiry intents, short arrival info | `contact-workflow`, `contact-referral`, `contact-faq` | Quick access to team; functional modal inquiry |

## Content architecture
- **Primary pages:** Home, Memory Care, Respite Care, Living Options, Suites, Life, About, Services, Gallery, Contact.
- **Secondary support:** For Families, Financial Planning, Resources.
- **Optional education:** Future articles/blog archive, only after researched, edited, approved, and published. Link to them from secondary pages as appropriate.

## Design and development guardrails
1. Retain existing approved animations and art direction. Rewrite does **not** authorize an unrequested site redesign.
2. No more than three columns/cards per visual row on desktop; render responsive stacks on mobile. Service categories are four grouped entries, not a 20+ card explorer.
3. FAQ sections use short collapsed accordions, not a second page of body text.
4. The home page retains all seven approved major section areas and the intro shutter, but with drastically reduced copy.
5. Any form-related CTA opens the shared modal with the intended action preselected; regular navigation stays a link.
6. Old comments, status labels, placeholders, and `CLIENT CONFIRMATION REQUIRED` markers stay off the public website.
7. The final copy does not require a blog to exist on day one. Hide blog links until the articles are live.
8. Check any existing component binding that expects more cards or fields; remove surplus UI rather than filling it with the discarded copy.
