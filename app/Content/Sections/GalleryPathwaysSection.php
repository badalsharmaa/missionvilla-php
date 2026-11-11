<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Gallery & Virtual Tour Section 04: Visual-to-Care Pathways Bridge.
 *
 * Warm paper canvas (#F7F4ED) connecting gallery proof to Suites, Services,
 * and Memory Care / Respite Care programs.
 */
final class GalleryPathwaysSection implements SectionSchema
{
    public static function type(): string
    {
        return 'gallery.pathways';
    }

    public static function label(): string
    {
        return 'Gallery Pathways Bridge (3 cards linking to Suites, Services, Programs)';
    }

    public static function view(): string
    {
        return 'sections.gallery-pathways.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:100', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:120'],
            'intro' => ['required', 'string', 'max:400'],

            'cards' => ['required', 'array', 'size:3'],
            'cards.*.step' => ['required', 'string', 'max:10'],
            'cards.*.kicker' => ['required', 'string', 'max:50'],
            'cards.*.title' => ['required', 'string', 'max:70'],
            'cards.*.summary' => ['required', 'string', 'max:300'],
            'cards.*.link_label' => ['required', 'string', 'max:50'],
            'cards.*.link_href' => $path,
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'cards' => array_map(function (array $card): array {
                return [
                    'step' => $card['step'],
                    'kicker' => InlineText::plain($card['kicker']),
                    'title' => InlineText::plain($card['title']),
                    'summary' => InlineText::plain($card['summary']),
                    'link_label' => InlineText::plain($card['link_label']),
                    'link_href' => $card['link_href'],
                ];
            }, $valid['cards']),
        ];
    }
}
