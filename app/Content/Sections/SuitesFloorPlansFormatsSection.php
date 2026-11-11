<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Support\InquiryIntents;
use Illuminate\Support\Facades\Validator;

/**
 * Suites & Floor Plans Section 02: Suite Formats & Accommodations.
 *
 * Deep plum visual centerpiece displaying 3 prominent photographic cards
 * with top-left clipped image corners and integrated label tabs.
 */
final class SuitesFloorPlansFormatsSection implements SectionSchema
{
    public const RIGHTS = ['cleared', 'unconfirmed'];

    public static function type(): string
    {
        return 'suites-floor-plans.formats';
    }

    public static function label(): string
    {
        return 'Suites & Floor Plans Formats (deep plum, clipped corner cards)';
    }

    public static function view(): string
    {
        return 'sections.suites-floor-plans-formats.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:100'],
            'intro' => ['required', 'string', 'max:350'],

            'suites' => ['required', 'array', 'size:3'],
            'suites.*.id' => ['required', 'string', 'in:private-suite,companion-unit,jack-and-jill'],
            'suites.*.code' => ['required', 'string', 'max:50'],
            'suites.*.cutout_label' => ['required', 'string', 'max:40'],
            'suites.*.title' => ['required', 'string', 'max:80'],
            'suites.*.badge' => ['required', 'string', 'max:80'],
            'suites.*.bathroom' => ['required', 'string', 'max:120'],
            'suites.*.summary' => ['required', 'string', 'max:300'],
            'suites.*.features' => ['required', 'array', 'min:3', 'max:6'],
            'suites.*.features.*' => ['required', 'string', 'max:140'],
            'suites.*.inquiry_suite' => ['required', 'in:private,shared,undecided'],

            'suites.*.image' => ['required', 'array'],
            'suites.*.image.src' => $path,
            'suites.*.image.width' => ['required', 'integer', 'min:300', 'max:3000'],
            'suites.*.image.height' => ['required', 'integer', 'min:200', 'max:3000'],
            'suites.*.image.alt' => ['required', 'string', 'max:200'],
            'suites.*.image.caption' => ['required', 'string', 'max:200'],
            'suites.*.image.provenance' => ['required', 'in:facility,illustrative'],
            'suites.*.image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],
            'suites.*.image.label' => ['required', 'string', 'max:60'],

            'cta' => ['required', 'array'],
            'cta.label' => ['required', 'string', 'max:50'],
            'cta.intent' => ['required', 'in:'.implode(',', InquiryIntents::accepted())],
            'cta.note' => ['required', 'string', 'max:180'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'suites' => array_map(fn (array $s) => [
                'id' => $s['id'],
                'code' => InlineText::plain($s['code']),
                'cutout_label' => InlineText::plain($s['cutout_label']),
                'title' => InlineText::plain($s['title']),
                'badge' => InlineText::plain($s['badge']),
                'bathroom' => InlineText::plain($s['bathroom']),
                'summary' => InlineText::plain($s['summary']),
                'features' => array_map(fn ($f) => InlineText::plain($f), $s['features']),
                'inquiry_suite' => $s['inquiry_suite'],
                'image' => [
                    'src' => $s['image']['src'],
                    'width' => (int) $s['image']['width'],
                    'height' => (int) $s['image']['height'],
                    'alt' => InlineText::plain($s['image']['alt']),
                    'caption' => InlineText::plain($s['image']['caption']),
                    'provenance' => $s['image']['provenance'],
                    'rights' => $s['image']['rights'],
                    'label' => InlineText::plain($s['image']['label']),
                ],
            ], $valid['suites']),
            'cta' => [
                'label' => InlineText::plain($valid['cta']['label']),
                'intent' => InquiryIntents::resolve($valid['cta']['intent']),
                'note' => InlineText::plain($valid['cta']['note']),
            ],
        ];
    }
}
