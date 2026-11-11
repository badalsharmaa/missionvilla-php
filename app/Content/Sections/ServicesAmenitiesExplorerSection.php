<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Services & Amenities Section 02: Categorized Directory & Explorer.
 *
 * Warm paper canvas (#F7F4ED) featuring a 5-category switcher, editorial photo pairing,
 * and structured ledger of 17 source-grounded services and amenities.
 */
final class ServicesAmenitiesExplorerSection implements SectionSchema
{
    public const RIGHTS = ['cleared', 'unconfirmed'];
    public const CLASSIFICATIONS = ['Community Service', 'Community Amenity'];

    public static function type(): string
    {
        return 'services-and-amenities.explorer';
    }

    public static function label(): string
    {
        return 'Services & Amenities Explorer (5 categories, 17 item ledgers, photo pairings)';
    }

    public static function view(): string
    {
        return 'sections.services-and-amenities-explorer.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:100'],
            'intro' => ['required', 'string', 'max:350'],

            'categories' => ['required', 'array', 'size:5'],
            'categories.*.id' => ['required', 'string', 'max:30'],
            'categories.*.code' => ['required', 'string', 'max:10'],
            'categories.*.label' => ['required', 'string', 'max:40'],
            'categories.*.title' => ['required', 'string', 'max:80'],
            'categories.*.subtitle' => ['required', 'string', 'max:140'],
            'categories.*.narrative' => ['required', 'string', 'max:450'],
            'categories.*.reassurance' => ['required', 'string', 'max:280'],

            'categories.*.pairing_image' => ['required', 'array'],
            'categories.*.pairing_image.src' => $path,
            'categories.*.pairing_image.width' => ['required', 'integer', 'min:300', 'max:3000'],
            'categories.*.pairing_image.height' => ['required', 'integer', 'min:200', 'max:3000'],
            'categories.*.pairing_image.alt' => ['required', 'string', 'max:200'],
            'categories.*.pairing_image.provenance' => ['required', 'in:facility,illustrative'],
            'categories.*.pairing_image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],
            'categories.*.pairing_image.label' => ['required', 'string', 'max:60'],

            'categories.*.vignette' => ['required', 'array'],
            'categories.*.vignette.title' => ['required', 'string', 'max:60'],
            'categories.*.vignette.detail' => ['required', 'string', 'max:200'],

            'categories.*.items' => ['required', 'array', 'min:2', 'max:6'],
            'categories.*.items.*.id' => ['required', 'string', 'max:50'],
            'categories.*.items.*.code' => ['required', 'string', 'max:20'],
            'categories.*.items.*.classification' => ['required', 'in:'.implode(',', self::CLASSIFICATIONS)],
            'categories.*.items.*.title' => ['required', 'string', 'max:70'],
            'categories.*.items.*.subtitle' => ['required', 'string', 'max:140'],
            'categories.*.items.*.description' => ['required', 'string', 'max:350'],
            'categories.*.items.*.supports' => ['required', 'array', 'min:2', 'max:4'],
            'categories.*.items.*.supports.*' => ['required', 'string', 'max:130'],
            'categories.*.items.*.confirmation_note' => ['required', 'string', 'max:220'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'categories' => array_map(function (array $cat): array {
                return [
                    'id' => $cat['id'],
                    'code' => $cat['code'],
                    'label' => InlineText::plain($cat['label']),
                    'title' => InlineText::plain($cat['title']),
                    'subtitle' => InlineText::plain($cat['subtitle']),
                    'narrative' => InlineText::plain($cat['narrative']),
                    'reassurance' => InlineText::plain($cat['reassurance']),
                    'pairing_image' => [
                        'src' => $cat['pairing_image']['src'],
                        'width' => $cat['pairing_image']['width'],
                        'height' => $cat['pairing_image']['height'],
                        'alt' => $cat['pairing_image']['alt'],
                        'provenance' => $cat['pairing_image']['provenance'],
                        'rights' => $cat['pairing_image']['rights'],
                        'label' => InlineText::plain($cat['pairing_image']['label']),
                    ],
                    'vignette' => [
                        'title' => InlineText::plain($cat['vignette']['title']),
                        'detail' => InlineText::plain($cat['vignette']['detail']),
                    ],
                    'items' => array_map(function (array $item): array {
                        return [
                            'id' => $item['id'],
                            'code' => $item['code'],
                            'classification' => $item['classification'],
                            'title' => InlineText::plain($item['title']),
                            'subtitle' => InlineText::plain($item['subtitle']),
                            'description' => InlineText::plain($item['description']),
                            'supports' => array_map(fn ($s) => InlineText::plain($s), $item['supports']),
                            'confirmation_note' => InlineText::plain($item['confirmation_note']),
                        ];
                    }, $cat['items']),
                ];
            }, $valid['categories']),
        ];
    }
}
