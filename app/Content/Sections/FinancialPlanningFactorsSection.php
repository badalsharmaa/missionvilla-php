<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Financial Planning Section 02: 4 Core Factors Shaping Care Costs.
 *
 * Explains how Care Assessment, Suite Layout, Stay Duration, and Inclusions
 * determine monthly pricing without hidden fees or misleading fixed estimates.
 */
final class FinancialPlanningFactorsSection implements SectionSchema
{
    public static function type(): string
    {
        return 'financial-planning.factors';
    }

    public static function label(): string
    {
        return 'Financial Planning Factors (4 core pricing drivers)';
    }

    public static function view(): string
    {
        return 'sections.financial-planning-factors.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:80'],
            'heading' => ['required', 'string', 'max:140'],
            'intro' => ['required', 'string', 'max:500'],

            'factors' => ['required', 'array', 'size:4'],
            'factors.*.id' => ['required', 'string', 'max:40'],
            'factors.*.index' => ['required', 'string', 'max:20'],
            'factors.*.kicker' => ['required', 'string', 'max:40'],
            'factors.*.title' => ['required', 'string', 'max:80'],
            'factors.*.subtitle' => ['required', 'string', 'max:120'],
            'factors.*.explanation' => ['required', 'string', 'max:500'],
            'factors.*.what_we_review_together' => ['required', 'array', 'min:2', 'max:5'],
            'factors.*.what_we_review_together.*' => ['required', 'string', 'max:160'],
            'factors.*.questions_for_your_visit' => ['required', 'string', 'max:200'],
            'factors.*.related_route_href' => ['required', 'string', 'max:100'],
            'factors.*.related_route_label' => ['required', 'string', 'max:60'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::render($valid['intro']),
            'factors' => array_map(function (array $f): array {
                return [
                    'id' => $f['id'],
                    'index' => InlineText::plain($f['index']),
                    'kicker' => InlineText::plain($f['kicker']),
                    'title' => InlineText::plain($f['title']),
                    'subtitle' => InlineText::plain($f['subtitle']),
                    'explanation' => InlineText::render($f['explanation']),
                    'what_we_review_together' => array_map(fn ($item) => InlineText::plain($item), $f['what_we_review_together']),
                    'questions_for_your_visit' => InlineText::plain($f['questions_for_your_visit']),
                    'related_route_href' => $f['related_route_href'],
                    'related_route_label' => InlineText::plain($f['related_route_label']),
                ];
            }, $valid['factors']),
        ];
    }
}
