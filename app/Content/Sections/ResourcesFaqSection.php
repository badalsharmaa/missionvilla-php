<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Resources Section 05: Searchable Resources, Brochure & Archive FAQs.
 *
 * 6 categorized FAQ items covering guides, brochure requests, and blog verification.
 */
final class ResourcesFaqSection implements SectionSchema
{
    public static function type(): string
    {
        return 'resources.faq';
    }

    public static function label(): string
    {
        return 'Resources FAQs (6 searchable questions across 4 categories)';
    }

    public static function view(): string
    {
        return 'sections.resources-faq.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:80'],
            'heading' => ['required', 'string', 'max:140'],
            'intro' => ['required', 'string', 'max:500'],

            'categories' => ['required', 'array', 'size:4'],
            'categories.*' => ['required', 'string', 'max:40'],

            'items' => ['required', 'array', 'size:6'],
            'items.*.id' => ['required', 'string', 'max:50'],
            'items.*.code' => ['required', 'string', 'max:20'],
            'items.*.category' => ['required', 'string', 'max:40'],
            'items.*.question' => ['required', 'string', 'max:200'],
            'items.*.answer' => ['required', 'string', 'max:800'],
            'items.*.relatedHref' => ['required', 'string', 'max:100'],
            'items.*.relatedLabel' => ['required', 'string', 'max:60'],
            'items.*.confirmationNote' => ['nullable', 'string', 'max:300'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::render($valid['intro']),
            'categories' => array_map(fn($c) => InlineText::plain($c), $valid['categories']),
            'items' => array_map(function (array $it) {
                return [
                    'id' => $it['id'],
                    'code' => InlineText::plain($it['code']),
                    'category' => InlineText::plain($it['category']),
                    'question' => InlineText::plain($it['question']),
                    'answer' => trim($it['answer']),
                    'relatedHref' => $it['relatedHref'],
                    'relatedLabel' => InlineText::plain($it['relatedLabel']),
                    'confirmationNote' => isset($it['confirmationNote']) ? InlineText::plain($it['confirmationNote']) : null,
                ];
            }, $valid['items']),
        ];
    }
}
