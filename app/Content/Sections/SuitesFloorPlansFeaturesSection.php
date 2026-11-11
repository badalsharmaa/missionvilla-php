<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Suites & Floor Plans Section 04: Safety, Privacy & Everyday Specs.
 *
 * Warm cream section with 4 structured specification cards verifying
 * private bathrooms, memory support cues, safety call systems, and proximity.
 */
final class SuitesFloorPlansFeaturesSection implements SectionSchema
{
    public const ICONS = ['bath', 'heart', 'shield', 'compass', 'bed', 'sparkles', 'home'];

    public static function type(): string
    {
        return 'suites-floor-plans.features';
    }

    public static function label(): string
    {
        return 'Suites & Floor Plans Features (4 spec cards)';
    }

    public static function view(): string
    {
        return 'sections.suites-floor-plans-features.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:100'],
            'intro' => ['required', 'string', 'max:350'],

            'features' => ['required', 'array', 'size:4'],
            'features.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'features.*.code' => ['required', 'string', 'max:30'],
            'features.*.title' => ['required', 'string', 'max:70'],
            'features.*.lead' => ['required', 'string', 'max:100'],
            'features.*.body' => ['required', 'string', 'max:300'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'features' => array_map(fn (array $f) => [
                'icon' => $f['icon'],
                'code' => InlineText::plain($f['code']),
                'title' => InlineText::plain($f['title']),
                'lead' => InlineText::plain($f['lead']),
                'body' => InlineText::plain($f['body']),
            ], $valid['features']),
        ];
    }
}
