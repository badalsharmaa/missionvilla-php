<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * For Families Section 06: Contextual Planning Bridge.
 *
 * 3-card pathway connecting families to Financial Planning, Living Options,
 * and personal tour booking.
 */
final class ForFamiliesBridgeSection implements SectionSchema
{
    public const ICONS = ['worksheet', 'care', 'phone'];

    public static function type(): string
    {
        return 'for-families.bridge';
    }

    public static function label(): string
    {
        return 'For Families Planning Bridge (3-card next-step navigational folio)';
    }

    public static function view(): string
    {
        return 'sections.for-families-bridge.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'cards' => ['required', 'array', 'size:3'],
            'cards.*.id' => ['required', 'string', 'max:40'],
            'cards.*.kicker' => ['required', 'string', 'max:40'],
            'cards.*.title' => ['required', 'string', 'max:80'],
            'cards.*.description' => ['required', 'string', 'max:300'],
            'cards.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'cards.*.links' => ['required', 'array', 'min:1', 'max:2'],
            'cards.*.links.*.label' => ['required', 'string', 'max:40'],
            'cards.*.links.*.href' => ['nullable', 'string', 'max:100'],
            'cards.*.links.*.style' => ['required', 'in:primary,secondary,jump'],
            'cards.*.links.*.target' => ['nullable', 'string', 'max:40'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'cards' => array_map(function (array $c): array {
                return [
                    'id' => $c['id'],
                    'kicker' => InlineText::plain($c['kicker']),
                    'title' => InlineText::plain($c['title']),
                    'description' => InlineText::plain($c['description']),
                    'icon' => $c['icon'],
                    'links' => array_map(fn (array $l) => [
                        'label' => InlineText::plain($l['label']),
                        'href' => $l['href'] ?? null,
                        'style' => $l['style'],
                        'target' => $l['target'] ?? null,
                    ], $c['links']),
                ];
            }, $valid['cards']),
        ];
    }
}
