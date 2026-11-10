<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Content\Media\LifeGalleryManifest;
use App\Support\InquiryIntents;
use Illuminate\Support\Facades\Validator;

/**
 * Homepage section 04: "Why Families Choose Mission Villa".
 *
 * A full-width editorial composition over the authentic Mission Villa
 * courtyard: a left narrative with two CTAs, a right "At a Glance" panel
 * with four verified facts, and a deep-plum values strip beneath.
 *
 * The composition is designed for exactly four facts and four values, so the
 * schema enforces those counts and caps every text field at a length that
 * still fits the ~100svh desktop layout and the stacked mobile layout.
 * Editors can emphasise words in the heading with <em> only; everything else
 * is plain text.
 */
final class WhyFamiliesSection implements SectionSchema
{
    public const FACT_COUNT = 4;

    public const VALUE_COUNT = 4;

    /** Icons the view knows how to draw (resources/views/sections/why-families/icon.blade.php). */
    public const ICONS = ['pin', 'hands', 'book-heart', 'messages', 'heart', 'people', 'heart-handshake', 'sprout', 'home', 'calendar'];

    /** Publication-rights status of the photograph (shown in docs and source, never guessed). */
    public const RIGHTS = ['cleared', 'unconfirmed'];

    public function __construct(private readonly ?LifeGalleryManifest $manifest = null) {}

    public static function type(): string
    {
        return 'trust.why-families';
    }

    public static function label(): string
    {
        return 'Why families choose Mission Villa (courtyard, facts, values)';
    }

    public static function view(): string
    {
        return 'sections.why-families.index';
    }

    public function normalize(array $data): array
    {
        $icon = ['required', 'in:'.implode(',', self::ICONS)];
        // Site-relative paths, https URLs or an on-page anchor. Never javascript:, data: etc.
        $link = ['required', 'string', 'max:255', 'regex:~^(/(?!/)|https://|#[a-z][a-z0-9-]*$)~'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:40'],
            'heading' => ['required', 'string', 'max:70'],
            'body' => ['required', 'string', 'max:240'],

            'image.src' => ['required', 'string', 'max:255', 'regex:#^/(?!/)#'],
            'image.src_mobile' => ['nullable', 'string', 'max:255', 'regex:#^/(?!/)#'],
            'image.alt' => ['required', 'string', 'max:200'],
            // Honesty guard: real facility photography vs illustrative imagery.
            'image.provenance' => ['required', 'in:facility,illustrative'],
            'image.source_url' => ['nullable', 'url', 'max:255'],
            'image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],
            'image.position' => ['nullable', 'regex:/^\d{1,3}% \d{1,3}%$/'],
            'image.caption' => ['nullable', 'string', 'max:48'],

            'primary_cta.label' => ['required', 'string', 'max:28'],
            // A form CTA names an inquiry intent: it opens the shared inquiry modal (website-wide rule).
            'primary_cta.intent' => ['nullable', 'string', 'in:'.implode(',', InquiryIntents::accepted())],
            // A page link, used only when the CTA has no intent.
            'primary_cta.href' => ['required_without:primary_cta.intent', 'nullable', ...array_filter($link, fn ($r) => $r !== 'required')],

            'tour_cta' => ['nullable', 'array'],
            'tour_cta.label' => ['required_with:tour_cta', 'string', 'max:28'],
            'tour_cta.href' => ['required_with:tour_cta', 'string', 'max:255', 'regex:~^(/(?!/)|https://|#[a-z][a-z0-9-]*$)~'],
            // When set, the CTA is marked "pending" until at least one film in this manifest is available.
            'tour_cta.manifest' => ['nullable', 'string', 'max:255', 'regex:#^/media/[a-z0-9/._-]+\.json$#', 'not_regex:#\.\.#'],
            'tour_cta.pending_note' => ['nullable', 'string', 'max:40'],

            'glance.kicker' => ['required', 'string', 'max:24'],
            'glance.title' => ['required', 'string', 'max:24'],
            'glance.facts' => ['required', 'array', 'size:'.self::FACT_COUNT],
            'glance.facts.*.icon' => $icon,
            'glance.facts.*.title' => ['required', 'string', 'max:32'],
            'glance.facts.*.text' => ['required', 'string', 'max:90'],

            'values' => ['required', 'array', 'size:'.self::VALUE_COUNT],
            'values.*.icon' => $icon,
            'values.*.title' => ['required', 'string', 'max:30'],
            'values.*.text' => ['required', 'string', 'max:64'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        $valid['heading'] = InlineText::sanitize(strip_tags($valid['heading'], '<em>'));
        foreach (['eyebrow', 'body'] as $field) {
            $valid[$field] = InlineText::plain($valid[$field]);
        }

        $image = $valid['image'];
        $image['alt'] = InlineText::plain($image['alt']);
        $image['src_mobile'] ??= null;
        $image['source_url'] ??= null;
        $image['position'] ??= '50% 50%';
        $image['caption'] = isset($image['caption']) ? InlineText::plain($image['caption']) : null;
        $valid['image'] = $image;

        $valid['primary_cta'] = [
            'label' => InlineText::plain($valid['primary_cta']['label']),
            'intent' => InquiryIntents::resolve($valid['primary_cta']['intent'] ?? null),
            'href' => $valid['primary_cta']['href'] ?? null,
        ];

        $tour = $valid['tour_cta'] ?? null;
        if ($tour !== null) {
            $tour['label'] = InlineText::plain($tour['label']);
            $tour['pending_note'] = isset($tour['pending_note']) ? InlineText::plain($tour['pending_note']) : null;
            $tour['manifest'] ??= null;
            // Honest state: until a film exists, the tour CTA says so instead of promising one.
            $tour['pending'] = $tour['manifest'] !== null && ! $this->anyFilmAvailable($tour['manifest']);
        }
        $valid['tour_cta'] = $tour;

        $valid['glance']['kicker'] = InlineText::plain($valid['glance']['kicker']);
        $valid['glance']['title'] = InlineText::plain($valid['glance']['title']);
        $valid['glance']['facts'] = array_map(fn (array $f) => [
            'icon' => $f['icon'],
            'title' => InlineText::plain($f['title']),
            'text' => InlineText::plain($f['text']),
        ], array_values($valid['glance']['facts']));

        $valid['values'] = array_map(fn (array $v) => [
            'icon' => $v['icon'],
            'title' => InlineText::plain($v['title']),
            'text' => InlineText::plain($v['text']),
        ], array_values($valid['values']));

        return $valid;
    }

    private function anyFilmAvailable(string $manifestUrl): bool
    {
        if ($this->manifest === null) {
            return false;
        }

        // Same rule as Section 03: a chapter is playable once its manifest entry resolves to an existing video file.
        foreach ($this->manifest->chapters($manifestUrl) as $chapter) {
            if (! empty($chapter['sources'])) {
                return true;
            }
        }

        return false;
    }
}
