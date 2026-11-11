<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * For Families Section 02: Family Decision Guide & Comparison Ledger.
 *
 * Interactive 4-pathway reflection explorer + side-by-side comparison ledger across
 * 5 core dimensions comparing Legacies™ Memory Care vs Short-Term Respite Care.
 */
final class ForFamiliesDecisionGuideSection implements SectionSchema
{
    public static function type(): string
    {
        return 'for-families.decision-guide';
    }

    public static function label(): string
    {
        return 'For Families Decision Guide (4 pathways + 5-dimension comparison ledger)';
    }

    public static function view(): string
    {
        return 'sections.for-families-decision-guide.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:140'],
            'intro' => ['required', 'string', 'max:400'],

            'pathways' => ['required', 'array', 'size:4'],
            'pathways.*.id' => ['required', 'string', 'max:40'],
            'pathways.*.index' => ['required', 'string', 'max:20'],
            'pathways.*.kicker' => ['required', 'string', 'max:60'],
            'pathways.*.title' => ['required', 'string', 'max:100'],
            'pathways.*.family_situation' => ['required', 'string', 'max:300'],
            'pathways.*.primary_option' => ['required', 'string', 'max:60'],
            'pathways.*.recommended_route_href' => ['required', 'string', 'max:100'],
            'pathways.*.recommended_route_label' => ['required', 'string', 'max:60'],
            'pathways.*.how_to_think_about_it' => ['required', 'string', 'max:400'],
            'pathways.*.key_signs_of_fit' => ['required', 'array', 'min:3', 'max:6'],
            'pathways.*.key_signs_of_fit.*' => ['required', 'string', 'max:200'],
            'pathways.*.how_both_programs_connect' => ['required', 'string', 'max:300'],
            'pathways.*.suggested_first_question' => ['required', 'string', 'max:250'],
            'pathways.*.preset_care_option' => ['required', 'in:Memory Care,Respite Care'],

            'comparison_dimensions' => ['required', 'array', 'size:5'],
            'comparison_dimensions.*.id' => ['required', 'string', 'max:40'],
            'comparison_dimensions.*.dimension' => ['required', 'string', 'max:60'],
            'comparison_dimensions.*.memory_care_approach' => ['required', 'string', 'max:300'],
            'comparison_dimensions.*.respite_care_approach' => ['required', 'string', 'max:300'],
            'comparison_dimensions.*.family_takeaway' => ['required', 'string', 'max:200'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::render($valid['intro']),
            'pathways' => array_map(function (array $p): array {
                return [
                    'id' => $p['id'],
                    'index' => InlineText::plain($p['index']),
                    'kicker' => InlineText::plain($p['kicker']),
                    'title' => InlineText::plain($p['title']),
                    'family_situation' => InlineText::plain($p['family_situation']),
                    'primary_option' => InlineText::plain($p['primary_option']),
                    'recommended_route_href' => $p['recommended_route_href'],
                    'recommended_route_label' => InlineText::plain($p['recommended_route_label']),
                    'how_to_think_about_it' => InlineText::plain($p['how_to_think_about_it']),
                    'key_signs_of_fit' => array_map(fn ($sign) => InlineText::plain($sign), $p['key_signs_of_fit']),
                    'how_both_programs_connect' => InlineText::plain($p['how_both_programs_connect']),
                    'suggested_first_question' => InlineText::plain($p['suggested_first_question']),
                    'preset_care_option' => $p['preset_care_option'],
                ];
            }, $valid['pathways']),
            'comparison_dimensions' => array_map(function (array $d): array {
                return [
                    'id' => $d['id'],
                    'dimension' => InlineText::plain($d['dimension']),
                    'memory_care_approach' => InlineText::plain($d['memory_care_approach']),
                    'respite_care_approach' => InlineText::plain($d['respite_care_approach']),
                    'family_takeaway' => InlineText::plain($d['family_takeaway']),
                ];
            }, $valid['comparison_dimensions']),
        ];
    }
}
