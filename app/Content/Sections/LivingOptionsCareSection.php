<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Support\InquiryIntents;
use Illuminate\Support\Facades\Validator;

/**
 * Living Options Section 02: Choose the Care That Fits Your Needs.
 *
 * Interactive two-option selector (Memory Care vs Respite Care) with
 * dedicated photographs, who it supports, key distinction, and links,
 * plus a compact at-a-glance comparison table below.
 */
final class LivingOptionsCareSection implements SectionSchema
{
    public const RIGHTS = ['cleared', 'unconfirmed'];

    public static function type(): string
    {
        return 'living-options.care';
    }

    public static function label(): string
    {
        return 'Living Options Care Selector & Comparison (two-option switcher & table)';
    }

    public static function view(): string
    {
        return 'sections.living-options-care.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:100'],
            'intro' => ['required', 'string', 'max:350'],

            'options' => ['required', 'array', 'size:2'],
            'options.*.id' => ['required', 'string', 'in:memory-care,respite-care'],
            'options.*.tag' => ['required', 'string', 'max:80'],
            'options.*.number' => ['required', 'string', 'max:30'],
            'options.*.title' => ['required', 'string', 'max:60'],
            'options.*.headline' => ['required', 'string', 'max:100'],
            'options.*.lead' => ['required', 'string', 'max:350'],
            'options.*.key_distinction' => ['required', 'string', 'max:250'],
            'options.*.ideal_for' => ['required', 'array', 'min:2', 'max:5'],
            'options.*.ideal_for.*' => ['required', 'string', 'max:160'],
            'options.*.inclusions' => ['required', 'array', 'min:2', 'max:5'],
            'options.*.inclusions.*' => ['required', 'string', 'max:140'],
            'options.*.suite_summary' => ['required', 'string', 'max:160'],
            'options.*.route_href' => ['required', 'string', 'max:100'],
            'options.*.route_label' => ['required', 'string', 'max:50'],
            'options.*.inquiry_intent' => ['required', 'in:'.implode(',', InquiryIntents::accepted())],
            'options.*.inquiry_care' => ['required', 'string', 'in:memory_care,respite_care'],
            'options.*.inquiry_label' => ['required', 'string', 'max:50'],

            'options.*.image' => ['required', 'array'],
            'options.*.image.src' => $path,
            'options.*.image.width' => ['required', 'integer', 'min:300', 'max:3000'],
            'options.*.image.height' => ['required', 'integer', 'min:200', 'max:3000'],
            'options.*.image.alt' => ['required', 'string', 'max:200'],
            'options.*.image.caption' => ['required', 'string', 'max:200'],
            'options.*.image.provenance' => ['required', 'in:facility,illustrative'],
            'options.*.image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],
            'options.*.image.label' => ['required', 'string', 'max:60'],

            'comparison' => ['required', 'array'],
            'comparison.heading' => ['required', 'string', 'max:80'],
            'comparison.intro' => ['required', 'string', 'max:200'],
            'comparison.rows' => ['required', 'array', 'min:3', 'max:8'],
            'comparison.rows.*.dimension' => ['required', 'string', 'max:60'],
            'comparison.rows.*.memory_care' => ['required', 'string', 'max:250'],
            'comparison.rows.*.respite_care' => ['required', 'string', 'max:250'],
            'comparison.shared_foundation' => ['required', 'string', 'max:300'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'options' => array_map(fn (array $opt) => [
                'id' => $opt['id'],
                'tag' => InlineText::plain($opt['tag']),
                'number' => InlineText::plain($opt['number']),
                'title' => InlineText::plain($opt['title']),
                'headline' => InlineText::plain($opt['headline']),
                'lead' => InlineText::plain($opt['lead']),
                'key_distinction' => InlineText::plain($opt['key_distinction']),
                'ideal_for' => array_map(fn ($s) => InlineText::plain($s), $opt['ideal_for']),
                'inclusions' => array_map(fn ($s) => InlineText::plain($s), $opt['inclusions']),
                'suite_summary' => InlineText::plain($opt['suite_summary']),
                'route_href' => $opt['route_href'],
                'route_label' => InlineText::plain($opt['route_label']),
                'inquiry_intent' => InquiryIntents::resolve($opt['inquiry_intent']),
                'inquiry_care' => $opt['inquiry_care'],
                'inquiry_label' => InlineText::plain($opt['inquiry_label']),
                'image' => [
                    'src' => $opt['image']['src'],
                    'width' => (int) $opt['image']['width'],
                    'height' => (int) $opt['image']['height'],
                    'alt' => InlineText::plain($opt['image']['alt']),
                    'caption' => InlineText::plain($opt['image']['caption']),
                    'provenance' => $opt['image']['provenance'],
                    'rights' => $opt['image']['rights'],
                    'label' => InlineText::plain($opt['image']['label']),
                ],
            ], $valid['options']),
            'comparison' => [
                'heading' => InlineText::plain($valid['comparison']['heading']),
                'intro' => InlineText::plain($valid['comparison']['intro']),
                'rows' => array_map(fn (array $r) => [
                    'dimension' => InlineText::plain($r['dimension']),
                    'memory_care' => InlineText::plain($r['memory_care']),
                    'respite_care' => InlineText::plain($r['respite_care']),
                ], $valid['comparison']['rows']),
                'shared_foundation' => InlineText::plain($valid['comparison']['shared_foundation']),
            ],
        ];
    }
}
