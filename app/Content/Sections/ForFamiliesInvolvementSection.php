<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * For Families Section 04: Family Involvement, Transitions & Suite Personalization.
 *
 * Storyboard showing how relatives remain at the heart of life at Mission Villa:
 * life-story intake, suite personalization, communal visits, and ongoing dialogue.
 */
final class ForFamiliesInvolvementSection implements SectionSchema
{
    public const RIGHTS = ['cleared', 'unconfirmed'];

    public static function type(): string
    {
        return 'for-families.involvement';
    }

    public static function label(): string
    {
        return 'For Families Involvement & Transitions (4-chapter storyboard with tabs)';
    }

    public static function view(): string
    {
        return 'sections.for-families-involvement.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:140'],
            'intro' => ['required', 'string', 'max:400'],

            'chapters' => ['required', 'array', 'size:4'],
            'chapters.*.id' => ['required', 'string', 'max:40'],
            'chapters.*.step_number' => ['required', 'string', 'max:20'],
            'chapters.*.kicker' => ['required', 'string', 'max:40'],
            'chapters.*.title' => ['required', 'string', 'max:80'],
            'chapters.*.subtitle' => ['required', 'string', 'max:100'],
            'chapters.*.narrative' => ['required', 'string', 'max:400'],
            'chapters.*.practical_ways' => ['required', 'array', 'min:2', 'max:5'],
            'chapters.*.practical_ways.*' => ['required', 'string', 'max:200'],
            'chapters.*.reassurance_note' => ['required', 'string', 'max:200'],

            'chapters.*.image' => ['required', 'array'],
            'chapters.*.image.src' => $path,
            'chapters.*.image.width' => ['required', 'integer', 'min:300', 'max:3000'],
            'chapters.*.image.height' => ['required', 'integer', 'min:200', 'max:3000'],
            'chapters.*.image.alt' => ['required', 'string', 'max:200'],
            'chapters.*.image.caption' => ['required', 'string', 'max:160'],
            'chapters.*.image.status' => ['required', 'string', 'max:60'],
            'chapters.*.image.provenance' => ['required', 'in:facility,illustrative'],
            'chapters.*.image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'chapters' => array_map(function (array $chap): array {
                return [
                    'id' => $chap['id'],
                    'step_number' => InlineText::plain($chap['step_number']),
                    'kicker' => InlineText::plain($chap['kicker']),
                    'title' => InlineText::plain($chap['title']),
                    'subtitle' => InlineText::plain($chap['subtitle']),
                    'narrative' => InlineText::plain($chap['narrative']),
                    'practical_ways' => array_map(fn ($way) => InlineText::plain($way), $chap['practical_ways']),
                    'reassurance_note' => InlineText::plain($chap['reassurance_note']),
                    'image' => [
                        'src' => $chap['image']['src'],
                        'width' => $chap['image']['width'],
                        'height' => $chap['image']['height'],
                        'alt' => $chap['image']['alt'],
                        'caption' => InlineText::plain($chap['image']['caption']),
                        'status' => InlineText::plain($chap['image']['status']),
                        'provenance' => $chap['image']['provenance'],
                        'rights' => $chap['image']['rights'],
                    ],
                ];
            }, $valid['chapters']),
        ];
    }
}
