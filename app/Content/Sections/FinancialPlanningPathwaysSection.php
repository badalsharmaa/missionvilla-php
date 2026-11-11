<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Financial Planning Section 05: Pathways, Benefits & Questions to Ask.
 *
 * Covers LTCI, VA Aid & Attendance, family financial coordination,
 * and transparent disclosure regarding historical referral/state assistance claims.
 */
final class FinancialPlanningPathwaysSection implements SectionSchema
{
    public const VERIFICATION_STATUSES = [
        'Standard Planning Guidance',
        'CLIENT CONFIRMATION REQUIRED',
    ];

    public static function type(): string
    {
        return 'financial-planning.pathways';
    }

    public static function label(): string
    {
        return 'Financial Planning Pathways (4 planning resources & benefit reviews)';
    }

    public static function view(): string
    {
        return 'sections.financial-planning-pathways.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:80'],
            'heading' => ['required', 'string', 'max:140'],
            'intro' => ['required', 'string', 'max:500'],

            'pathways' => ['required', 'array', 'size:4'],
            'pathways.*.id' => ['required', 'string', 'max:50'],
            'pathways.*.index' => ['required', 'string', 'max:20'],
            'pathways.*.badge' => ['required', 'string', 'max:60'],
            'pathways.*.title' => ['required', 'string', 'max:80'],
            'pathways.*.subtitle' => ['required', 'string', 'max:120'],
            'pathways.*.description' => ['required', 'string', 'max:500'],
            'pathways.*.questions_to_ask' => ['required', 'array', 'min:2', 'max:5'],
            'pathways.*.questions_to_ask.*' => ['required', 'string', 'max:200'],
            'pathways.*.verification_status' => ['required', 'in:'.implode(',', self::VERIFICATION_STATUSES)],
            'pathways.*.disclaimer_note' => ['required', 'string', 'max:300'],
            'pathways.*.inquiry_preset_note' => ['required', 'string', 'max:200'],
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
                    'badge' => InlineText::plain($p['badge']),
                    'title' => InlineText::plain($p['title']),
                    'subtitle' => InlineText::plain($p['subtitle']),
                    'description' => InlineText::plain($p['description']),
                    'questions_to_ask' => array_map(fn ($q) => InlineText::plain($q), $p['questions_to_ask']),
                    'verification_status' => $p['verification_status'],
                    'disclaimer_note' => InlineText::plain($p['disclaimer_note']),
                    'inquiry_preset_note' => InlineText::plain($p['inquiry_preset_note']),
                ];
            }, $valid['pathways']),
        ];
    }
}
