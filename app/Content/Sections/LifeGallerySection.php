<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Content\Media\LifeGalleryManifest;
use Illuminate\Support\Facades\Validator;

/**
 * Homepage section 03: "Life at Mission Villa: A Closer Look at Life Here".
 *
 * Three user-selected video chapters sharing one 16:9 player, with a short
 * information panel per chapter. The film files are produced separately (see
 * docs/SECTION_03_VIDEO_CONTRACT.md) and described by a JSON manifest.
 *
 * Media resolution per chapter, highest priority first:
 *   1. CMS overrides in `chapters.*.media` (editor-chosen files)
 *   2. The media manifest entry with the same `media.manifest_id`
 *   3. `fallback_poster`: a still image with an honest "film in production" state
 * A video source is only emitted when its file exists on disk, so the page can
 * never render a dead player.
 */
final class LifeGallerySection implements SectionSchema
{
    public const CHAPTER_COUNT = 3;

    /** Icons the view knows how to draw (resources/views/sections/life-gallery/icon.blade.php). */
    public const ICONS = ['home', 'dining', 'people'];

    public const DEFAULT_MANIFEST = '/media/mission-villa/life-at-mission-villa/media-manifest.json';

    public function __construct(private readonly ?LifeGalleryManifest $manifest = null) {}

    public static function type(): string
    {
        return 'life.gallery';
    }

    public static function label(): string
    {
        return 'Life at Mission Villa (three-chapter video gallery)';
    }

    public static function view(): string
    {
        return 'sections.life-gallery.index';
    }

