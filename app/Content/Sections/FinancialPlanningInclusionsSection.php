<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Financial Planning Section 03: Grouped Inclusions Ledger.
 *
 * 10 categorized community living inclusions with interactive filter tabs,
 * clear provenance tagging, and explicit client-confirmation disclosures.
 */
final class FinancialPlanningInclusionsSection implements SectionSchema
{
    public const CONFIRMATION_STATUSES = [
        'Standard Community Offering',
        'CLIENT CONFIRMATION REQUIRED',
    ];

    public static function type(): string
    {
        return 'financial-planning.inclusions';
    }

    public static function label(): string
    {
        return 'Financial Planning Inclusions (10-item categorized monthly living ledger)';
    }

    public static function view(): string
    {
        return 'sections.financial-planning-inclusions.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:80'],
            'heading' => ['required', 'string', 'max:140'],
            'intro' => ['required', 'string', 'max:500'],

            'categories' => ['required', 'array', 'min:4', 'max:8'],
            'categories.*' => ['required', 'string', 'max:40'],

            'items' => ['required', 'array', 'size:10'],
            'items.*.id' => ['required', 'string', 'max:40'],
            'items.*.code' => ['required', 'string', 'max:20'],
            'items.*.group' => ['required', 'string', 'max:40'],
            'items.*.title' => ['required', 'string', 'max:80'],
            'items.*.summary' => ['required', 'string', 'max:300'],
            'items.*.how_it_helps_families' => ['required', 'string', 'max:250'],
            'items.*.confirmation_status' => ['required', 'in:'.implode(',', self::CONFIRMATION_STATUSES)],
            'items.*.verification_note' => ['required', 'string', 'max:250'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::render($valid['intro']),
            'categories' => array_map(fn ($c) => InlineText::plain($c), $valid['categories']),
            'items' => array_map(function (array $it): array {
                return [
                    'id' => $it['id'],
                    'code' => InlineText::plain($it['code']),
                    'group' => InlineText::plain($it['group']),
                    'title' => InlineText::plain($it['title']),
                    'summary' => InlineText::plain($it['summary']),
                    'how_it_helps_families' => InlineText::plain($it['how_it_helps_families']),
                    'confirmation_status' => $it['confirmation_status'],
                    'verification_note' => InlineText::plain($it['verification_note']),
                ];
            }, $valid['items']),
        ];
    }
}
