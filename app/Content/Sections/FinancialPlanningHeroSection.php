<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Support\InquiryIntents;
use Illuminate\Support\Facades\Validator;

/**
 * Financial Planning Section 01: Compassionate Hero & Cost Clarity Monograph.
 *
 * Sets clear expectations that care assessment determines personalized rates,
 * avoiding deceptive fixed-price calculators while presenting an archival ledger framework.
 */
final class FinancialPlanningHeroSection implements SectionSchema
{
    public const ICONS = ['calendar', 'calculator', 'list', 'help', 'arrow-down'];

    public static function type(): string
    {
        return 'financial-planning.hero';
    }

    public static function label(): string
    {
        return 'Financial Planning Hero (Cost clarity monograph with trust ledger)';
    }

    public static function view(): string
    {
        return 'sections.financial-planning-hero.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:80'],
            'license' => ['required', 'string', 'max:50'],
            'tagline' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:140'],
            'lead' => ['required', 'string', 'max:1000'],

            'pillars' => ['required', 'array', 'size:3'],
            'pillars.*.code' => ['required', 'string', 'max:40'],
            'pillars.*.title' => ['required', 'string', 'max:60'],
            'pillars.*.summary' => ['required', 'string', 'max:120'],

            'actions' => ['required', 'array', 'min:2', 'max:4'],
            'actions.*.label' => ['required', 'string', 'max:40'],
            'actions.*.style' => ['required', 'in:primary,secondary,jump'],
            'actions.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'actions.*.intent' => ['nullable', 'in:'.implode(',', InquiryIntents::accepted())],
            'actions.*.care' => ['nullable', 'string', 'max:30'],
            'actions.*.target' => ['nullable', 'string', 'max:50'],

            'folio' => ['required', 'array'],
            'folio.eyebrow' => ['required', 'string', 'max:80'],
            'folio.title' => ['required', 'string', 'max:80'],
            'folio.quote' => ['required', 'string', 'max:200'],
            'folio.caption' => ['required', 'string', 'max:60'],
            'folio.image' => ['required', 'array'],
            'folio.image.src' => $path,
            'folio.image.width' => ['required', 'integer', 'min:1'],
            'folio.image.height' => ['required', 'integer', 'min:1'],
            'folio.image.alt' => ['required', 'string', 'max:160'],
            'folio.image.provenance' => ['required', 'in:facility,historical,illustrative'],
            'folio.image.rights' => ['required', 'string', 'max:40'],
            'folio.items' => ['required', 'array', 'size:4'],
            'folio.items.*.code' => ['required', 'string', 'max:10'],
            'folio.items.*.title' => ['required', 'string', 'max:80'],
            'folio.items.*.meta' => ['required', 'string', 'max:80'],
            'folio.items.*.target' => ['required', 'string', 'max:50'],

            'transparency_note' => ['required', 'string', 'max:300'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'license' => InlineText::plain($valid['license']),
            'tagline' => InlineText::plain($valid['tagline']),
            'heading' => InlineText::render($valid['heading']),
            'lead' => InlineText::render($valid['lead']),
            'pillars' => array_map(fn (array $p) => [
                'code' => InlineText::plain($p['code']),
                'title' => InlineText::plain($p['title']),
                'summary' => InlineText::plain($p['summary']),
            ], $valid['pillars']),
            'actions' => array_map(fn (array $a) => [
                'label' => InlineText::plain($a['label']),
                'style' => $a['style'],
                'icon' => $a['icon'],
                'intent' => $a['intent'] ?? null,
                'care' => $a['care'] ?? null,
                'target' => $a['target'] ?? null,
            ], $valid['actions']),
            'folio' => [
                'eyebrow' => InlineText::plain($valid['folio']['eyebrow']),
                'title' => InlineText::plain($valid['folio']['title']),
                'quote' => InlineText::plain($valid['folio']['quote']),
                'caption' => InlineText::plain($valid['folio']['caption']),
                'image' => [
                    'src' => $valid['folio']['image']['src'],
                    'width' => $valid['folio']['image']['width'],
                    'height' => $valid['folio']['image']['height'],
                    'alt' => InlineText::plain($valid['folio']['image']['alt']),
                    'provenance' => $valid['folio']['image']['provenance'],
                    'rights' => $valid['folio']['image']['rights'],
                ],
                'items' => array_map(fn (array $it) => [
                    'code' => InlineText::plain($it['code']),
                    'title' => InlineText::plain($it['title']),
                    'meta' => InlineText::plain($it['meta']),
                    'target' => $it['target'],
                ], $valid['folio']['items']),
            ],
            'transparency_note' => InlineText::plain($valid['transparency_note']),
        ];
    }
}
