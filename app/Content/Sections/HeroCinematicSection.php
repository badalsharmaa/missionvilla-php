<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Approved cinematic three-chapter homepage hero
 * (reference: mission_villa_cinematic_hero_final.html).
 *
 * The design is built for exactly three chapters, so the schema enforces
 * three slides and length limits that keep the headline mask, chapter bar
 * and care-guide card within the approved layout.
 */
final class HeroCinematicSection implements SectionSchema
{
    public const SLIDE_COUNT = 3;

    public static function type(): string
    {
        return 'hero.cinematic';
    }

    public static function label(): string
    {
        return 'Cinematic hero (3 chapters + Care Guide)';
    }

    public static function view(): string
    {
        return 'sections.hero-cinematic.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'autoplay_seconds' => ['required', 'numeric', 'between:4,12'],
            'slides' => ['required', 'array', 'size:'.self::SLIDE_COUNT],
            'slides.*.eyebrow' => ['required', 'string', 'max:60'],
            'slides.*.line1' => ['required', 'string', 'max:60'],
            'slides.*.line2' => ['required', 'string', 'max:60'],
            'slides.*.line3' => ['required', 'string', 'max:60'],
            'slides.*.body' => ['required', 'string', 'max:420'],
            'slides.*.cta' => ['required', 'string', 'max:40'],
            'slides.*.chapter_title' => ['required', 'string', 'max:40'],
            'slides.*.chapter_subtitle' => ['required', 'string', 'max:60'],
            'slides.*.image.src' => ['required', 'string', 'max:255'],
            'slides.*.image.src_mobile' => ['nullable', 'string', 'max:255'],
            'slides.*.image.alt' => ['required', 'string', 'max:200'],
            'slides.*.image.fallback_label' => ['required', 'string', 'max:60'],
            // Honesty guard: every image must declare whether it is real facility photography.
            'slides.*.image.provenance' => ['required', 'in:facility,illustrative'],
            'slides.*.image.source_url' => ['nullable', 'url', 'max:255'],
            'care_guide.kicker' => ['required', 'string', 'max:40'],
            'care_guide.brand' => ['required', 'string', 'max:40'],
            'care_guide.tag' => ['required', 'string', 'max:12'],
            'care_guide.title' => ['required', 'string', 'max:60'],
            'care_guide.description' => ['required', 'string', 'max:160'],
            'care_guide.choices' => ['required', 'array', 'between:1,4'],
            'care_guide.choices.*.label' => ['required', 'string', 'max:40'],
            'care_guide.choices.*.question' => ['required', 'string', 'max:120'],
            'care_guide.placeholder' => ['required', 'string', 'max:40'],
            'care_guide.footnote' => ['required', 'string', 'max:80'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        $valid['slides'] = array_map(function (array $slide): array {
            foreach (['line1', 'line2', 'line3', 'body'] as $field) {
                $slide[$field] = InlineText::sanitize($slide[$field]);
            }
            foreach (['eyebrow', 'cta', 'chapter_title', 'chapter_subtitle'] as $field) {
                $slide[$field] = InlineText::plain($slide[$field]);
            }
            $slide['image']['src_mobile'] ??= null;
            $slide['image']['source_url'] ??= null;

            return $slide;
        }, array_values($valid['slides']));

        $valid['care_guide']['choices'] = array_values($valid['care_guide']['choices']);

        return $valid;
    }

    /**
     * Client-side slide payload consumed by resources/js/sections/hero-cinematic.js.
     * Inline HTML is pre-sanitized here; the script swaps it in verbatim.
     *
     * @param  array<string, mixed>  $data
     * @return list<array<string, string>>
     */
    public static function clientSlides(array $data): array
    {
        $strong = ['strong' => 'font-semibold text-white'];

        return array_map(fn (array $s) => [
            'eyebrow' => $s['eyebrow'],
            'line1' => InlineText::render($s['line1']),
            'line2' => InlineText::render($s['line2']),
            'line3' => InlineText::render($s['line3']),
            'body' => InlineText::render($s['body'], $strong),
            'cta' => $s['cta'],
            'fallbackLabel' => $s['image']['fallback_label'],
        ], $data['slides']);
    }
}
