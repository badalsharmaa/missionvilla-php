<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Resources Section 03: Community Brochure Status & Tour Resource Packet Builder.
 *
 * Transparent brochure status card alongside an interactive packet assembler
 * that binds to the shared inquiry modal with custom prefilled notes.
 */
final class ResourcesPacketSection implements SectionSchema
{
    public static function type(): string
    {
        return 'resources.packet';
    }

    public static function label(): string
    {
        return 'Resources Tour Packet Builder (5 selectable materials & brochure status)';
    }

    public static function view(): string
    {
        return 'sections.resources-packet.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:80'],
            'heading' => ['required', 'string', 'max:140'],
            'intro' => ['required', 'string', 'max:500'],

            'brochure_card' => ['required', 'array'],
            'brochure_card.badge' => ['required', 'string', 'max:40'],
            'brochure_card.status' => ['required', 'string', 'max:40'],
            'brochure_card.title' => ['required', 'string', 'max:100'],
            'brochure_card.body' => ['required', 'string', 'max:500'],
            'brochure_card.phone_label' => ['required', 'string', 'max:30'],
            'brochure_card.email_label' => ['required', 'string', 'max:60'],

            'packet_items' => ['required', 'array', 'size:5'],
            'packet_items.*.id' => ['required', 'string', 'max:50'],
            'packet_items.*.code' => ['required', 'string', 'max:20'],
            'packet_items.*.title' => ['required', 'string', 'max:100'],
            'packet_items.*.category' => ['required', 'string', 'max:40'],
            'packet_items.*.description' => ['required', 'string', 'max:300'],
            'packet_items.*.availabilityStatus' => ['required', 'string', 'max:160'],
            'packet_items.*.defaultSelected' => ['required', 'boolean'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::render($valid['intro']),
            'brochure_card' => [
                'badge' => InlineText::plain($valid['brochure_card']['badge']),
                'status' => InlineText::plain($valid['brochure_card']['status']),
                'title' => InlineText::plain($valid['brochure_card']['title']),
                'body' => trim($valid['brochure_card']['body']),
                'phone_label' => InlineText::plain($valid['brochure_card']['phone_label']),
                'email_label' => InlineText::plain($valid['brochure_card']['email_label']),
            ],
            'packet_items' => array_map(function (array $pi) {
                return [
                    'id' => $pi['id'],
                    'code' => InlineText::plain($pi['code']),
                    'title' => InlineText::plain($pi['title']),
                    'category' => InlineText::plain($pi['category']),
                    'description' => InlineText::plain($pi['description']),
                    'availabilityStatus' => InlineText::plain($pi['availabilityStatus']),
                    'defaultSelected' => $pi['defaultSelected'],
                ];
            }, $valid['packet_items']),
        ];
    }
}
