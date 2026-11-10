<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Support\InquiryIntents;
use Illuminate\Support\Facades\Validator;

/**
 * Living Options Section 01: Hero.
 *
 * Single photographic internal-page hero with dark plum gradient scrim,
 * Newsreader title, editorial subtitle, primary visit CTA,
 * secondary care comparison anchor CTA, direct phone link, and 3-column
 * compact information strip below.
 */
final class LivingOptionsHeroSection implements SectionSchema
{
    public const RIGHTS = ['cleared', 'unconfirmed'];

    public const ICONS = ['calendar', 'phone', 'arrow', 'bed', 'pin', 'home', 'heart', 'shield'];

    public static function type(): string
    {
        return 'living-options.hero';
    }

    public static function label(): string
    {
        return 'Living Options Hero (photograph, headline, CTAs and info strip)';
    }

    public static function view(): string
    {
        return 'sections.living-options-hero.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:100'],
            'editorial' => ['required', 'string', 'max:160'],
            'intro' => ['required', 'string', 'max:350'],

            'image' => ['required', 'array'],
            'image.src' => $path,
            'image.src_mobile' => ['nullable', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'],
            'image.width' => ['required', 'integer', 'min:320', 'max:4000'],
            'image.height' => ['required', 'integer', 'min:200', 'max:4000'],
            'image.alt' => ['required', 'string', 'max:200'],
            'image.provenance' => ['required', 'in:facility,illustrative'],
            'image.source_url' => ['nullable', 'url', 'max:255'],
            'image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],
            'image.label' => ['required', 'string', 'max:60'],

            'strip' => ['nullable', 'array', 'max:3'],
            'strip.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'strip.*.kicker' => ['required', 'string', 'max:40'],
            'strip.*.title' => ['required', 'string', 'max:60'],
            'strip.*.desc' => ['required', 'string', 'max:120'],

            'actions' => ['required', 'array', 'min:1', 'max:3'],
            'actions.*.label' => ['required', 'string', 'max:40'],
            'actions.*.style' => ['required', 'in:primary,secondary,phone'],
            'actions.*.icon' => ['nullable', 'in:'.implode(',', self::ICONS)],
            'actions.*.intent' => ['nullable', 'in:'.implode(',', InquiryIntents::accepted())],
            'actions.*.href' => ['nullable', 'string', 'max:255'],
            'actions.*.care' => ['nullable', 'string', 'in:memory_care,respite_care,exploring'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'editorial' => InlineText::render($valid['editorial']),
            'intro' => InlineText::plain($valid['intro']),
            'image' => [
                'src' => $valid['image']['src'],
                'src_mobile' => $valid['image']['src_mobile'] ?? null,
                'width' => (int) $valid['image']['width'],
                'height' => (int) $valid['image']['height'],
                'alt' => InlineText::plain($valid['image']['alt']),
                'provenance' => $valid['image']['provenance'],
                'source_url' => $valid['image']['source_url'] ?? null,
                'rights' => $valid['image']['rights'],
                'label' => InlineText::plain($valid['image']['label']),
            ],
            'strip' => array_map(fn (array $b) => [
                'icon' => $b['icon'],
                'kicker' => InlineText::plain($b['kicker']),
                'title' => InlineText::plain($b['title']),
                'desc' => InlineText::plain($b['desc']),
            ], $valid['strip'] ?? []),
            'actions' => array_map(fn (array $a) => [
                'label' => InlineText::plain($a['label']),
                'style' => $a['style'],
                'icon' => $a['icon'] ?? null,
                'intent' => isset($a['intent']) ? InquiryIntents::resolve($a['intent']) : null,
                'href' => $a['href'] ?? null,
                'care' => $a['care'] ?? 'exploring',
            ], $valid['actions']),
        ];
    }
}
