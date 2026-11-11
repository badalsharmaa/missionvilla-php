<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Support\InquiryIntents;
use Illuminate\Support\Facades\Validator;

/**
 * About Section 01: Community Monograph & Trust Stage Hero.
 *
 * Warm paper canvas (#F7F4ED) featuring 12-column asymmetric layout, verified licensing,
 * unboxed trust ledger, and arched portrait study.
 */
final class AboutHeroSection implements SectionSchema
{
    public const RIGHTS = ['cleared', 'unconfirmed'];
    public const ICONS = ['calendar', 'book', 'phone', 'compass', 'arrow'];

    public static function type(): string
    {
        return 'about.hero';
    }

    public static function label(): string
    {
        return 'About Monograph Hero (asymmetric 12-column with arched portrait study)';
    }

    public static function view(): string
    {
        return 'sections.about-hero.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:80'],
            'license' => ['required', 'string', 'max:50'],
            'tagline' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:140'],
            'lead' => ['required', 'string', 'max:500'],

            'trust_ledger' => ['required', 'array', 'size:3'],
            'trust_ledger.*.code' => ['required', 'string', 'max:40'],
            'trust_ledger.*.title' => ['required', 'string', 'max:50'],
            'trust_ledger.*.summary' => ['required', 'string', 'max:80'],

            'jump_links' => ['required', 'array', 'min:3', 'max:5'],
            'jump_links.*.id' => ['required', 'string', 'max:40'],
            'jump_links.*.label' => ['required', 'string', 'max:50'],

            'actions' => ['required', 'array', 'min:2', 'max:3'],
            'actions.*.label' => ['required', 'string', 'max:40'],
            'actions.*.style' => ['required', 'in:primary,secondary,phone'],
            'actions.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'actions.*.intent' => ['nullable', 'in:'.implode(',', InquiryIntents::accepted())],
            'actions.*.care' => ['nullable', 'string', 'max:30'],
            'actions.*.href' => ['nullable', 'string', 'max:100'],

            'portrait_card' => ['required', 'array'],
            'portrait_card.cutout_label' => ['required', 'string', 'max:40'],
            'portrait_card.kicker' => ['required', 'string', 'max:50'],
            'portrait_card.title' => ['required', 'string', 'max:80'],
            'portrait_card.text' => ['required', 'string', 'max:200'],
            'portrait_card.caption' => ['required', 'string', 'max:60'],
            'portrait_card.image' => ['required', 'array'],
            'portrait_card.image.src' => $path,
            'portrait_card.image.width' => ['required', 'integer', 'min:300', 'max:3000'],
            'portrait_card.image.height' => ['required', 'integer', 'min:200', 'max:3000'],
            'portrait_card.image.alt' => ['required', 'string', 'max:200'],
            'portrait_card.image.provenance' => ['required', 'in:facility,illustrative'],
            'portrait_card.image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],

            'geography_card' => ['required', 'array'],
            'geography_card.kicker' => ['required', 'string', 'max:30'],
            'geography_card.title' => ['required', 'string', 'max:60'],
            'geography_card.text' => ['required', 'string', 'max:160'],
            'geography_card.link_label' => ['required', 'string', 'max:40'],
            'geography_card.link_anchor' => ['required', 'string', 'max:40'],
            'geography_card.image' => ['required', 'array'],
            'geography_card.image.src' => $path,
            'geography_card.image.width' => ['required', 'integer', 'min:300', 'max:3000'],
            'geography_card.image.height' => ['required', 'integer', 'min:200', 'max:3000'],
            'geography_card.image.alt' => ['required', 'string', 'max:200'],
            'geography_card.image.provenance' => ['required', 'in:facility,illustrative'],
            'geography_card.image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],

            'family_quote_card' => ['required', 'array'],
            'family_quote_card.kicker' => ['required', 'string', 'max:40'],
            'family_quote_card.quote' => ['required', 'string', 'max:200'],
            'family_quote_card.service' => ['required', 'string', 'max:40'],
            'family_quote_card.location' => ['required', 'string', 'max:40'],

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
            'trust_ledger' => array_map(fn (array $item) => [
                'code' => InlineText::plain($item['code']),
                'title' => InlineText::plain($item['title']),
                'summary' => InlineText::plain($item['summary']),
            ], $valid['trust_ledger']),
            'jump_links' => array_map(fn (array $link) => [
                'id' => $link['id'],
                'label' => InlineText::plain($link['label']),
            ], $valid['jump_links']),
            'actions' => array_map(fn (array $action) => [
                'label' => InlineText::plain($action['label']),
                'style' => $action['style'],
                'icon' => $action['icon'],
                'intent' => $action['intent'] ?? null,
                'care' => $action['care'] ?? 'exploring',
                'href' => $action['href'] ?? null,
            ], $valid['actions']),
            'portrait_card' => [
                'cutout_label' => InlineText::plain($valid['portrait_card']['cutout_label']),
                'kicker' => InlineText::plain($valid['portrait_card']['kicker']),
                'title' => InlineText::plain($valid['portrait_card']['title']),
                'text' => InlineText::plain($valid['portrait_card']['text']),
                'caption' => InlineText::plain($valid['portrait_card']['caption']),
                'image' => $valid['portrait_card']['image'],
            ],
            'geography_card' => [
                'kicker' => InlineText::plain($valid['geography_card']['kicker']),
                'title' => InlineText::plain($valid['geography_card']['title']),
                'text' => InlineText::plain($valid['geography_card']['text']),
                'link_label' => InlineText::plain($valid['geography_card']['link_label']),
                'link_anchor' => $valid['geography_card']['link_anchor'],
                'image' => $valid['geography_card']['image'],
            ],
            'family_quote_card' => [
                'kicker' => InlineText::plain($valid['family_quote_card']['kicker']),
                'quote' => InlineText::plain($valid['family_quote_card']['quote']),
                'service' => InlineText::plain($valid['family_quote_card']['service']),
                'location' => InlineText::plain($valid['family_quote_card']['location']),
            ],
            'transparency_note' => InlineText::render($valid['transparency_note']),
        ];
    }
}
