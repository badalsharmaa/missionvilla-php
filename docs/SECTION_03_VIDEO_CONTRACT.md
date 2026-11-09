# Section 03 · Life at Mission Villa: video asset contract

_Written 2026-11-09. Audience: the Motion Studio Claude session that produces the three films._

The Laravel site is finished and waiting for media. **You do not need to change any Laravel
code.** Drop files that follow this contract into the folder below, run the checker, and the
homepage player picks them up on the next page load. Until a chapter's film exists, the site
shows that chapter's fallback still with a "Film in production" notice, so partial delivery is safe.

---

## 1. Location and exact file names

```
missionvilla-php/public/media/mission-villa/life-at-mission-villa/
├── media-manifest.json                 required (describes everything below)
├── living-spaces.mp4                   chapter 01
├── living-spaces-poster.webp
├── living-spaces.vtt
├── dining-daily-life.mp4               chapter 02
├── dining-daily-life-poster.webp
├── dining-daily-life.vtt
├── meaningful-connection.mp4           chapter 03
├── meaningful-connection-poster.webp
└── meaningful-connection.vtt
```

Optional extras (list them in the manifest if you make them):

| File | Purpose |
|---|---|
| `<id>-720.mp4` | 1280×720 lighter encode. Used on narrow screens and when the visitor has Save-Data on |
| `<id>.webm` | VP9 or AV1 alternate (only if it is smaller at equal quality) |
| `<id>-poster-960.webp` | 960×540 poster for phones |

Chapter ids are fixed and must match exactly: `living-spaces`, `dining-daily-life`,
`meaningful-connection`.

File-name rules (enforced): lower-case `a–z 0–9 . _ -` only, no spaces, no sub-folders, no `..`.
Names are resolved relative to the manifest. Remote URLs (Pexels, Unsplash, CDNs, YouTube) are
rejected by design.

## 2. Media formats

### Video (`.mp4`, required)

| Property | Requirement |
|---|---|
| Composition | 16:9, **1920×1080** preferred (1280×720 minimum for the primary file) |
| Codec | H.264 (High profile), `yuv420p`, progressive |
| Frame rate | 24, 25 or 30 fps, constant |
| Bit rate | ~5–8 Mbps for 1080p (CRF 20–23). Aim for **≤ 25 MB per film** |
| Container | MP4 with `+faststart` (moov atom at the front) so playback starts before the file finishes downloading |
| Length | 30–90 s recommended. Hard limit 1800 s |
| Burned-in text | **None**: no titles, captions, logos or lower thirds. The page supplies all copy, and captions come from the `.vtt` |
| Loop | Not needed. The player stops at the end and offers Replay |

Reference encode:

```bash
ffmpeg -i master.mov -c:v libx264 -profile:v high -pix_fmt yuv420p -crf 21 -preset slow \
  -r 25 -c:a aac -b:a 160k -ar 48000 -movflags +faststart living-spaces.mp4
# optional light version
ffmpeg -i master.mov -vf scale=1280:-2 -c:v libx264 -profile:v high -pix_fmt yuv420p -crf 23 \
  -preset slow -c:a aac -b:a 128k -movflags +faststart living-spaces-720.mp4
```

### Audio

- AAC-LC, 48 kHz stereo, 128–192 kbps. Normalise to about **−16 LUFS integrated**, true peak ≤ −1 dBTP.
- The player never autoplays. Sound starts only when the visitor presses Play.
- Silent films: omit the audio track **and** set `"audio": {"has_audio": false}`, so the volume
  controls are hidden.
- Licensed music only. Record the credit and licence in the manifest.

### Poster (`.webp`, strongly recommended)

- 1920×1080 WebP, quality ~80, **≤ 300 KB**. A representative, well-lit frame from the film.
- No text and no play-button graphics: the player draws its own.
- If a poster is missing, the site uses its local fallback still instead.

### Captions (`.vtt`)

- WebVTT, UTF-8, starting with `WEBVTT`. **Required whenever there is speech or narration.**
- For music-only films, provide short sound descriptions (e.g. `[Gentle piano music]`) or omit the
  captions entry (the CC button then hides).
- Leave cue positioning at its default. The player lifts default cues clear of its control bar.
  If you must position a cue, keep it out of the bottom 18% of the frame.
- Lines ≤ 42 characters, at most 2 lines per cue.

## 3. Composition safe areas

The player overlays UI on the frame. Keep faces and key action clear of these zones:

```
┌──────────────────────────────────────────────────────────┐
│ [provenance badge ~30% × 10%]                            │
│                                                          │
│                     ( play ~12% Ø )                      │  ← poster only
│                                                          │
│▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓ control bar: bottom 18% ▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓│
└──────────────────────────────────────────────────────────┘
```

On phones the frame is shown at ~330 px wide, so wide shots with tiny subjects read poorly.
Favour medium shots.

## 4. `media-manifest.json`

```json
{
  "schema": "missionvilla.life-gallery.media/v1",
  "version": "2026-11-10a",
  "section": "life-at-mission-villa",
  "generated_at": "2026-11-10T09:00:00Z",
  "chapters": [
    {
      "id": "living-spaces",
      "title": "Living Spaces",
      "description": "A slow walk through a sunlit suite and a quiet lounge.",
      "video": {
        "src": "living-spaces.mp4",
        "type": "video/mp4",
        "width": 1920,
        "height": 1080,
        "duration_seconds": 48.0,
        "alternates": [
          { "src": "living-spaces-720.mp4", "type": "video/mp4", "width": 1280 }
        ]
      },
      "poster": {
        "src": "living-spaces-poster.webp",
        "src_mobile": "living-spaces-poster-960.webp",
        "alt": "A sunlit suite with an armchair beside garden doors"
      },
      "captions": [
        { "src": "living-spaces.vtt", "srclang": "en", "label": "English", "kind": "captions" }
      ],
      "audio": {
        "has_audio": true,
        "type": "music",
        "description": "Soft acoustic guitar",
        "credit": "Track name, composer",
        "license": "Licence name / ID"
      },
      "provenance": {
        "type": "illustrative",
        "method": "ai-generated",
        "label": "Illustrative film · not actual residents or facility",
        "notes": "Generated in Motion Studio from text prompts; no real residents depicted."
      }
    }
  ]
}
```

