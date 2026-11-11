<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Contact Section 06: Contact, Visit & Accessibility Directions FAQs (#contact-faqs).
 *
 * Grounded in React reference app/contact/page.tsx.
 * Provides searchable and filterable FAQ accordion and contextual planning bridges
 * to For Families, Financial Planning, Suites & Gallery.
 */
final class ContactFaqSection implements SectionSchema
{
    public static function type(): string
    {
        return 'contact.faq';
    }

    public static function label(): string
    {
        return 'Contact FAQs (Searchable questions, accessibility notes & planning bridges)';
    }

    public static function view(): string
    {
        return 'sections.contact-faq.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'script_title' => ['required', 'string', 'max:80'],
            'heading' => ['required', 'string', 'max:160'],
            'search_placeholder' => ['required', 'string', 'max:120'],

            'categories' => ['required', 'array', 'min:3'],
            'categories.*' => ['required', 'string', 'max:50'],

            'faqs' => ['required', 'array', 'size:6'],
            'faqs.*.id' => ['required', 'string', 'max:50'],
            'faqs.*.code' => ['required', 'string', 'max:20'],
            'faqs.*.category' => ['required', 'string', 'max:50'],
            'faqs.*.question' => ['required', 'string', 'max:200'],
            'faqs.*.answer' => ['required', 'string', 'max:1000'],
            'faqs.*.confirmation_note' => ['nullable', 'string', 'max:300'],

            'bridges' => ['required', 'array', 'size:3'],
            'bridges.*.eyebrow' => ['required', 'string', 'max:60'],
            'bridges.*.title' => ['required', 'string', 'max:100'],
            'bridges.*.description' => ['required', 'string', 'max:300'],
            'bridges.*.icon' => ['required', 'string', 'max:30'],
            'bridges.*.links' => ['required', 'array', 'min:1', 'max:2'],
            'bridges.*.links.*.label' => ['required', 'string', 'max:50'],
            'bridges.*.links.*.href' => ['required', 'string', 'max:100'],
            'bridges.*.links.*.style' => ['required', 'in:primary,outline'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'script_title' => InlineText::plain($valid['script_title']),
            'heading' => InlineText::render($valid['heading']),
            'search_placeholder' => InlineText::plain($valid['search_placeholder']),
            'categories' => $valid['categories'],
            'faqs' => $valid['faqs'],
            'bridges' => $valid['bridges'],
        ];
    }
}
