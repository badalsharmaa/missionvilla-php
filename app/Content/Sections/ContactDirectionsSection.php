<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Contact Section 03: Grounded Map, Peninsula Directions & Arrival Context (#map-and-directions).
 *
 * Grounded in React reference app/contact/page.tsx.
 * Provides interactive corridor switching across I-280, San Francisco, BART & SamTrans,
 * and on-site visitor parking & step-free accessibility.
 */
final class ContactDirectionsSection implements SectionSchema
{
    public static function type(): string
    {
        return 'contact.directions';
    }

    public static function label(): string
    {
        return 'Contact Directions (Grounded map, Peninsula corridors & accessible arrival)';
    }

    public static function view(): string
    {
        return 'sections.contact-directions.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'script_title' => ['required', 'string', 'max:80'],
            'heading' => ['required', 'string', 'max:160'],
            'intro' => ['required', 'string', 'max:600'],
            'maps_url' => ['required', 'string', 'max:255'],
            'maps_embed_url' => ['required', 'string', 'max:255'],

            'orientation_image' => ['required', 'array'],
            'orientation_image.src' => ['required', 'string', 'max:120'],
            'orientation_image.alt' => ['required', 'string', 'max:200'],
            'orientation_image.badge' => ['required', 'string', 'max:60'],
            'orientation_image.subtitle' => ['required', 'string', 'max:60'],
            'orientation_image.title' => ['required', 'string', 'max:100'],
            'orientation_image.phone' => ['required', 'string', 'max:30'],

            'categories' => ['required', 'array', 'min:3'],
            'categories.*' => ['required', 'string', 'max:50'],

            'corridors' => ['required', 'array', 'size:4'],
            'corridors.*.id' => ['required', 'string', 'max:40'],
            'corridors.*.code' => ['required', 'string', 'max:20'],
            'corridors.*.category' => ['required', 'string', 'max:50'],
            'corridors.*.title' => ['required', 'string', 'max:120'],
            'corridors.*.subtitle' => ['required', 'string', 'max:160'],
            'corridors.*.route_summary' => ['required', 'string', 'max:400'],
            'corridors.*.landmarks_and_streets' => ['required', 'array', 'min:2'],
            'corridors.*.landmarks_and_streets.*' => ['required', 'string', 'max:200'],
            'corridors.*.arrival_tip' => ['required', 'string', 'max:300'],

            'neighborhood_anchors' => ['required', 'array', 'min:2'],
            'neighborhood_anchors.*.title' => ['required', 'string', 'max:80'],
            'neighborhood_anchors.*.description' => ['required', 'string', 'max:300'],
            'neighborhood_anchors.*.icon' => ['required', 'string', 'max:30'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'script_title' => InlineText::plain($valid['script_title']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::render($valid['intro']),
            'maps_url' => $valid['maps_url'],
            'maps_embed_url' => $valid['maps_embed_url'],
            'orientation_image' => $valid['orientation_image'],
            'categories' => $valid['categories'],
            'corridors' => $valid['corridors'],
            'neighborhood_anchors' => $valid['neighborhood_anchors'],
        ];
    }
}
