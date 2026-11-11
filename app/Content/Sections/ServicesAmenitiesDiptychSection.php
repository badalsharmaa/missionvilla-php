<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Services & Amenities Section 03: Panoramic Photographic Feature Diptych.
 *
 * Warm oat canvas (#F2ECE0) presenting how everyday dining, courtyard air,
 * and supportive spaces come together at 995 East Market Street.
 */
final class ServicesAmenitiesDiptychSection implements SectionSchema
{
    public const RIGHTS = ['cleared', 'unconfirmed'];
    public const ICONS = ['sun', 'utensils', 'heart', 'shield', 'sparkles', 'trees'];

    public static function type(): string
    {
        return 'services-and-amenities.diptych';
    }

    public static function label(): string
    {
        return 'Services & Amenities Diptych (panoramic photo feature + 3 field notes)';
    }

    public static function view(): string
    {
        return 'sections.services-and-amenities-diptych.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:120'],
            'intro' => ['required', 'string', 'max:350'],

            'feature' => ['required', 'array'],
            'feature.cutout_label' => ['required', 'string', 'max:40'],
            'feature.title' => ['required', 'string', 'max:80'],
            'feature.subtitle' => ['required', 'string', 'max:120'],
            'feature.quote' => ['required', 'string', 'max:250'],
            'feature.image' => ['required', 'array'],
            'feature.image.src' => $path,
            'feature.image.width' => ['required', 'integer', 'min:300', 'max:3000'],
            'feature.image.height' => ['required', 'integer', 'min:200', 'max:3000'],
            'feature.image.alt' => ['required', 'string', 'max:200'],
            'feature.image.provenance' => ['required', 'in:facility,illustrative'],
            'feature.image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],
            'feature.image.label' => ['required', 'string', 'max:60'],

            'field_notes' => ['required', 'array', 'size:3'],
            'field_notes.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'field_notes.*.title' => ['required', 'string', 'max:60'],
            'field_notes.*.desc' => ['required', 'string', 'max:250'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'feature' => [
                'cutout_label' => InlineText::plain($valid['feature']['cutout_label']),
                'title' => InlineText::plain($valid['feature']['title']),
                'subtitle' => InlineText::plain($valid['feature']['subtitle']),
                'quote' => InlineText::plain($valid['feature']['quote']),
                'image' => [
                    'src' => $valid['feature']['image']['src'],
                    'width' => $valid['feature']['image']['width'],
                    'height' => $valid['feature']['image']['height'],
                    'alt' => $valid['feature']['image']['alt'],
                    'provenance' => $valid['feature']['image']['provenance'],
                    'rights' => $valid['feature']['image']['rights'],
                    'label' => InlineText::plain($valid['feature']['image']['label']),
                ],
            ],
            'field_notes' => array_map(function (array $note): array {
                return [
                    'icon' => $note['icon'],
                    'title' => InlineText::plain($note['title']),
                    'desc' => InlineText::plain($note['desc']),
                ];
            }, $valid['field_notes']),
        ];
    }
}
