<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Financial Planning Section 06: Dedicated Financial FAQs.
 *
 * 6 questions addressing pricing structure, care assessments, inclusions,
 * Companion Unit savings, Long-Term Care insurance, and short-term respite billing.
 */
final class FinancialPlanningFaqSection implements SectionSchema
{
    public static function type(): string
    {
        return 'financial-planning.faq';
    }

    public static function label(): string
    {
        return 'Financial Planning FAQs (6 source-grounded cost questions)';
    }

    public static function view(): string
    {
        return 'sections.financial-planning-faq.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:80'],
            'heading' => ['required', 'string', 'max:140'],
            'intro' => ['required', 'string', 'max:500'],

            'items' => ['required', 'array', 'size:6'],
            'items.*.id' => ['required', 'string', 'max:40'],
            'items.*.category' => ['required', 'string', 'max:40'],
            'items.*.question' => ['required', 'string', 'max:160'],
            'items.*.answer' => ['required', 'string', 'max:600'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::render($valid['intro']),
            'items' => array_map(function (array $it): array {
                return [
                    'id' => $it['id'],
                    'category' => InlineText::plain($it['category']),
                    'question' => InlineText::plain($it['question']),
                    'answer' => InlineText::plain($it['answer']),
                ];
            }, $valid['items']),
        ];
    }
}
