<?php

namespace App\Content\Media;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use JsonException;

/**
 * Reads the Section 03 media manifest produced by the Motion Studio session.
 *
 * Contract: docs/SECTION_03_VIDEO_CONTRACT.md. The manifest lives next to the
 * media it describes (public/media/mission-villa/life-at-mission-villa/).
 *
 * The page must never break because of a media hand-off, so this reader is
 * defensive: a missing manifest returns no chapters, an invalid one is logged
 * and ignored, and every referenced file is checked on disk. Only files that
 * actually exist are returned, so the player never receives a dead source.
 */
final class LifeGalleryManifest
{
    public const SCHEMA = 'missionvilla.life-gallery.media/v1';

    /** A bare file name next to the manifest, or a site-relative path inside /media/. */
    private const FILE_PATTERN = '#^(?:[a-z0-9][a-z0-9._-]*|/media/[a-z0-9][a-z0-9/._-]*)$#';

    private const VIDEO_TYPES = ['video/mp4', 'video/webm'];

    public function __construct(private readonly string $publicRoot) {}

    /**
     * @return array<string, array<string, mixed>> Resolved chapters keyed by chapter id.
     */
    public function chapters(string $manifestUrl): array
    {
        $report = $this->inspect($manifestUrl);
        if ($report['status'] === 'invalid') {
            Log::warning('Life gallery media manifest failed validation; ignoring it.', ['manifest' => $manifestUrl, 'errors' => $report['errors']]);
        }

        return $report['chapters'];
    }

