<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Memory Care Section 03: Daily Life in Memory Care.
 *
 * Three rhythm scenes (Morning, Midday, Evening) representing a calm,
 * welcoming daily flow rather than a rigid institutional timetable.
 */
final class MemoryCareDailyLifeSection implements SectionSchema
{
    public const SCENE_COUNT = 3;

    public const RIGHTS = ['cleared', 'unconfirmed'];

    public static function type(): string
    {
        return 'memory-care.daily-life';
    }

    public static function label(): string
    {
        return 'Daily Life in Memory Care (three rhythm scenes: Morning, Midday, Evening)';
    }

    public static function view(): string
    {
        return 'sections.memory-care-daily-life.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:80'],
            'intro' => ['required', 'string', 'max:300'],

            'scenes' => ['required', 'array', 'size:'.self::SCENE_COUNT],
            'scenes.*.id' => ['required', 'string', 'regex:/^[a-z][a-z0-9-]{1,30}$/', 'distinct'],
            'scenes.*.rhythm' => ['required', 'string', 'max:40'],
            'scenes.*.title' => ['required', 'string', 'max:80'],
            'scenes.*.narrative' => ['required', 'string', 'max:320'],
            'scenes.*.highlights' => ['required', 'array', 'size:3'],
            'scenes.*.highlights.*' => ['required', 'string', 'max:140'],

            'scenes.*.image.src' => $path,
            'scenes.*.image.src_mobile' => ['nullable', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'],
            'scenes.*.image.width' => ['required', 'integer', 'min:320', 'max:4000'],
            'scenes.*.image.height' => ['required', 'integer', 'min:200', 'max:4000'],
            'scenes.*.image.alt' => ['required', 'string', 'max:200'],
            'scenes.*.image.provenance' => ['required', 'in:facility,illustrative'],
            'scenes.*.image.source_url' => ['nullable', 'url', 'max:255'],
            'scenes.*.image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],
            'scenes.*.image.label' => ['required', 'string', 'max:60'],
            'scenes.*.image.caption' => ['nullable', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'scenes' => array_map(fn (array $s) => [
                'id' => $s['id'],
                'rhythm' => InlineText::plain($s['rhythm']),
                'title' => InlineText::plain($s['title']),
                'narrative' => InlineText::plain($s['narrative']),
                'highlights' => array_map(fn (string $h) => InlineText::plain($h), $s['highlights']),
                'image' => [
                    'src' => $s['image']['src'],
                    'src_mobile' => $s['image']['src_mobile'] ?? null,
                    'width' => (int) $s['image']['width'],
                    'height' => (int) $s['image']['height'],
                    'alt' => InlineText::plain($s['image']['alt']),
                    'provenance' => $s['image']['provenance'],
                    'source_url' => $s['image']['source_url'] ?? null,
                    'rights' => $s['image']['rights'],
                    'label' => InlineText::plain($s['image']['label']),
                    'caption' => isset($s['image']['caption']) ? InlineText::plain($s['image']['caption']) : null,
                ],
            ], $valid['scenes']),
        ];
    }
}
