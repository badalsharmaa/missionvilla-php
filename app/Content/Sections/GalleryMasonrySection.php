<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Gallery & Virtual Tour Section 02: Curated Photographic Monograph & Masonry.
 *
 * Warm oat canvas (#FCFBF8) featuring category-filtered visual plates,
 * alternating architectural ratios, and detailed captions.
 */
final class GalleryMasonrySection implements SectionSchema
{
    public const RIGHTS = ['cleared', 'unconfirmed'];
    public const CATEGORIES = ['Rooms', 'Dining', 'Common Areas', 'Outdoor Spaces', 'Activities'];

    public static function type(): string
    {
        return 'gallery.masonry';
    }

    public static function label(): string
    {
        return 'Gallery Masonry Monograph (photo plates with category filtering)';
    }

    public static function view(): string
    {
        return 'sections.gallery-masonry.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:120'],
            'intro' => ['required', 'string', 'max:400'],

            'plates' => ['required', 'array', 'min:6', 'max:14'],
            'plates.*.id' => ['required', 'string', 'max:60'],
            'plates.*.code' => ['required', 'string', 'max:20'],
            'plates.*.category' => ['required', 'in:'.implode(',', self::CATEGORIES)],
            'plates.*.cutout_badge' => ['required', 'string', 'max:50'],
            'plates.*.title' => ['required', 'string', 'max:80'],
            'plates.*.subtitle' => ['required', 'string', 'max:120'],
            'plates.*.caption' => ['required', 'string', 'max:350'],
            'plates.*.spatial_context' => ['required', 'string', 'max:100'],
            'plates.*.highlights' => ['required', 'array', 'min:2', 'max:4'],
            'plates.*.highlights.*' => ['required', 'string', 'max:120'],
            'plates.*.route_label' => ['required', 'string', 'max:60'],
            'plates.*.route_href' => $path,

            'plates.*.image' => ['required', 'array'],
            'plates.*.image.src' => $path,
            'plates.*.image.width' => ['required', 'integer', 'min:300', 'max:3000'],
            'plates.*.image.height' => ['required', 'integer', 'min:200', 'max:3000'],
            'plates.*.image.alt' => ['required', 'string', 'max:200'],
            'plates.*.image.provenance' => ['required', 'in:facility,illustrative'],
            'plates.*.image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],
            'plates.*.image.label' => ['required', 'string', 'max:60'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'plates' => array_map(function (array $plate): array {
                return [
                    'id' => $plate['id'],
                    'code' => $plate['code'],
                    'category' => $plate['category'],
                    'cutout_badge' => InlineText::plain($plate['cutout_badge']),
                    'title' => InlineText::plain($plate['title']),
                    'subtitle' => InlineText::plain($plate['subtitle']),
                    'caption' => InlineText::plain($plate['caption']),
                    'spatial_context' => InlineText::plain($plate['spatial_context']),
                    'highlights' => array_map(fn ($h) => InlineText::plain($h), $plate['highlights']),
                    'route_label' => InlineText::plain($plate['route_label']),
                    'route_href' => $plate['route_href'],
                    'image' => [
                        'src' => $plate['image']['src'],
                        'width' => $plate['image']['width'],
                        'height' => $plate['image']['height'],
                        'alt' => $plate['image']['alt'],
                        'provenance' => $plate['image']['provenance'],
                        'rights' => $plate['image']['rights'],
                        'label' => InlineText::plain($plate['image']['label']),
                    ],
                ];
            }, $valid['plates']),
        ];
    }
}
