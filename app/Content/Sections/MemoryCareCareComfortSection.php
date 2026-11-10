<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Support\InquiryIntents;
use Illuminate\Support\Facades\Validator;

/**
 * Memory Care Section 04: Care, Comfort & Home.
 *
 * Premium two-column editorial composition.
 * Left: concise verified support commitments, care planning reassurance box,
 * and conversion CTAs opening the shared inquiry modal.
 * Right: large authentic Mission Villa accommodation or community photograph.
 */
final class MemoryCareCareComfortSection implements SectionSchema
{
    public const RIGHTS = ['cleared', 'unconfirmed'];

    public const ICONS = ['calendar', 'home', 'phone', 'shield', 'check', 'arrow'];

    public static function type(): string
    {
        return 'memory-care.care-comfort';
    }

    public static function label(): string
    {
        return 'Care, Comfort & Home (two-column editorial with support details and photo)';
    }

    public static function view(): string
    {
        return 'sections.memory-care-care-comfort.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:80'],
            'intro' => ['required', 'string', 'max:300'],

            'checklist' => ['required', 'array', 'min:3', 'max:6'],
            'checklist.*' => ['required', 'string', 'max:130'],

            'reassurance_box' => ['nullable', 'array'],
            'reassurance_box.title' => ['required_with:reassurance_box', 'string', 'max:50'],
            'reassurance_box.text' => ['required_with:reassurance_box', 'string', 'max:220'],

            'image' => ['required', 'array'],
            'image.src' => $path,
            'image.src_mobile' => ['nullable', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'],
            'image.width' => ['required', 'integer', 'min:320', 'max:4000'],
            'image.height' => ['required', 'integer', 'min:200', 'max:4000'],
            'image.alt' => ['required', 'string', 'max:200'],
            'image.provenance' => ['required', 'in:facility,illustrative'],
            'image.source_url' => ['nullable', 'url', 'max:255'],
            'image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],
            'image.label' => ['required', 'string', 'max:60'],
            'image.caption' => ['required', 'string', 'max:100'],

            'actions' => ['required', 'array', 'min:1', 'max:2'],
            'actions.*.label' => ['required', 'string', 'max:36'],
            'actions.*.style' => ['required', 'in:primary,secondary'],
            'actions.*.icon' => ['nullable', 'in:'.implode(',', self::ICONS)],
            'actions.*.intent' => ['required', 'in:'.implode(',', InquiryIntents::accepted())],
            'actions.*.care' => ['nullable', 'string', 'in:memory_care,respite_care,exploring'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'checklist' => array_map(fn (string $item) => InlineText::plain($item), $valid['checklist']),
            'reassurance_box' => isset($valid['reassurance_box']) ? [
                'title' => InlineText::plain($valid['reassurance_box']['title']),
                'text' => InlineText::plain($valid['reassurance_box']['text']),
            ] : null,
            'image' => [
                'src' => $valid['image']['src'],
                'src_mobile' => $valid['image']['src_mobile'] ?? null,
                'width' => (int) $valid['image']['width'],
                'height' => (int) $valid['image']['height'],
                'alt' => InlineText::plain($valid['image']['alt']),
                'provenance' => $valid['image']['provenance'],
                'source_url' => $valid['image']['source_url'] ?? null,
                'rights' => $valid['image']['rights'],
                'label' => InlineText::plain($valid['image']['label']),
                'caption' => InlineText::plain($valid['image']['caption']),
            ],
            'actions' => array_map(fn (array $a) => [
                'label' => InlineText::plain($a['label']),
                'style' => $a['style'],
                'icon' => $a['icon'] ?? null,
                'intent' => InquiryIntents::resolve($a['intent']),
                'care' => $a['care'] ?? 'memory_care',
            ], $valid['actions']),
        ];
    }
}
