<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Support\InternalLink;
use App\Support\InquiryIntents;
use Illuminate\Support\Facades\Validator;

/**
 * Homepage section 06: "Questions Families Often Ask".
 *
 * Left: eyebrow, heading, one intro line. Right: an accordion of featured
 * questions, one open at a time.
 *
 * Entries are structured content: each has a stable id, question, plain-text
 * answer, icon, display order, `enabled` and `featured` flags. The entry list
 * may grow (up to MAX_ENTRIES) as the CMS gains more questions. The homepage
 * shows only enabled + featured entries, sorted by `order`, capped at
 * DISPLAY_COUNT. The composition is designed for exactly four.
 *
 * The optional "all questions" link renders only when its page is routed,
 * so the section never links to a page that does not exist yet.
 */
final class FaqFeaturedSection implements SectionSchema
{
    public const DISPLAY_COUNT = 4;

    public const MAX_ENTRIES = 40;

    public const ICONS = ['sprout', 'calendar', 'home', 'phone', 'heart', 'people', 'pin', 'file-text', 'shield'];

    public static function type(): string
    {
        return 'faq.featured';
    }

    public static function label(): string
    {
        return 'Featured FAQs (heading + four-question accordion)';
    }

    public static function view(): string
    {
        return 'sections.faq-featured.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:40'],
            'heading' => ['required', 'string', 'max:60'],
            'intro' => ['required', 'string', 'max:160'],
            'display_count' => ['nullable', 'integer', 'min:1', 'max:'.self::MAX_ENTRIES],

            'all_link' => ['nullable', 'array'],
            'all_link.label' => ['required_with:all_link', 'string', 'max:28'],
            'all_link.href' => ['required_with:all_link', 'string', 'max:255', 'regex:#^/(?!/)#'],

            'entries' => ['required', 'array', 'min:1', 'max:'.self::MAX_ENTRIES],
            'entries.*.id' => ['required', 'string', 'regex:/^[a-z][a-z0-9-]{1,40}$/', 'distinct'],
            'entries.*.question' => ['required', 'string', 'max:90'],
            // Plain text, two or three sentences.
            'entries.*.answer' => ['required', 'string', 'max:420'],
            'entries.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'entries.*.order' => ['required', 'integer', 'min:0', 'max:999'],
            'entries.*.enabled' => ['required', 'boolean'],
            'entries.*.featured' => ['required', 'boolean'],
            // Optional conversion links under an answer ("Request Pricing", "Schedule a Visit", …).
            // They open the shared inquiry modal with this intent; they never scroll to a form.
            'entries.*.actions' => ['nullable', 'array', 'max:2'],
            'entries.*.actions.*.label' => ['required', 'string', 'max:28'],
            'entries.*.actions.*.intent' => ['required', 'in:'.implode(',', InquiryIntents::accepted())],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        $displayCount = $valid['display_count'] ?? self::DISPLAY_COUNT;

        $featured = collect($valid['entries'])
            ->filter(fn (array $e) => $e['enabled'] && $e['featured'])
            ->sortBy('order')
            ->take($displayCount)
            ->map(fn (array $e) => [
                'id' => $e['id'],
                'question' => InlineText::plain($e['question']),
                'answer' => InlineText::plain($e['answer']),
                'icon' => $e['icon'],
                'actions' => array_map(fn (array $a) => [
                    'label' => InlineText::plain($a['label']),
                    'intent' => InquiryIntents::resolve($a['intent']),
                ], array_values($e['actions'] ?? [])),
            ])
            ->values()
            ->all();

        if ($featured === []) {
            throw new InvalidSectionData(self::type(), ['entries' => ['At least one enabled, featured question is required.']]);
        }

        $link = $valid['all_link'] ?? null;

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::plain($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'items' => $featured,
            'all_link' => $link && InternalLink::isAvailable($link['href'])
                ? ['label' => InlineText::plain($link['label']), 'href' => $link['href']]
                : null,
        ];
    }
}
