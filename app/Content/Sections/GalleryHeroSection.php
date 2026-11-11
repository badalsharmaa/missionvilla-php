<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Support\InquiryIntents;
use Illuminate\Support\Facades\Validator;

/**
 * Gallery & Virtual Tour Section 01: Pressed-Linen Exhibition Hero.
 *
 * Warm paper canvas (#F7F4ED) featuring exhibition metadata, 3-plate aperture preview,
 * and category quick jump navigation dock.
 */
final class GalleryHeroSection implements SectionSchema
{
    public const RIGHTS = ['cleared', 'unconfirmed'];
    public const ICONS = ['calendar', 'arrow', 'phone', 'compass', 'eye'];

    public static function type(): string
    {
        return 'gallery.hero';
    }

    public static function label(): string
    {
        return 'Gallery Exhibition Hero (paper canvas, 3-plate aperture preview)';
    }

    public static function view(): string
    {
        return 'sections.gallery-hero.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:120'],
            'editorial' => ['required', 'string', 'max:160'],
            'intro' => ['required', 'string', 'max:400'],

            'previews' => ['required', 'array', 'size:3'],
            'previews.*.cutout_label' => ['required', 'string', 'max:40'],
            'previews.*.label' => ['required', 'string', 'max:60'],
            'previews.*.image' => ['required', 'array'],
            'previews.*.image.src' => $path,
            'previews.*.image.width' => ['required', 'integer', 'min:300', 'max:3000'],
            'previews.*.image.height' => ['required', 'integer', 'min:200', 'max:3000'],
            'previews.*.image.alt' => ['required', 'string', 'max:200'],
            'previews.*.image.provenance' => ['required', 'in:facility,illustrative'],
            'previews.*.image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],

            'categories' => ['required', 'array', 'size:5'],
            'categories.*.id' => ['required', 'string', 'max:30'],
            'categories.*.label' => ['required', 'string', 'max:40'],
            'categories.*.count' => ['required', 'integer', 'min:1', 'max:20'],

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
            'previews' => array_map(function (array $prev): array {
                return [
                    'cutout_label' => InlineText::plain($prev['cutout_label']),
                    'label' => InlineText::plain($prev['label']),
                    'image' => [
                        'src' => $prev['image']['src'],
                        'width' => $prev['image']['width'],
                        'height' => $prev['image']['height'],
                        'alt' => $prev['image']['alt'],
                        'provenance' => $prev['image']['provenance'],
                        'rights' => $prev['image']['rights'],
                    ],
                ];
            }, $valid['previews']),
            'categories' => array_map(function (array $cat): array {
                return [
                    'id' => $cat['id'],
                    'label' => InlineText::plain($cat['label']),
                    'count' => $cat['count'],
                ];
            }, $valid['categories']),
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
