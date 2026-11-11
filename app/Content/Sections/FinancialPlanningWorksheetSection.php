<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Financial Planning Section 04: Visual Signature — Blank Paper-Ledger Worksheet.
 *
 * Side-by-side comparison between household expenses at home and consolidated
 * monthly living at Mission Villa. Contains ZERO pre-filled fake numbers.
 * Supports interactive client-side totaling, reset, and printable output.
 */
final class FinancialPlanningWorksheetSection implements SectionSchema
{
    public static function type(): string
    {
        return 'financial-planning.worksheet';
    }

    public static function label(): string
    {
        return 'Financial Planning Worksheet (8-row interactive blank paper ledger)';
    }

    public static function view(): string
    {
        return 'sections.financial-planning-worksheet.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:80'],
            'heading' => ['required', 'string', 'max:140'],
            'intro' => ['required', 'string', 'max:500'],
            'instructions' => ['required', 'string', 'max:400'],

            'rows' => ['required', 'array', 'size:8'],
            'rows.*.id' => ['required', 'string', 'max:40'],
            'rows.*.line_number' => ['required', 'string', 'max:10'],
            'rows.*.category_group' => ['required', 'string', 'max:40'],
            'rows.*.expense_label' => ['required', 'string', 'max:80'],
            'rows.*.home_living_prompt' => ['required', 'string', 'max:200'],
            'rows.*.mission_villa_consolidated_context' => ['required', 'string', 'max:300'],
            'rows.*.question_to_verify_on_tour' => ['required', 'string', 'max:200'],

            'print_disclaimer' => ['required', 'string', 'max:300'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::render($valid['intro']),
            'instructions' => InlineText::render($valid['instructions']),
            'rows' => array_map(function (array $r): array {
                return [
                    'id' => $r['id'],
                    'line_number' => InlineText::plain($r['line_number']),
                    'category_group' => InlineText::plain($r['category_group']),
                    'expense_label' => InlineText::plain($r['expense_label']),
                    'home_living_prompt' => InlineText::plain($r['home_living_prompt']),
                    'mission_villa_consolidated_context' => InlineText::plain($r['mission_villa_consolidated_context']),
                    'question_to_verify_on_tour' => InlineText::plain($r['question_to_verify_on_tour']),
                ];
            }, $valid['rows']),
            'print_disclaimer' => InlineText::plain($valid['print_disclaimer']),
        ];
    }
}