    public function normalize(array $data): array
    {
        // Site-relative paths or https URLs only: never javascript:, data: etc.
        $link = ['required', 'string', 'max:255', 'regex:#^(/(?!/)|https://)#'];
        // Editor media lives under /media/ or /images/ on this site; no remote video hosting.
        $media = fn (string $ext) => ['nullable', 'string', 'max:255', 'regex:#^/(media|images)/[A-Za-z0-9/._-]+\.('.$ext.')$#', 'not_regex:#\.\.#'];
        $image = ['required', 'string', 'max:255', 'regex:#^/images/[A-Za-z0-9/._-]+\.(webp|jpe?g|png|avif)$#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:40'],
            'heading' => ['required', 'string', 'max:80'],
            'subheading' => ['required', 'string', 'max:140'],
            'manifest' => ['nullable', 'string', 'max:255', 'regex:#^/media/[a-z0-9/._-]+\.json$#', 'not_regex:#\.\.#'],
            'chapters' => ['required', 'array', 'size:'.self::CHAPTER_COUNT],
            'chapters.*.id' => ['required', 'alpha_dash', 'max:30', 'distinct'],
            'chapters.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'chapters.*.label' => ['required', 'string', 'max:28'],
            'chapters.*.kicker' => ['required', 'string', 'max:30'],
            'chapters.*.title' => ['required', 'string', 'max:56'],
            'chapters.*.description' => ['required', 'string', 'max:170'],
            'chapters.*.cta' => ['nullable', 'array'],
            'chapters.*.cta.label' => ['required_with:chapters.*.cta', 'string', 'max:32'],
            'chapters.*.cta.href' => ['required_with:chapters.*.cta', ...array_slice($link, 1)],
            // Shown instead (opening the visit dialog) while the destination page is not built yet.
            'chapters.*.cta.fallback_label' => ['nullable', 'string', 'max:32'],
            'chapters.*.media' => ['nullable', 'array'],
            'chapters.*.media.manifest_id' => ['nullable', 'alpha_dash', 'max:40'],
            'chapters.*.media.video_src' => $media('mp4|webm'),
            'chapters.*.media.poster_src' => $media('webp|jpe?g|png|avif'),
            'chapters.*.media.captions_src' => $media('vtt'),
            'chapters.*.media.duration_seconds' => ['nullable', 'numeric', 'min:1', 'max:1800'],
            'chapters.*.media.provenance' => ['nullable', 'in:facility,illustrative'],
            'chapters.*.media.provenance_label' => ['nullable', 'string', 'max:80'],
            'chapters.*.fallback_poster' => ['required', 'array'],
            'chapters.*.fallback_poster.src' => $image,
            'chapters.*.fallback_poster.src_mobile' => ['nullable', ...array_slice($image, 1)],
            'chapters.*.fallback_poster.alt' => ['required', 'string', 'max:200'],
            // Honesty guard: every image must declare whether it is real facility photography.
            'chapters.*.fallback_poster.provenance' => ['required', 'in:facility,illustrative'],
            'chapters.*.fallback_poster.position' => ['nullable', 'regex:/^\d{1,3}% \d{1,3}%$/'],
            'labels' => ['required', 'array'],
            'labels.illustrative_video' => ['required', 'string', 'max:80'],
            'labels.illustrative_image' => ['required', 'string', 'max:80'],
            'labels.facility_video' => ['required', 'string', 'max:80'],
            'labels.facility_image' => ['required', 'string', 'max:80'],
            'labels.unavailable' => ['required', 'string', 'max:60'],
            'labels.unavailable_detail' => ['required', 'string', 'max:120'],
            'visit_cta' => ['required', 'string', 'max:32'],
            'care_guide_cta' => ['nullable', 'string', 'max:48'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        $valid['heading'] = InlineText::sanitize($valid['heading']);
        foreach (['eyebrow', 'subheading', 'visit_cta'] as $field) {
            $valid[$field] = InlineText::plain($valid[$field]);
        }
        $valid['care_guide_cta'] = isset($valid['care_guide_cta']) ? InlineText::plain($valid['care_guide_cta']) : null;
        $valid['labels'] = array_map(fn ($v) => InlineText::plain($v), $valid['labels']);
        $valid['manifest'] ??= self::DEFAULT_MANIFEST;

        $manifest = $this->manifest?->chapters($valid['manifest']) ?? [];

        $valid['chapters'] = array_map(function (array $chapter) use ($manifest, $valid): array {
            foreach (['label', 'kicker', 'title', 'description'] as $field) {
                $chapter[$field] = InlineText::plain($chapter[$field]);
            }

            if (isset($chapter['cta'])) {
                $chapter['cta'] = [
                    'label' => InlineText::plain($chapter['cta']['label']),
                    'href' => $chapter['cta']['href'],
                    'fallback_label' => isset($chapter['cta']['fallback_label']) ? InlineText::plain($chapter['cta']['fallback_label']) : null,
                ];
            } else {
                $chapter['cta'] = null;
            }

            $chapter['fallback_poster']['src_mobile'] ??= null;
            $chapter['fallback_poster']['position'] ??= '50% 50%';

            $overrides = $chapter['media'] ?? [];
            $entry = $manifest[$overrides['manifest_id'] ?? $chapter['id']] ?? null;
            $chapter['media'] = $this->resolveMedia($chapter, $overrides, $entry, $valid['labels']);

            return $chapter;
        }, array_values($valid['chapters']));

        return $valid;
    }

    /**
     * @param  array<string, mixed>  $chapter
     * @param  array<string, mixed>  $overrides  CMS overrides
     * @param  array<string, mixed>|null  $entry  Resolved manifest chapter
     * @param  array<string, string>  $labels
     * @return array<string, mixed>
     */
    private function resolveMedia(array $chapter, array $overrides, ?array $entry, array $labels): array
    {
        $exists = fn (?string $url): bool => $url !== null && $this->manifest?->exists($url) === true;

        // 1. Video sources
        $sources = [];
        $fromOverride = false;
        if ($exists($overrides['video_src'] ?? null)) {
            $sources = [[
                'src' => $overrides['video_src'],
                'type' => str_ends_with($overrides['video_src'], '.webm') ? 'video/webm' : 'video/mp4',
                'width' => null,
            ]];
            $fromOverride = true;
        } elseif ($entry !== null) {
            $sources = $entry['sources'];
        }
        $available = $sources !== [];

        // 2. Poster: override → manifest → fallback still
        $fallback = $chapter['fallback_poster'];
        $poster = ['src' => $fallback['src'], 'src_mobile' => $fallback['src_mobile'], 'alt' => $fallback['alt'], 'position' => $fallback['position'], 'provenance' => $fallback['provenance'], 'is_fallback' => true];
        if ($exists($overrides['poster_src'] ?? null)) {
            $poster = ['src' => $overrides['poster_src'], 'src_mobile' => null, 'alt' => $fallback['alt'], 'position' => '50% 50%', 'provenance' => null, 'is_fallback' => false];
        } elseif ($available && ($entry['poster'] ?? null) !== null) {
            $poster = ['src' => $entry['poster']['src'], 'src_mobile' => $entry['poster']['src_mobile'], 'alt' => $entry['poster']['alt'] ?? $fallback['alt'], 'position' => '50% 50%', 'provenance' => null, 'is_fallback' => false];
        }

        // 3. Captions
        $captions = [];
        if ($exists($overrides['captions_src'] ?? null)) {
            $captions = [['src' => $overrides['captions_src'], 'srclang' => 'en', 'label' => 'English', 'kind' => 'captions']];
        } elseif ($available && ! $fromOverride && $entry !== null) {
            $captions = $entry['captions'];
        }

        // 4. Provenance: manifest is authoritative for its own footage; an editor
        //    may only mark their own uploaded override as facility footage.
        if ($available) {
            $provenance = $fromOverride
                ? ($overrides['provenance'] ?? 'illustrative')
                : ($entry['provenance'] ?? 'illustrative');
            $label = $overrides['provenance_label']
                ?? ($fromOverride ? null : ($entry['provenance_label'] ?? null))
                ?? $labels[$provenance.'_video'];
        } else {
            $provenance = $poster['provenance'] ?? $fallback['provenance'];
            $label = $labels[$provenance.'_image'];
        }

        return [
            'available' => $available,
            'sources' => $sources,
            'poster' => $poster,
            'captions' => $captions,
            'duration_seconds' => $overrides['duration_seconds'] ?? ($fromOverride ? null : ($entry['duration_seconds'] ?? null)),
            'title' => ($fromOverride ? null : ($entry['title'] ?? null)) ?? $chapter['label'],
            'description' => $fromOverride ? null : ($entry['description'] ?? null),
            'has_audio' => $fromOverride ? true : (bool) ($entry['audio']['has_audio'] ?? true),
            'audio_description' => $fromOverride ? null : ($entry['audio']['description'] ?? null),
            'provenance' => $provenance,
            'provenance_label' => InlineText::plain($label),
        ];
    }
}
