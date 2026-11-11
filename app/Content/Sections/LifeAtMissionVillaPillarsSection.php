<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Life at Mission Villa Section 02: Core Lifestyle Pillars.
 *
 * Deep plum visual band spotlighting the 3 pillars of community life:
 * 1. Culinary Warmth & Shared Table
 * 2. Creative Vitality, Music & Movement
 * 3. Outdoor Courtyard Sanctuary & Garden Walks
 */
final class LifeAtMissionVillaPillarsSection implements SectionSchema
{
    public const RIGHTS = ['cleared', 'unconfirmed'];

    public static function type(): string
    {
        return 'life-at-mission-villa.pillars';
    }

    public static function label(): string
    {
        return 'Life at Mission Villa Lifestyle Pillars (deep plum, 3 photo cards)';
    }

    public static function view(): string
    {
        return 'sections.life-at-mission-villa-pillars.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:100'],
            'intro' => ['required', 'string', 'max:350'],

            'pillars' => ['required', 'array', 'size:3'],
            'pillars.*.id' => ['required', 'string', 'max:40'],
            'pillars.*.code' => ['required', 'string', 'max:50'],
            'pillars.*.cutout_label' => ['required', 'string', 'max:40'],
            'pillars.*.title' => ['required', 'string', 'max:80'],
            'pillars.*.subtitle' => ['required', 'string', 'max:120'],
            'pillars.*.summary' => ['required', 'string', 'max:350'],
            'pillars.*.highlights' => ['required', 'array', 'min:3', 'max:5'],
            'pillars.*.highlights.*' => ['required', 'string', 'max:140'],

            'pillars.*.image' => ['required', 'array'],
            'pillars.*.image.src' => $path,
            'pillars.*.image.width' => ['required', 'integer', 'min:300', 'max:3000'],
            'pillars.*.image.height' => ['required', 'integer', 'min:200', 'max:3000'],
            'pillars.*.image.alt' => ['required', 'string', 'max:200'],
            'pillars.*.image.provenance' => ['required', 'in:facility,illustrative'],
            'pillars.*.image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],
            'pillars.*.image.label' => ['required', 'string', 'max:60'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'pillars' => array_map(fn (array $p) => [
                'id' => $p['id'],
                'code' => InlineText::plain($p['code']),
                'cutout_label' => InlineText::plain($p['cutout_label']),
                'title' => InlineText::plain($p['title']),
                'subtitle' => InlineText::plain($p['subtitle']),
                'summary' => InlineText::plain($p['summary']),
                'highlights' => array_map(fn ($h) => InlineText::plain($h), $p['highlights']),
                'image' => [
                    'src' => $p['image']['src'],
                    'width' => (int) $p['image']['width'],
                    'height' => (int) $p['image']['height'],
                    'alt' => InlineText::plain($p['image']['alt']),
                    'provenance' => $p['image']['provenance'],
                    'rights' => $p['image']['rights'],
                    'label' => InlineText::plain($p['image']['label']),
                ],
            ], $valid['pillars']),
        ];
    }
}
