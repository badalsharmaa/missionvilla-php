<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * About Section 02: Care Philosophy Editorial Narrative.
 *
 * Interactive 4-chapter monograph on Person-First Dignity, Legacies™ Stewardship,
 * Family Peace of Mind, and Homelike Residential Scale.
 */
final class AboutPhilosophySection implements SectionSchema
{
    public const RIGHTS = ['cleared', 'unconfirmed'];

    public static function type(): string
    {
        return 'about.philosophy';
    }

    public static function label(): string
    {
        return 'About Care Philosophy (4-chapter editorial monograph with interactive tabs)';
    }

    public static function view(): string
    {
        return 'sections.about-philosophy.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:120'],
            'intro' => ['required', 'string', 'max:400'],

            'chapters' => ['required', 'array', 'size:4'],
            'chapters.*.id' => ['required', 'string', 'max:40'],
            'chapters.*.chapter_number' => ['required', 'string', 'max:30'],
            'chapters.*.kicker' => ['required', 'string', 'max:50'],
            'chapters.*.title' => ['required', 'string', 'max:80'],
            'chapters.*.subtitle' => ['required', 'string', 'max:120'],
            'chapters.*.editorial_lead' => ['required', 'string', 'max:300'],
            'chapters.*.narrative_body' => ['required', 'string', 'max:600'],
            'chapters.*.in_everyday_life' => ['required', 'array', 'min:2', 'max:5'],
            'chapters.*.in_everyday_life.*' => ['required', 'string', 'max:200'],
            'chapters.*.family_promise' => ['required', 'string', 'max:200'],
            'chapters.*.related_route' => ['required', 'array'],
            'chapters.*.related_route.label' => ['required', 'string', 'max:50'],
            'chapters.*.related_route.href' => ['required', 'string', 'max:100'],
            'chapters.*.inquiry_note' => ['required', 'string', 'max:250'],

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
                    'chapter_number' => InlineText::plain($chap['chapter_number']),
                    'kicker' => InlineText::plain($chap['kicker']),
                    'title' => InlineText::plain($chap['title']),
                    'subtitle' => InlineText::plain($chap['subtitle']),
                    'editorial_lead' => InlineText::plain($chap['editorial_lead']),
                    'narrative_body' => InlineText::plain($chap['narrative_body']),
                    'in_everyday_life' => array_map(fn ($pt) => InlineText::plain($pt), $chap['in_everyday_life']),
                    'family_promise' => InlineText::plain($chap['family_promise']),
                    'related_route' => [
                        'label' => InlineText::plain($chap['related_route']['label']),
                        'href' => $chap['related_route']['href'],
                    ],
                    'inquiry_note' => InlineText::plain($chap['inquiry_note']),
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
