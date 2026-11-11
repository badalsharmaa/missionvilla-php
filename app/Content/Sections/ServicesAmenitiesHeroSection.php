<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Support\InquiryIntents;
use Illuminate\Support\Facades\Validator;

/**
 * Services & Amenities Section 01: Conservatory Plum Hero.
 *
 * Immersive deep plum hero (#22122B) with breadcrumbs, warm conservatory glows,
 * editorial statement, and 5-category quick jump dock.
 */
final class ServicesAmenitiesHeroSection implements SectionSchema
{
    public const ICONS = ['shield', 'utensils', 'sparkles', 'trees', 'concierge', 'phone', 'calendar', 'arrow', 'file-text'];

    public static function type(): string
    {
        return 'services-and-amenities.hero';
    }

    public static function label(): string
    {
        return 'Services & Amenities Hero (deep plum conservatory, category dock)';
    }

    public static function view(): string
    {
        return 'sections.services-and-amenities-hero.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:120'],
            'editorial' => ['required', 'string', 'max:160'],
            'intro' => ['required', 'string', 'max:400'],

            'categories_dock' => ['required', 'array', 'size:5'],
            'categories_dock.*.id' => ['required', 'string', 'max:30'],
            'categories_dock.*.index' => ['required', 'string', 'max:10'],
            'categories_dock.*.label' => ['required', 'string', 'max:40'],
            'categories_dock.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],

            'actions' => ['required', 'array', 'min:2', 'max:3'],
            'actions.*.label' => ['required', 'string', 'max:40'],
            'actions.*.style' => ['required', 'in:primary,secondary,phone'],
            'actions.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'actions.*.intent' => ['nullable', 'in:'.implode(',', InquiryIntents::accepted())],
            'actions.*.care' => ['nullable', 'string', 'max:30'],
            'actions.*.href' => ['nullable', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'editorial' => InlineText::plain($valid['editorial']),
            'intro' => InlineText::plain($valid['intro']),
            'categories_dock' => array_map(function (array $item): array {
                return [
                    'id' => $item['id'],
                    'index' => $item['index'],
                    'label' => InlineText::plain($item['label']),
                    'icon' => $item['icon'],
                ];
            }, $valid['categories_dock']),
            'actions' => array_map(function (array $action): array {
                return [
                    'label' => InlineText::plain($action['label']),
                    'style' => $action['style'],
                    'icon' => $action['icon'],
                    'intent' => $action['intent'] ?? null,
                    'care' => $action['care'] ?? 'exploring',
                    'href' => $action['href'] ?? null,
                ];
            }, $valid['actions']),
        ];
    }
}
