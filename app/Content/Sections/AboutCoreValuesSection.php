<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * About Section 04: Core Values & Daily Community Activities.
 *
 * Connecting Mission Villa's guiding values (Dignity, Engagement, Shared Table, Family Trust)
 * directly with daily activities, culinary experiences, and routines.
 */
final class AboutCoreValuesSection implements SectionSchema
{
    public static function type(): string
    {
        return 'about.core-values';
    }

    public static function label(): string
    {
        return 'About Core Values (4-pillar grid connecting principles to daily activities)';
    }

    public static function view(): string
    {
        return 'sections.about-core-values.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:120'],
            'intro' => ['required', 'string', 'max:400'],

            'values' => ['required', 'array', 'size:4'],
            'values.*.id' => ['required', 'string', 'max:40'],
            'values.*.index' => ['required', 'string', 'max:10'],
            'values.*.title' => ['required', 'string', 'max:80'],
            'values.*.script_accent' => ['required', 'string', 'max:50'],
            'values.*.summary' => ['required', 'string', 'max:300'],
            'values.*.connected_activities' => ['required', 'array', 'min:2', 'max:5'],
            'values.*.connected_activities.*' => ['required', 'string', 'max:160'],
            'values.*.related_route' => ['required', 'array'],
            'values.*.related_route.label' => ['required', 'string', 'max:50'],
            'values.*.related_route.href' => ['required', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'values' => array_map(function (array $val): array {
                return [
                    'id' => $val['id'],
                    'index' => InlineText::plain($val['index']),
                    'title' => InlineText::plain($val['title']),
                    'script_accent' => InlineText::plain($val['script_accent']),
                    'summary' => InlineText::plain($val['summary']),
                    'connected_activities' => array_map(fn ($act) => InlineText::plain($act), $val['connected_activities']),
                    'related_route' => [
                        'label' => InlineText::plain($val['related_route']['label']),
                        'href' => $val['related_route']['href'],
                    ],
                ];
            }, $valid['values']),
        ];
    }
}
