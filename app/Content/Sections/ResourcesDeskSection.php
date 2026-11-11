<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Resources Section 02: Interactive Family Resource Desk & Guided Topic Explorer.
 *
 * Searchable, categorised catalogue of Mission Villa planning folios with
 * synchronized reader spotlight.
 */
final class ResourcesDeskSection implements SectionSchema
{
    public static function type(): string
    {
        return 'resources.desk';
    }

    public static function label(): string
    {
        return 'Resources Desk (6-folio interactive catalogue & spotlight)';
    }

    public static function view(): string
    {
        return 'sections.resources-desk.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:80'],
            'heading' => ['required', 'string', 'max:140'],
            'intro' => ['required', 'string', 'max:500'],

            'categories' => ['required', 'array', 'size:5'],
            'categories.*' => ['required', 'string', 'max:40'],

            'items' => ['required', 'array', 'size:6'],
            'items.*.id' => ['required', 'string', 'max:50'],
            'items.*.folioCode' => ['required', 'string', 'max:20'],
            'items.*.category' => ['required', 'string', 'max:40'],
            'items.*.statusBadge' => ['required', 'string', 'max:40'],
            'items.*.title' => ['required', 'string', 'max:100'],
            'items.*.subtitle' => ['required', 'string', 'max:140'],
            'items.*.summary' => ['required', 'string', 'max:600'],
            'items.*.keyTakeaways' => ['required', 'array', 'size:3'],
            'items.*.keyTakeaways.*' => ['required', 'string', 'max:200'],
            'items.*.primaryHref' => ['required', 'string', 'max:100'],
            'items.*.primaryCtaLabel' => ['required', 'string', 'max:50'],
            'items.*.secondaryHref' => ['nullable', 'string', 'max:100'],
            'items.*.secondaryCtaLabel' => ['nullable', 'string', 'max:50'],
            'items.*.verificationNote' => ['nullable', 'string', 'max:300'],
            'items.*.placeholderImage' => ['required', 'array'],
            'items.*.placeholderImage.src' => ['required', 'string', 'max:140'],
            'items.*.placeholderImage.alt' => ['required', 'string', 'max:160'],
            'items.*.placeholderImage.caption' => ['required', 'string', 'max:140'],
            'items.*.placeholderImage.status' => ['required', 'string', 'max:40'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::render($valid['intro']),
            'categories' => array_map(fn($c) => InlineText::plain($c), $valid['categories']),
            'items' => array_map(function (array $it) {
                return [
                    'id' => $it['id'],
                    'folioCode' => InlineText::plain($it['folioCode']),
                    'category' => InlineText::plain($it['category']),
                    'statusBadge' => InlineText::plain($it['statusBadge']),
                    'title' => InlineText::plain($it['title']),
                    'subtitle' => InlineText::plain($it['subtitle']),
                    'summary' => InlineText::plain($it['summary']),
                    'keyTakeaways' => array_map(fn($t) => InlineText::plain($t), $it['keyTakeaways']),
                    'primaryHref' => $it['primaryHref'],
                    'primaryCtaLabel' => InlineText::plain($it['primaryCtaLabel']),
                    'secondaryHref' => $it['secondaryHref'] ?? null,
                    'secondaryCtaLabel' => isset($it['secondaryCtaLabel']) ? InlineText::plain($it['secondaryCtaLabel']) : null,
                    'verificationNote' => isset($it['verificationNote']) ? InlineText::plain($it['verificationNote']) : null,
                    'placeholderImage' => [
                        'src' => $it['placeholderImage']['src'],
                        'alt' => InlineText::plain($it['placeholderImage']['alt']),
                        'caption' => InlineText::plain($it['placeholderImage']['caption']),
                        'status' => InlineText::plain($it['placeholderImage']['status']),
                    ],
                ];
            }, $valid['items']),
        ];
    }
}
