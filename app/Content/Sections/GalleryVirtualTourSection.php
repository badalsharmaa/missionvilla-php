<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Support\InquiryIntents;
use Illuminate\Support\Facades\Validator;

/**
 * Gallery & Virtual Tour Section 03: Virtual Tour Stage & Guided Walkthrough.
 *
 * Rich plum canvas (#3B2348) presenting a 4-stop interactive spatial walkthrough
 * and live video tour invitation.
 */
final class GalleryVirtualTourSection implements SectionSchema
{
    public const RIGHTS = ['cleared', 'unconfirmed'];

    public static function type(): string
    {
        return 'gallery.virtual-tour';
    }

    public static function label(): string
    {
        return 'Gallery Virtual Tour Stage (4-stop spatial walkthrough & video tour card)';
    }

    public static function view(): string
    {
        return 'sections.gallery-virtual-tour.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:120'],
            'intro' => ['required', 'string', 'max:400'],

            'stops' => ['required', 'array', 'size:4'],
            'stops.*.stop_index' => ['required', 'string', 'max:10'],
            'stops.*.title' => ['required', 'string', 'max:80'],
            'stops.*.location_label' => ['required', 'string', 'max:80'],
            'stops.*.summary' => ['required', 'string', 'max:350'],
            'stops.*.highlights' => ['required', 'array', 'min:2', 'max:4'],
            'stops.*.highlights.*' => ['required', 'string', 'max:120'],
            'stops.*.look_for' => ['required', 'string', 'max:220'],
            'stops.*.route_href' => $path,
            'stops.*.route_label' => ['required', 'string', 'max:50'],

            'stops.*.image' => ['required', 'array'],
            'stops.*.image.src' => $path,
            'stops.*.image.width' => ['required', 'integer', 'min:300', 'max:3000'],
            'stops.*.image.height' => ['required', 'integer', 'min:200', 'max:3000'],
            'stops.*.image.alt' => ['required', 'string', 'max:200'],
            'stops.*.image.provenance' => ['required', 'in:facility,illustrative'],
            'stops.*.image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],
            'stops.*.image.label' => ['required', 'string', 'max:60'],

            'action_box' => ['required', 'array'],
            'action_box.title' => ['required', 'string', 'max:80'],
            'action_box.text' => ['required', 'string', 'max:300'],
            'action_box.cta_label' => ['required', 'string', 'max:50'],
            'action_box.cta_intent' => ['required', 'in:'.implode(',', InquiryIntents::accepted())],
            'action_box.phone_label' => ['required', 'string', 'max:50'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'stops' => array_map(function (array $stop): array {
                return [
                    'stop_index' => $stop['stop_index'],
                    'title' => InlineText::plain($stop['title']),
                    'location_label' => InlineText::plain($stop['location_label']),
                    'summary' => InlineText::plain($stop['summary']),
                    'highlights' => array_map(fn ($h) => InlineText::plain($h), $stop['highlights']),
                    'look_for' => InlineText::plain($stop['look_for']),
                    'route_href' => $stop['route_href'],
                    'route_label' => InlineText::plain($stop['route_label']),
                    'image' => [
                        'src' => $stop['image']['src'],
                        'width' => $stop['image']['width'],
                        'height' => $stop['image']['height'],
                        'alt' => $stop['image']['alt'],
                        'provenance' => $stop['image']['provenance'],
                        'rights' => $stop['image']['rights'],
                        'label' => InlineText::plain($stop['image']['label']),
                    ],
                ];
            }, $valid['stops']),
            'action_box' => [
                'title' => InlineText::plain($valid['action_box']['title']),
                'text' => InlineText::plain($valid['action_box']['text']),
                'cta_label' => InlineText::plain($valid['action_box']['cta_label']),
                'cta_intent' => $valid['action_box']['cta_intent'],
                'phone_label' => InlineText::plain($valid['action_box']['phone_label']),
            ],
        ];
    }
}
