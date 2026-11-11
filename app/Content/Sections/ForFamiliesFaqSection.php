<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * For Families Section 05: Accessible FAQs Grouped by Care, Suites, Cost & Visits.
 *
 * Grouped accordion with category filter tabs, keyword search, expand/collapse all,
 * and direct inquiry links.
 */
final class ForFamiliesFaqSection implements SectionSchema
{
    public static function type(): string
    {
        return 'for-families.faq';
    }

    public static function label(): string
    {
        return 'For Families Grouped FAQs (12 questions across 4 categories with search)';
    }

    public static function view(): string
    {
        return 'sections.for-families-faq.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:140'],
            'intro' => ['required', 'string', 'max:400'],

            'categories' => ['required', 'array', 'min:3', 'max:6'],
            'categories.*' => ['required', 'string', 'max:20'],

            'items' => ['required', 'array', 'size:12'],
            'items.*.id' => ['required', 'string', 'max:40'],
            'items.*.code' => ['required', 'string', 'max:20'],
            'items.*.category' => ['required', 'string', 'max:20'],
            'items.*.question' => ['required', 'string', 'max:160'],
            'items.*.answer' => ['required', 'string', 'max:600'],
            'items.*.related_route_href' => ['required', 'string', 'max:100'],
            'items.*.related_route_label' => ['required', 'string', 'max:60'],
            'items.*.confirmation_note' => ['nullable', 'string', 'max:200'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::render($valid['intro']),
            'categories' => array_map(fn ($cat) => InlineText::plain($cat), $valid['categories']),
            'items' => array_map(function (array $it): array {
                return [
                    'id' => $it['id'],
                    'code' => InlineText::plain($it['code']),
                    'category' => InlineText::plain($it['category']),
                    'question' => InlineText::plain($it['question']),
                    'answer' => InlineText::plain($it['answer']),
                    'related_route_href' => $it['related_route_href'],
                    'related_route_label' => InlineText::plain($it['related_route_label']),
                    'confirmation_note' => isset($it['confirmation_note']) ? InlineText::plain($it['confirmation_note']) : null,
                ];
            }, $valid['items']),
        ];
    }
}
