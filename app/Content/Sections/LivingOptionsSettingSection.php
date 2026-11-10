<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Living Options Section 04: A Welcoming, Homelike Setting.
 *
 * Light cream section with 4 compact feature cards covering
 * dining, engagement, outdoor spaces, and everyday support.
 */
final class LivingOptionsSettingSection implements SectionSchema
{
    public const ICONS = ['utensils', 'sparkles', 'sprout', 'shield', 'armchair', 'heart', 'home'];

    public static function type(): string
    {
        return 'living-options.setting';
    }

    public static function label(): string
    {
        return 'Living Options Homelike Setting (4 community feature cards)';
    }

    public static function view(): string
    {
        return 'sections.living-options-setting.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:100'],
            'intro' => ['required', 'string', 'max:350'],

            'features' => ['required', 'array', 'size:4'],
            'features.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'features.*.title' => ['required', 'string', 'max:60'],
            'features.*.lead' => ['required', 'string', 'max:80'],
            'features.*.body' => ['required', 'string', 'max:250'],
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
                'title' => InlineText::plain($f['title']),
                'lead' => InlineText::plain($f['lead']),
                'body' => InlineText::plain($f['body']),
            ], $valid['features']),
        ];
    }
}
