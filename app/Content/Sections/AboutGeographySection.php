<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * About Section 03: Neighborhood & Local Geography Story.
 *
 * Grounded at 995 East Market Street near San Bruno Mountain foothills in Daly City,
 * featuring interactive category filtering, landmark spotlights, and proximity contexts.
 */
final class AboutGeographySection implements SectionSchema
{
    public const RIGHTS = ['cleared', 'unconfirmed'];

    public static function type(): string
    {
        return 'about.geography';
    }

    public static function label(): string
    {
        return 'About Daly City Geography & Peninsula Setting (interactive landmark atlas)';
    }

    public static function view(): string
    {
        return 'sections.about-geography.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:120'],
            'intro' => ['required', 'string', 'max:400'],
            'address' => ['required', 'string', 'max:120'],

            'categories' => ['required', 'array', 'min:3', 'max:6'],
            'categories.*' => ['required', 'string', 'max:40'],

            'landmarks' => ['required', 'array', 'min:3', 'max:6'],
            'landmarks.*.id' => ['required', 'string', 'max:40'],
            'landmarks.*.index_code' => ['required', 'string', 'max:20'],
            'landmarks.*.category' => ['required', 'string', 'max:40'],
            'landmarks.*.title' => ['required', 'string', 'max:80'],
            'landmarks.*.subtitle' => ['required', 'string', 'max:100'],
            'landmarks.*.proximity_context' => ['required', 'string', 'max:140'],
            'landmarks.*.description' => ['required', 'string', 'max:500'],
            'landmarks.*.why_it_matters' => ['required', 'array', 'min:2', 'max:5'],
            'landmarks.*.why_it_matters.*' => ['required', 'string', 'max:200'],
            'landmarks.*.inquiry_note' => ['required', 'string', 'max:250'],

            'landmarks.*.image' => ['required', 'array'],
            'landmarks.*.image.src' => $path,
            'landmarks.*.image.width' => ['required', 'integer', 'min:300', 'max:3000'],
            'landmarks.*.image.height' => ['required', 'integer', 'min:200', 'max:3000'],
            'landmarks.*.image.alt' => ['required', 'string', 'max:200'],
            'landmarks.*.image.caption' => ['required', 'string', 'max:160'],
            'landmarks.*.image.status' => ['required', 'string', 'max:60'],
            'landmarks.*.image.provenance' => ['required', 'in:facility,illustrative'],
            'landmarks.*.image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'address' => InlineText::plain($valid['address']),
            'categories' => array_map(fn ($cat) => InlineText::plain($cat), $valid['categories']),
            'landmarks' => array_map(function (array $lm): array {
                return [
                    'id' => $lm['id'],
                    'index_code' => InlineText::plain($lm['index_code']),
                    'category' => InlineText::plain($lm['category']),
                    'title' => InlineText::plain($lm['title']),
                    'subtitle' => InlineText::plain($lm['subtitle']),
                    'proximity_context' => InlineText::plain($lm['proximity_context']),
                    'description' => InlineText::plain($lm['description']),
                    'why_it_matters' => array_map(fn ($reason) => InlineText::plain($reason), $lm['why_it_matters']),
                    'inquiry_note' => InlineText::plain($lm['inquiry_note']),
                    'image' => [
                        'src' => $lm['image']['src'],
                        'width' => $lm['image']['width'],
                        'height' => $lm['image']['height'],
                        'alt' => $lm['image']['alt'],
                        'caption' => InlineText::plain($lm['image']['caption']),
                        'status' => InlineText::plain($lm['image']['status']),
                        'provenance' => $lm['image']['provenance'],
                        'rights' => $lm['image']['rights'],
                    ],
                ];
            }, $valid['landmarks']),
        ];
    }
}
