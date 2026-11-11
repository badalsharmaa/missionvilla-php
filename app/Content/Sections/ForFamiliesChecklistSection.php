<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * For Families Section 03: Questions to Bring to a Visit (Tour Notebook).
 *
 * Checkable, theme-filterable questions across Care, Suites, Dining, and Cost
 * that relatives can bring to an in-person tour or submit directly with their inquiry.
 */
final class ForFamiliesChecklistSection implements SectionSchema
{
    public static function type(): string
    {
        return 'for-families.checklist';
    }

    public static function label(): string
    {
        return 'For Families Tour Notebook Checklist (8 checkable questions across 4 themes)';
    }

    public static function view(): string
    {
        return 'sections.for-families-checklist.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:120'],
            'intro' => ['required', 'string', 'max:500'],

            'themes' => ['required', 'array', 'min:3', 'max:6'],
            'themes.*' => ['required', 'string', 'max:40'],

            'questions' => ['required', 'array', 'size:8'],
            'questions.*.id' => ['required', 'string', 'max:40'],
            'questions.*.code' => ['required', 'string', 'max:10'],
            'questions.*.theme' => ['required', 'string', 'max:40'],
            'questions.*.question' => ['required', 'string', 'max:200'],
            'questions.*.why_it_matters' => ['required', 'string', 'max:300'],
            'questions.*.what_to_listen_for' => ['required', 'string', 'max:300'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::render($valid['intro']),
            'themes' => array_map(fn ($t) => InlineText::plain($t), $valid['themes']),
            'questions' => array_map(function (array $q): array {
                return [
                    'id' => $q['id'],
                    'code' => InlineText::plain($q['code']),
                    'theme' => InlineText::plain($q['theme']),
                    'question' => InlineText::plain($q['question']),
                    'why_it_matters' => InlineText::plain($q['why_it_matters']),
                    'what_to_listen_for' => InlineText::plain($q['what_to_listen_for']),
                ];
            }, $valid['questions']),
        ];
    }
}
