<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Support\InquiryIntents;
use Illuminate\Support\Facades\Validator;

/**
 * Memory Care Section 02: The Legacies™ Difference.
 *
 * 4-chapter interactive selector with active content panel and supporting
 * editorial photography. Inactive panels are inert; no layout shifts.
 * Accessible ARIA tablist/tabpanel with roving tabindex.
 */
final class MemoryCareLegaciesSection implements SectionSchema
{
    public const CHAPTER_COUNT = 4;

    public const RIGHTS = ['cleared', 'unconfirmed'];

    public const ICONS = ['book-open', 'compass', 'heart', 'people', 'sprout', 'calendar', 'armchair', 'home'];

    public static function type(): string
    {
        return 'memory-care.legacies';
    }

    public static function label(): string
    {
        return 'The Legacies™ Difference (4-chapter interactive selector and active panel)';
    }

    public static function view(): string
    {
        return 'sections.memory-care-legacies.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:80'],
            'intro' => ['required', 'string', 'max:300'],

            'touchpoints' => ['required', 'array', 'size:'.self::CHAPTER_COUNT],
            'touchpoints.*.id' => ['required', 'string', 'regex:/^[a-z][a-z0-9-]{1,30}$/', 'distinct'],
            'touchpoints.*.chapter' => ['required', 'string', 'max:20'],
            'touchpoints.*.tab_label' => ['required', 'string', 'max:30'],
            'touchpoints.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'touchpoints.*.title' => ['required', 'string', 'max:80'],
            'touchpoints.*.subtitle' => ['required', 'string', 'max:120'],
            'touchpoints.*.description' => ['required', 'string', 'max:350'],
            'touchpoints.*.in_practice' => ['required', 'array', 'size:3'],
            'touchpoints.*.in_practice.*' => ['required', 'string', 'max:160'],
            'touchpoints.*.takeaway' => ['required', 'string', 'max:180'],

            'touchpoints.*.image.src' => $path,
            'touchpoints.*.image.src_mobile' => ['nullable', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'],
            'touchpoints.*.image.width' => ['required', 'integer', 'min:320', 'max:4000'],
            'touchpoints.*.image.height' => ['required', 'integer', 'min:200', 'max:4000'],
            'touchpoints.*.image.alt' => ['required', 'string', 'max:200'],
            'touchpoints.*.image.provenance' => ['required', 'in:facility,illustrative'],
            'touchpoints.*.image.source_url' => ['nullable', 'url', 'max:255'],
            'touchpoints.*.image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],
            'touchpoints.*.image.label' => ['required', 'string', 'max:60'],
            'touchpoints.*.image.caption' => ['required', 'string', 'max:100'],

            'touchpoints.*.cta_label' => ['required', 'string', 'max:35'],
            'touchpoints.*.cta_intent' => ['required', 'in:'.implode(',', InquiryIntents::accepted())],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'touchpoints' => array_map(fn (array $tp) => [
                'id' => $tp['id'],
                'chapter' => InlineText::plain($tp['chapter']),
                'tab_label' => InlineText::plain($tp['tab_label']),
                'icon' => $tp['icon'],
                'title' => InlineText::plain($tp['title']),
                'subtitle' => InlineText::plain($tp['subtitle']),
                'description' => InlineText::plain($tp['description']),
                'in_practice' => array_map(fn (string $p) => InlineText::plain($p), $tp['in_practice']),
                'takeaway' => InlineText::plain($tp['takeaway']),
                'image' => [
                    'src' => $tp['image']['src'],
                    'src_mobile' => $tp['image']['src_mobile'] ?? null,
                    'width' => (int) $tp['image']['width'],
                    'height' => (int) $tp['image']['height'],
                    'alt' => InlineText::plain($tp['image']['alt']),
                    'provenance' => $tp['image']['provenance'],
                    'source_url' => $tp['image']['source_url'] ?? null,
                    'rights' => $tp['image']['rights'],
                    'label' => InlineText::plain($tp['image']['label']),
                    'caption' => InlineText::plain($tp['image']['caption']),
                ],
                'cta_label' => InlineText::plain($tp['cta_label']),
                'cta_intent' => InquiryIntents::resolve($tp['cta_intent']),
            ], $valid['touchpoints']),
        ];
    }
}