    /**
     * Full validation report, used by the page and by `php artisan missionvilla:life-media`.
     *
     * @return array{status: 'missing'|'invalid'|'valid', errors: array<string, list<string>>, chapters: array<string, array<string, mixed>>}
     */
    public function inspect(string $manifestUrl): array
    {
        $manifestFile = $this->toFile($manifestUrl);
        if ($manifestFile === null || ! is_file($manifestFile)) {
            return ['status' => 'missing', 'errors' => [], 'chapters' => []];
        }

        try {
            $raw = json_decode((string) file_get_contents($manifestFile), true, 32, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return ['status' => 'invalid', 'errors' => ['json' => [$e->getMessage()]], 'chapters' => []];
        }

        $validator = Validator::make(is_array($raw) ? $raw : [], self::rules());
        $validator->after(function ($v) use ($raw) {
            // Honesty guard: AI-generated or stock footage can never be labelled as facility footage.
            foreach ((array) ($raw['chapters'] ?? []) as $i => $chapter) {
                $type = $chapter['provenance']['type'] ?? null;
                $method = $chapter['provenance']['method'] ?? null;
                if ($type === 'facility' && in_array($method, ['ai-generated', 'stock', 'motion-graphics'], true)) {
                    $v->errors()->add("chapters.$i.provenance.type", 'Generated or stock footage must use provenance type "illustrative".');
                }
            }
        });

        if ($validator->fails()) {
            return ['status' => 'invalid', 'errors' => $validator->errors()->toArray(), 'chapters' => []];
        }

        $valid = $validator->validated();
        $base = rtrim(dirname($manifestUrl), '/').'/';
        // Optional cache-buster so re-exported files with the same name are re-fetched.
        $suffix = isset($valid['version']) ? '?v='.$valid['version'] : '';
        $resolved = [];
        foreach ($valid['chapters'] as $chapter) {
            $resolved[$chapter['id']] = $this->resolveChapter($chapter, $base, $suffix);
        }

        return ['status' => 'valid', 'errors' => [], 'chapters' => $resolved];
    }

    /** Convert a site-relative URL to an absolute path under public/, or null if it would escape it. */
    public function toFile(?string $url): ?string
    {
        if ($url === null || $url === '' || ! str_starts_with($url, '/') || str_contains($url, '..') || str_contains($url, '\\')) {
            return null;
        }

        return rtrim($this->publicRoot, '/').$url;
    }

    /** True when a site-relative URL points at an existing file inside public/. */
    public function exists(?string $url): bool
    {
        $file = $this->toFile($url);

        return $file !== null && is_file($file);
    }

    /** @return array<string, mixed> */
    private function resolveChapter(array $c, string $base, string $suffix = ''): array
    {
        $url = fn (?string $f): ?string => $f === null ? null : (str_starts_with($f, '/') ? $f : $base.$f);
        $existing = fn (?string $f): ?string => ($u = $url($f)) !== null && $this->exists($u) ? $u.$suffix : null;

        $sources = [];
        $primary = $existing($c['video']['src']);
        if ($primary !== null) {
            $sources[] = [
                'src' => $primary,
                'type' => $c['video']['type'] ?? 'video/mp4',
                'width' => $c['video']['width'] ?? null,
            ];
            foreach ($c['video']['alternates'] ?? [] as $alt) {
                if (($src = $existing($alt['src'])) !== null) {
                    $sources[] = ['src' => $src, 'type' => $alt['type'] ?? 'video/mp4', 'width' => $alt['width'] ?? null];
                }
            }
        }

        $captions = [];
        foreach ($c['captions'] ?? [] as $track) {
            if (($src = $existing($track['src'])) !== null) {
                $captions[] = [
                    'src' => $src,
                    'srclang' => $track['srclang'] ?? 'en',
                    'label' => $track['label'] ?? 'English',
                    'kind' => $track['kind'] ?? 'captions',
                ];
            }
        }

        return [
            'title' => $c['title'] ?? null,
            'description' => $c['description'] ?? null,
            'sources' => $sources,
            'duration_seconds' => isset($c['video']['duration_seconds']) ? (float) $c['video']['duration_seconds'] : null,
            'poster' => ($p = $existing($c['poster']['src'] ?? null)) !== null
                ? ['src' => $p, 'src_mobile' => $existing($c['poster']['src_mobile'] ?? null), 'alt' => $c['poster']['alt'] ?? null]
                : null,
            'captions' => $captions,
            'audio' => [
                'has_audio' => (bool) ($c['audio']['has_audio'] ?? true),
                'description' => $c['audio']['description'] ?? null,
            ],
            'provenance' => $c['provenance']['type'],
            'provenance_label' => $c['provenance']['label'] ?? null,
        ];
    }

    /** @return array<string, mixed> */
    private static function rules(): array
    {
        $file = ['string', 'max:200', 'regex:'.self::FILE_PATTERN, 'not_regex:#\.\.#'];

        return [
            'schema' => ['required', 'in:'.self::SCHEMA],
            'version' => ['nullable', 'regex:/^[A-Za-z0-9._-]{1,24}$/'],
            'chapters' => ['required', 'array', 'min:1', 'max:12'],
            'chapters.*.id' => ['required', 'alpha_dash', 'max:40', 'distinct'],
            'chapters.*.title' => ['nullable', 'string', 'max:80'],
            'chapters.*.description' => ['nullable', 'string', 'max:300'],
            'chapters.*.video' => ['required', 'array'],
            'chapters.*.video.src' => ['required', ...$file, 'regex:#\.(mp4|webm)$#'],
            'chapters.*.video.type' => ['nullable', 'in:'.implode(',', self::VIDEO_TYPES)],
            'chapters.*.video.width' => ['nullable', 'integer', 'min:320', 'max:3840'],
            'chapters.*.video.height' => ['nullable', 'integer', 'min:180', 'max:2160'],
            'chapters.*.video.duration_seconds' => ['nullable', 'numeric', 'min:1', 'max:1800'],
            'chapters.*.video.alternates' => ['nullable', 'array', 'max:4'],
            'chapters.*.video.alternates.*.src' => ['required', ...$file, 'regex:#\.(mp4|webm)$#'],
            'chapters.*.video.alternates.*.type' => ['nullable', 'in:'.implode(',', self::VIDEO_TYPES)],
            'chapters.*.video.alternates.*.width' => ['nullable', 'integer', 'min:320', 'max:3840'],
            'chapters.*.poster' => ['nullable', 'array'],
            'chapters.*.poster.src' => ['nullable', ...$file, 'regex:#\.(webp|jpe?g|avif|png)$#'],
            'chapters.*.poster.src_mobile' => ['nullable', ...$file, 'regex:#\.(webp|jpe?g|avif|png)$#'],
            'chapters.*.poster.alt' => ['nullable', 'string', 'max:200'],
            'chapters.*.captions' => ['nullable', 'array', 'max:4'],
            'chapters.*.captions.*.src' => ['required', ...$file, 'regex:#\.vtt$#'],
            'chapters.*.captions.*.srclang' => ['nullable', 'regex:/^[a-z]{2,3}(-[A-Za-z]{2,4})?$/'],
            'chapters.*.captions.*.label' => ['nullable', 'string', 'max:40'],
            'chapters.*.captions.*.kind' => ['nullable', 'in:captions,subtitles,descriptions'],
            'chapters.*.audio' => ['nullable', 'array'],
            'chapters.*.audio.has_audio' => ['nullable', 'boolean'],
            'chapters.*.audio.type' => ['nullable', 'in:none,music,narration,ambient,mixed'],
            'chapters.*.audio.description' => ['nullable', 'string', 'max:200'],
            'chapters.*.audio.credit' => ['nullable', 'string', 'max:200'],
            'chapters.*.audio.license' => ['nullable', 'string', 'max:200'],
            'chapters.*.provenance' => ['required', 'array'],
            'chapters.*.provenance.type' => ['required', 'in:illustrative,facility'],
            'chapters.*.provenance.method' => ['required', 'in:ai-generated,motion-graphics,stock,filmed'],
            'chapters.*.provenance.label' => ['nullable', 'string', 'max:80'],
            'chapters.*.provenance.notes' => ['nullable', 'string', 'max:500'],
        ];
    }
}
