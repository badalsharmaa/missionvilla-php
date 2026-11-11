<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Support\InquiryIntents;
use Illuminate\Support\Facades\Validator;

/**
 * Resources Section 01: Archival Reading Room & Family Reference Library Hero.
 *
 * Gathers Mission Villa's planning guides, financial worksheet, brochure packet builder,
 * and transparent blog archive status into a calm, accessible reading desk.
 */
final class ResourcesHeroSection implements SectionSchema
{
    public const ICONS = ['calendar', 'book-open', 'phone', 'arrow-down'];

    public static function type(): string
    {
        return 'resources.hero';
    }

    public static function label(): string
    {
        return 'Resources Hero (Archival reading room & family reference library)';
    }

    public static function view(): string
    {
        return 'sections.resources-hero.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:80'],
            'license' => ['required', 'string', 'max:40'],
            'address' => ['required', 'string', 'max:100'],
            'heading' => ['required', 'string', 'max:160'],
            'lead' => ['required', 'string', 'max:800'],

            'accuracy_commitment' => ['required', 'array'],
            'accuracy_commitment.title' => ['required', 'string', 'max:60'],
            'accuracy_commitment.badge' => ['required', 'string', 'max:60'],
            'accuracy_commitment.text' => ['required', 'string', 'max:400'],

            'actions' => ['required', 'array', 'min:2', 'max:3'],
            'actions.*.label' => ['required', 'string', 'max:40'],
            'actions.*.style' => ['required', 'in:primary,secondary,phone,jump'],
            'actions.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'actions.*.intent' => ['nullable', 'in:'.implode(',', InquiryIntents::accepted())],
            'actions.*.care' => ['nullable', 'string', 'in:memory_care,respite_care,exploring'],
            'actions.*.target' => ['nullable', 'string', 'max:60'],

            'pillars' => ['required', 'array', 'size:4'],
            'pillars.*.id' => ['required', 'string', 'max:40'],
            'pillars.*.folioCode' => ['required', 'string', 'max:20'],
            'pillars.*.statusBadge' => ['required', 'string', 'max:40'],
            'pillars.*.title' => ['required', 'string', 'max:80'],
            'pillars.*.subtitle' => ['required', 'string', 'max:120'],
            'pillars.*.primaryHref' => ['required', 'string', 'max:100'],
            'pillars.*.primaryCtaLabel' => ['required', 'string', 'max:50'],

            'quick_links' => ['required', 'array', 'size:5'],
            'quick_links.*.index' => ['required', 'string', 'max:10'],
            'quick_links.*.label' => ['required', 'string', 'max:50'],
            'quick_links.*.target' => ['required', 'string', 'max:50'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'license' => InlineText::plain($valid['license']),
            'address' => InlineText::plain($valid['address']),
            'heading' => InlineText::render($valid['heading']),
            'lead' => trim($valid['lead']),
            'accuracy_commitment' => [
                'title' => InlineText::plain($valid['accuracy_commitment']['title']),
                'badge' => InlineText::plain($valid['accuracy_commitment']['badge']),
                'text' => InlineText::plain($valid['accuracy_commitment']['text']),
            ],
            'actions' => array_map(function (array $a) {
                return [
                    'label' => InlineText::plain($a['label']),
                    'style' => $a['style'],
                    'icon' => $a['icon'],
                    'intent' => isset($a['intent']) ? InquiryIntents::resolve($a['intent']) : null,
                    'care' => $a['care'] ?? 'exploring',
                    'target' => $a['target'] ?? null,
                ];
            }, $valid['actions']),
            'pillars' => array_map(function (array $p) {
                return [
                    'id' => $p['id'],
                    'folioCode' => InlineText::plain($p['folioCode']),
                    'statusBadge' => InlineText::plain($p['statusBadge']),
                    'title' => InlineText::plain($p['title']),
                    'subtitle' => InlineText::plain($p['subtitle']),
                    'primaryHref' => $p['primaryHref'],
                    'primaryCtaLabel' => InlineText::plain($p['primaryCtaLabel']),
                ];
            }, $valid['pillars']),
            'quick_links' => array_map(function (array $ql) {
                return [
                    'index' => InlineText::plain($ql['index']),
                    'label' => InlineText::plain($ql['label']),
                    'target' => $ql['target'],
                ];
            }, $valid['quick_links']),
        ];
    }
}
