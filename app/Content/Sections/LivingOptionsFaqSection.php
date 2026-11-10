<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Support\InquiryIntents;
use Illuminate\Support\Facades\Validator;

/**
 * Living Options Section 05: Frequently Asked Questions.
 *
 * Balanced 2-column composition:
 * - Left column: Eyebrow, Heading, Intro, and a helpful Care Team contact card.
 * - Right column: Accessible 5-question FAQ accordion with Schema.org JSON-LD.
 */
final class LivingOptionsFaqSection implements SectionSchema
{
    public static function type(): string
    {
        return 'living-options.faq';
    }

    public static function label(): string
    {
        return 'Living Options FAQ (balanced 2-column accordion)';
    }

    public static function view(): string
    {
        return 'sections.living-options-faq.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:100'],
            'intro' => ['required', 'string', 'max:350'],

            'help_card' => ['required', 'array'],
            'help_card.title' => ['required', 'string', 'max:80'],
            'help_card.text' => ['required', 'string', 'max:220'],
            'help_card.phone_label' => ['required', 'string', 'max:50'],
            'help_card.cta_label' => ['required', 'string', 'max:50'],
            'help_card.cta_intent' => ['required', 'in:'.implode(',', InquiryIntents::accepted())],

            'faqs' => ['required', 'array', 'min:3', 'max:10'],
            'faqs.*.id' => ['required', 'string', 'max:60'],
            'faqs.*.question' => ['required', 'string', 'max:160'],
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
            'help_card' => [
                'title' => InlineText::plain($valid['help_card']['title']),
                'text' => InlineText::plain($valid['help_card']['text']),
                'phone_label' => InlineText::plain($valid['help_card']['phone_label']),
                'cta_label' => InlineText::plain($valid['help_card']['cta_label']),
                'cta_intent' => InquiryIntents::resolve($valid['help_card']['cta_intent']),
            ],
            'faqs' => array_map(fn (array $f) => [
                'id' => $f['id'],
                'question' => InlineText::plain($f['question']),
                'answer' => InlineText::plain($f['answer']),
            ], $valid['faqs']),
        ];
    }
}
