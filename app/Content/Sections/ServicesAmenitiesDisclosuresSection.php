<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Support\InquiryIntents;
use Illuminate\Support\Facades\Validator;

/**
 * Services & Amenities Section 04: Practical "Ask Us About..." Disclosures.
 *
 * Rich plum canvas (#3B2348) with 4 transparent guidance topics detailing
 * RCFE care scope, base inclusions vs optional services, assessments, and respite terms.
 */
final class ServicesAmenitiesDisclosuresSection implements SectionSchema
{
    public static function type(): string
    {
        return 'services-and-amenities.disclosures';
    }

    public static function label(): string
    {
        return 'Services & Amenities Disclosures (4 topics, transparent guidance, visit preparation)';
    }

    public static function view(): string
    {
        return 'sections.services-and-amenities-disclosures.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:120'],
            'intro' => ['required', 'string', 'max:400'],

            'disclosures' => ['required', 'array', 'size:4'],
            'disclosures.*.id' => ['required', 'string', 'max:50'],
            'disclosures.*.index' => ['required', 'string', 'max:10'],
            'disclosures.*.title' => ['required', 'string', 'max:80'],
            'disclosures.*.summary' => ['required', 'string', 'max:350'],
            'disclosures.*.key_points' => ['required', 'array', 'min:2', 'max:4'],
            'disclosures.*.key_points.*' => ['required', 'string', 'max:140'],
            'disclosures.*.confirmation_flag' => ['required', 'string', 'max:220'],

            'action_card' => ['required', 'array'],
            'action_card.title' => ['required', 'string', 'max:80'],
            'action_card.text' => ['required', 'string', 'max:260'],
            'action_card.phone_label' => ['required', 'string', 'max:50'],
            'action_card.cta_label' => ['required', 'string', 'max:50'],
            'action_card.cta_intent' => ['required', 'in:'.implode(',', InquiryIntents::accepted())],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'disclosures' => array_map(function (array $disc): array {
                return [
                    'id' => $disc['id'],
                    'index' => $disc['index'],
                    'title' => InlineText::plain($disc['title']),
                    'summary' => InlineText::plain($disc['summary']),
                    'key_points' => array_map(fn ($k) => InlineText::plain($k), $disc['key_points']),
                    'confirmation_flag' => InlineText::plain($disc['confirmation_flag']),
                ];
            }, $valid['disclosures']),
            'action_card' => [
                'title' => InlineText::plain($valid['action_card']['title']),
                'text' => InlineText::plain($valid['action_card']['text']),
                'phone_label' => InlineText::plain($valid['action_card']['phone_label']),
                'cta_label' => InlineText::plain($valid['action_card']['cta_label']),
                'cta_intent' => $valid['action_card']['cta_intent'],
            ],
        ];
    }
}
