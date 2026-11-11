<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Services & Amenities Section 05: Care Programs Bridge.
 *
 * Warm oat canvas (#FCFBF8) connecting the community offerings directly
 * to Mission Villa's two core programs: Memory Care and Respite Care.
 */
final class ServicesAmenitiesCareBridgeSection implements SectionSchema
{
    public static function type(): string
    {
        return 'services-and-amenities.care-bridge';
    }

    public static function label(): string
    {
        return 'Services & Amenities Care Bridge (2 program cards: Memory Care & Respite)';
    }

    public static function view(): string
    {
        return 'sections.services-and-amenities-care-bridge.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:100', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:120'],
            'intro' => ['required', 'string', 'max:350'],

            'programs' => ['required', 'array', 'size:2'],
            'programs.*.tag' => ['required', 'string', 'max:50'],
            'programs.*.page_badge' => ['required', 'string', 'max:20'],
            'programs.*.title' => ['required', 'string', 'max:70'],
            'programs.*.summary' => ['required', 'string', 'max:300'],
            'programs.*.highlights' => ['required', 'array', 'min:2', 'max:4'],
            'programs.*.highlights.*' => ['required', 'string', 'max:120'],
            'programs.*.link_href' => $path,
            'programs.*.link_label' => ['required', 'string', 'max:50'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'programs' => array_map(function (array $prog): array {
                return [
                    'tag' => InlineText::plain($prog['tag']),
                    'page_badge' => InlineText::plain($prog['page_badge']),
                    'title' => InlineText::plain($prog['title']),
                    'summary' => InlineText::plain($prog['summary']),
                    'highlights' => array_map(fn ($h) => InlineText::plain($h), $prog['highlights']),
                    'link_href' => $prog['link_href'],
                    'link_label' => InlineText::plain($prog['link_label']),
                ];
            }, $valid['programs']),
        ];
    }
}
