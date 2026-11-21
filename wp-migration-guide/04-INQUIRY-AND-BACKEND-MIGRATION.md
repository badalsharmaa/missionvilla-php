# 04 — Inquiry Engine, Database, Media Manifest & WP-CLI Seeder
## Phase 2 Blueprint: Exact Backend Parity with Laravel

---

## 1. Inquiry Lead Storage Table (`inc/inquiries-db.php`)

Port `database/migrations/2026_11_09_000300_create_lead_submissions_table.php` into WordPress using `dbDelta()` on theme activation (`after_switch_theme`):

- **Table Name:** `{$wpdb->prefix}mv_lead_submissions`
- **Columns:**
  - `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
  - `uuid` CHAR(36) NOT NULL UNIQUE
  - `idempotency_key` CHAR(36) NOT NULL UNIQUE
  - `kind` VARCHAR(40) NOT NULL (`visit_request`, `pricing_request`, `availability_request`, `callback_request`, `general_inquiry`)
  - `care_interest` VARCHAR(80) NULL
  - `payload_encrypted` LONGTEXT NOT NULL (AES-256-GCM encrypted JSON containing `contact`, `details`, `consent`, `attribution` using key derived from `wp_salt('auth')` — preserving Laravel's encrypted lead storage discipline!)
  - `delivery_status` VARCHAR(24) NOT NULL DEFAULT `'not_connected'` (`not_connected` | `pending` | `delivered` | `failed`)
  - `created_at` DATETIME NOT NULL
  - `updated_at` DATETIME NOT NULL
- **Admin Viewer:** Add a submenu **Mission Villa → Inquiries** (`manage_options` capability only) displaying decrypted leads in a clean `WP_List_Table` with reference code (`strtoupper(substr($uuid, 0, 8))`), kind, contact summary, source section, UTM attribution, and CSV export.

---

## 2. Inquiry REST API Endpoint (`inc/inquiries-rest.php`)

Port `App\Http\Controllers\InquiryController` and `App\Http\Requests\InquiryRequest` **1-to-1** to a WordPress REST route:

- **Endpoint:** `POST /wp-json/missionvilla/v1/inquiries`
- **Permission Callback:** `__return_true` (public form, protected by WP REST Nonce `X-WP-Nonce`, honeypot, idempotency UUID, and IP rate limiter).
- **Exact Validation Rules (Mirroring `InquiryRequest.php`):**
  1. `company_website` (honeypot): MUST be empty; if filled, return `422` `{ errors: { company_website: ["We could not accept this request."] } }`.
  2. `idempotency_key`: Required valid UUID v4. If already exists in `wp_mv_lead_submissions`, return the existing lead's `201` response without creating a duplicate.
  3. `intent`: Required, must be one of `schedule_visit`, `request_pricing`, `request_availability`, `request_callback`, `general_inquiry`.
  4. `first_name`: Required, trimmed string, max 60 chars.
  5. `last_name`: Optional, trimmed string, max 60 chars.
  6. `phone`: Required if `intent === 'request_callback'`, otherwise required if `email` is empty. Regex `/^[0-9+().\-\s]+$/`, 10–15 digits.
  7. `email`: Required if `phone` is empty, valid email (`is_email()`), max 120 chars.
  8. `care_interest`, `suite_preference`, `contact_time`, `source`: Whitelisted against exact arrays from `config/missionvilla.php`.
  9. `marketing_opt_in`: Boolean (default `false`).
  10. `page_url`, `utm_source`, `utm_medium`, `utm_campaign`, `utm_term`, `utm_content`, `gclid`, `fbclid`: Sanitized optional strings.
- **Per-IP Rate Limiting (Mirroring `AppServiceProvider::boot()`):**
  - Use WordPress Transients keyed by `mv_inq_min_` . md5($ip) (limit **5/minute**) and `mv_inq_day_` . md5($ip) (limit **20/day**).
  - Return HTTP `429` when exceeded.
- **Exact Response Contract (So `inquiry-dialog.js` Needs Minimal Changes):**
  - `201 Created`:
    ```json
    {
      "status": "received",
      "intent": "schedule_visit",
      "reference": "A1B2C3D4",
      "delivered": false,
      "delivery": "not_connected",
      "message": "Your request was saved on this website, but it has not been sent to Mission Villa’s team yet: online requests are not connected while the site is in development. To arrange this now, please call (650) 756-1995."
    }
    ```
  - `422 Unprocessable Entity`: `{ "errors": { "field_name": ["Error message"] } }`
  - `503 Service Unavailable`: `{ "status": "disabled", "message": "..." }` when inquiry storage is disabled.
- **No-JS Fallback:** Also register an `admin_post_nopriv_mv_inquiry` / `admin_post_mv_inquiry` handler (or let the inline form post to REST with redirect fallback) so non-JS submissions work identically.

### Minimal Adaptation to `src/js/components/inquiry-dialog.js`
In `inquiry-dialog.js`, update ONLY the `fetch()` URL & header:
```js
const res = await fetch(window.MissionVillaConfig?.restUrl || form.action, {
  method: 'POST',
  headers: {
    Accept: 'application/json',
    'X-WP-Nonce': window.MissionVillaConfig?.nonce || '',
  },
  body: new FormData(form),
  credentials: 'same-origin',
});
```
Keep EVERY other line of `inquiry-dialog.js` (focus management, `SECTION_SOURCES`, aliases, intent switching, `window.MissionVilla.openInquiry`, `window.MissionVilla.openVisit`) **100% identical**!

---

## 3. Video Media Manifest (`inc/helpers.php` → `MV_Life_Gallery_Manifest`)

Port `app/Content/Media/LifeGalleryManifest.php` cleanly into `inc/life-gallery-manifest.php`:
- Reads `public/media/mission-villa/life-at-mission-villa/manifest.json` (copied to `wp-content/themes/missionvilla/assets/media/mission-villa/...` OR `wp-content/uploads/mission-villa-media/...`).
- Enforces the exact same schema (`missionvilla.life-gallery.media/v1`) and honesty guard (never allows `facility` provenance with `ai-generated`/`stock`/`motion-graphics`).
- Verifies every `.mp4`/`.webm`/`.vtt`/poster file exists on disk before passing to `blocks/life-gallery/render.php` and `blocks/why-families/render.php`.

---

## 4. Automated WP-CLI Content & Media Seeder (`inc/cli-seeder.php`)

To guarantee **zero manual copy-paste errors** across 13 pages and 84 section instances, build a WP-CLI command suite that reads directly from this repository's `content/pages/*.php` and `public/images/`:

### Commands to Implement
1. **`wp mv import-media --source=/path/to/missionvilla-php-repo/public/images`**
   - Imports all 49 image files (`brand`, `care`, `decor`, `hero`, `illustrative`, `life`, `property`, `suites`, `why-families`) into the WordPress Media Library (idempotent: checks custom post meta `_mv_source_path` so re-running never duplicates attachments!).
   - Saves a mapping table (`option: mv_media_map`: `'/images/hero/...' => attachment_id`).
2. **`wp mv seed-menus`**
   - Reads `config/navigation.php` and creates/updates the 4 WP Nav Menus (`primary` including parent/child hierarchy + `post_content` descriptions!, `footer_care`, `footer_explore`, `footer_legal`) and assigns them to their theme locations.
3. **`wp mv seed-page <slug> --source=/path/to/missionvilla-php-repo`**
   - Loads `content/pages/<slug>.php` directly in PHP.
   - Maps each section's `type` (e.g. `about.hero`) → WordPress block name (`missionvilla/about-hero`).
   - Resolves any `/images/...` strings inside section `data` into `{ id: <attachment_id>, url: <wp_attachment_url>, ... }` using `mv_media_map`.
   - Serializes all sections into valid Gutenberg block grammar using WordPress's native `serialize_blocks($blocks)`.
   - Creates or updates the WordPress Page with the exact slug (`living-options`, `memory-care`, etc.), SEO title/description post meta, and `header_variant` post meta.
   - For `home`: sets `show_on_front = 'page'` and `page_on_front = $home_page_id`, and sets permalinks to `/%postname%/` (`wp rewrite flush`).
4. **`wp mv seed-all --source=/path/to/missionvilla-php-repo`**
   - Runs `import-media`, `seed-menus`, and `seed-page` for all 13 slugs in sequence.
5. **`wp mv verify-blocks`**
   - Audits all 13 pages in WP DB to confirm every block parses cleanly (`parse_blocks()`), every referenced `missionvilla/*` block is registered, and zero broken image IDs exist.
