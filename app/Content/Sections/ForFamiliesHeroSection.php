<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Support\InquiryIntents;
use Illuminate\Support\Facades\Validator;

/**
 * For Families Section 01: Empathetic Hero & Family Companion Folio.
 *
 * Warm paper canvas (#F7F4ED) featuring 12-column asymmetric layout, 3-pillar guide strip,
 * unvarnished property photography, and quick jump folio index.
 */
final class ForFamiliesHeroSection implements SectionSchema
{
    public const RIGHTS = ['cleared', 'unconfirmed'];
    public const ICONS = ['calendar', 'compass', 'help', 'phone'];

    public static function type(): string
    {
        return 'for-families.hero';
    }

    public static function label(): string
    {
        return 'For Families Empathetic Hero (asymmetric 12-col with companion folio)';
    }

    public static function view(): string
    {
        return 'sections.for-families-hero.index';
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
            'folio.image.width' => ['required', 'integer', 'min:300', 'max:3000'],
            'folio.image.height' => ['required', 'integer', 'min:200', 'max:3000'],
            'folio.image.alt' => ['required', 'string', 'max:200'],
            'folio.image.provenance' => ['required', 'in:facility,illustrative'],
            'folio.image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],

            'folio.items' => ['required', 'array', 'size:4'],
            'folio.items.*.code' => ['required', 'string', 'max:10'],
            'folio.items.*.title' => ['required', 'string', 'max:80'],
            'folio.items.*.meta' => ['required', 'string', 'max:80'],
            'folio.items.*.target' => ['required', 'string', 'max:50'],

            'transparency_note' => ['required', 'string', 'max:250'],
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
                'care' => $a['care'] ?? 'memory_care',
                'target' => $a['target'] ?? null,
            ], $valid['actions']),
            'folio' => [
                'eyebrow' => InlineText::plain($valid['folio']['eyebrow']),
                'title' => InlineText::plain($valid['folio']['title']),
                'quote' => InlineText::plain($valid['folio']['quote']),
                'caption' => InlineText::plain($valid['folio']['caption']),
                'image' => $valid['folio']['image'],
                'items' => array_map(fn (array $item) => [
                    'code' => InlineText::plain($item['code']),
                    'title' => InlineText::plain($item['title']),
                    'meta' => InlineText::plain($item['meta']),
                    'target' => $item['target'],
                ], $valid['folio']['items']),
            ],
            'transparency_note' => InlineText::plain($valid['transparency_note']),
        ];
    }
}
