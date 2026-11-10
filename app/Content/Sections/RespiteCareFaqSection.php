<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Support\InquiryIntents;
use Illuminate\Support\Facades\Validator;

/**
 * Respite Care Section 07: Questions Families Often Ask.
 *
 * 2-column layout featuring an informational Planning Guide card on the left
 * and a 5-question accessible accordion card on the right.
 */
final class RespiteCareFaqSection implements SectionSchema
{
    public const ICONS = ['calendar', 'file-text', 'phone', 'help-circle', 'arrow'];

    public static function type(): string
    {
        return 'respite-care.faq';
    }

    public static function label(): string
    {
        return 'Respite Care FAQ (planning guide card and accordion)';
    }

    public static function view(): string
    {
        return 'sections.respite-care-faq.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:100'],
            'intro' => ['required', 'string', 'max:350'],

            'guide' => ['required', 'array'],
            'guide.title' => ['required', 'string', 'max:60'],
            'guide.kicker' => ['required', 'string', 'max:40'],
            'guide.checklist' => ['required', 'array', 'min:2', 'max:4'],
            'guide.checklist.*' => ['required', 'string', 'max:100'],
            'guide.action' => ['required', 'array'],
            'guide.action.label' => ['required', 'string', 'max:40'],
            'guide.action.intent' => ['required', 'in:'.implode(',', InquiryIntents::accepted())],
            'guide.action.care' => ['nullable', 'string', 'in:memory_care,respite_care,exploring'],

            'faqs' => ['required', 'array', 'min:3', 'max:8'],
            'faqs.*.id' => ['required', 'string', 'max:40', 'distinct'],
            'faqs.*.question' => ['required', 'string', 'max:120'],
            'faqs.*.answer' => ['required', 'string', 'max:600'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'guide' => [
                'title' => InlineText::plain($valid['guide']['title']),
                'kicker' => InlineText::plain($valid['guide']['kicker']),
                'checklist' => array_map(fn (string $c) => InlineText::plain($c), $valid['guide']['checklist']),
                'action' => [
                    'label' => InlineText::plain($valid['guide']['action']['label']),
                    'intent' => InquiryIntents::resolve($valid['guide']['action']['intent']),
                    'care' => $valid['guide']['action']['care'] ?? 'respite_care',
                ],
            ],
            'faqs' => array_map(fn (array $f) => [
                'id' => $f['id'],
                'question' => InlineText::plain($f['question']),
                'answer' => InlineText::plain($f['answer']),
            ], $valid['faqs']),
        ];
    }
}