Include all three chapters. The other two follow the same shape.

| Field | Rule |
|---|---|
| `schema` | Required, exactly `missionvilla.life-gallery.media/v1` |
| `version` | Optional, `A–Z a–z 0–9 . _ -`, ≤ 24 chars. Appended as `?v=` to every URL. **Bump it whenever you re-export a file under the same name**, or browsers may keep the old one |
| `chapters[].id` | Required, one of the three ids above, unique |
| `title` | ≤ 80 chars. Used as the player's accessible name ("Play video: …"). The visible heading comes from the CMS |
| `description` | ≤ 300 chars. Exposed to assistive tech as the video description |
| `video.src` | Required, `.mp4` or `.webm` |
| `video.type` | `video/mp4` (default) or `video/webm` |
| `video.width` / `height` | Integers, 320–3840 / 180–2160 |
| `video.duration_seconds` | Strongly recommended, 1–1800. Shown as `0:00 / m:ss` **before** any video bytes download, so it must match the real length |
| `video.alternates[]` | ≤ 4 entries `{src, type, width}`. The player picks the smallest source that is at least as wide as the player × devicePixelRatio (capped at 2), or the smallest when Save-Data is on |
| `poster.src` / `src_mobile` | `.webp` (preferred), `.jpg`, `.avif` or `.png` |
| `poster.alt` | ≤ 200 chars. Describe what is visible; do not claim it is Mission Villa |
| `captions[]` | ≤ 4 entries. `kind` is `captions`, `subtitles` or `descriptions`. The first track is the one the CC button toggles |
| `audio.has_audio` | `false` hides the volume controls |
| `audio.type` | `none`, `music`, `narration`, `ambient` or `mixed` |
| `provenance.type` | **Required.** `illustrative` or `facility` |
| `provenance.method` | **Required.** `ai-generated`, `motion-graphics`, `stock` or `filmed` |
| `provenance.label` | ≤ 80 chars. Shown on the player badge. Defaults to the CMS label "Illustrative film · not actual residents or facility" |

**Honesty rule (enforced):** `ai-generated`, `stock` and `motion-graphics` footage **must** be
`"type": "illustrative"`. A manifest that labels such footage `facility` is rejected as a whole,
and the site falls back to stills. `facility` is reserved for footage actually filmed at
995 East Market Street.

If the manifest is invalid, the site ignores it, logs a warning and keeps showing the fallback
stills. A broken player is never shown.

## 5. Validate before handing back

From `missionvilla-php/`:

```bash
php artisan missionvilla:life-media        # validates the manifest and checks every file exists
php artisan test                           # full suite (no files are needed for it to pass)
```

The checker exits 1 and lists every problem if the manifest is invalid. Otherwise it prints a
table of chapters showing which are playable.

Then open http://127.0.0.1:8010/?skipIntro=1#life-at-mission-villa, pick each chapter and press Play.

> The local dev server (`php artisan serve`) does not support HTTP Range requests, so dragging the
> timeline beyond what has downloaded may snap back during local testing. Production web servers
> (Apache/LiteSpeed on Hostinger) support Range, and seeking works there. This is not a media fault.

## 6. Content guardrails

The films may be illustrative, but they must not mislead.

**Supported by verified Mission Villa content** (React `lib/mission-villa-data.ts`):

- **Living Spaces:** private and shared suites, each with a private bathroom. Suites personalised with
  family photos and keepsakes. Inviting communal lounges. Family visits in common areas.
  A courtyard patio with garden seating.
- **Dining & Daily Life:** chef-prepared meals shared in a welcoming dining room. Group and
  one-on-one activities: music, reminiscence, art and creative projects, gentle movement.
  Familiar daily rhythms.
- **Meaningful Connection:** Legacies™ Memory Care's life-story approach (getting to know each
  resident's background, habits and favourite music). Companionship, dignity, family connection.

**Do not depict or imply:**

- that the people shown are actual Mission Villa residents, families or staff
- Mission Villa logos, signage, name badges or branded uniforms (the mockup's name badge is
  decorative and must not appear in film)
- amenities that are not listed above: pools, gyms, salons, cinemas, buses, gardens with water
  features, ocean views
- medical procedures, medication administration, clinical equipment or clinical claims
- identifiable real people without a signed release
- text on screen of any kind

## 7. What the player does (no action needed)

- Nothing downloads until Play is pressed: sources and caption files are attached on demand.
  Only the active chapter's poster loads.
- One `<video>` element is shared by all chapters. Switching chapters pauses, swaps the source,
  poster and captions with a short fade (instant with reduced motion), and remembers each
  chapter's position.
- Controls: play/pause, timeline with buffered range, elapsed/total time, mute and volume
  (mute only on touch devices), captions, fullscreen (native video fullscreen on iOS).
  Keyboard: Space/K, ←/→ ±5 s, J/L ±10 s, ↑/↓ volume, M, C, F, Home/End. Chapter tabs use arrow keys.
- Load failures show "This film couldn't be loaded" with a Try again button over the poster.
- CMS editors can override any chapter's video, poster or captions file. An editor override wins
  over the manifest. Editors cannot relabel manifest footage as facility footage.
