<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Respite Care Section 04: A Welcoming Stay, From Start to Finish.
 *
 * 3 editorial photo cards illustrating a typical stay rhythm:
 * 1. Arrival & Settling In
 * 2. Shared Meals & Gentle Activity
 * 3. Restful Evenings & Reassurance
 */
final class RespiteCareStorySection implements SectionSchema
{
    public const RIGHTS = ['cleared', 'unconfirmed'];

    public const ICONS = ['calendar', 'utensils', 'moon', 'home', 'people'];

    public static function type(): string
    {
        return 'respite-care.story';
    }

    public static function label(): string
    {
        return 'Respite Care Story (3-moment editorial cards with photography)';
    }

    public static function view(): string
    {
        return 'sections.respite-care-story.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:100'],
            'intro' => ['required', 'string', 'max:350'],

            'moments' => ['required', 'array', 'size:3'],
            'moments.*.id' => ['required', 'string', 'max:40', 'distinct'],
            'moments.*.title' => ['required', 'string', 'max:60'],
            'moments.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'moments.*.description' => ['required', 'string', 'max:200'],

            'moments.*.image' => ['required', 'array'],
            'moments.*.image.src' => $path,
            'moments.*.image.src_mobile' => ['nullable', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'],
            'moments.*.image.width' => ['required', 'integer', 'min:320', 'max:3000'],
            'moments.*.image.height' => ['required', 'integer', 'min:200', 'max:3000'],
            'moments.*.image.alt' => ['required', 'string', 'max:200'],
            'moments.*.image.provenance' => ['required', 'in:facility,illustrative'],
            'moments.*.image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],
            'moments.*.image.label' => ['required', 'string', 'max:60'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'moments' => array_map(fn (array $m) => [
                'id' => $m['id'],
                'title' => InlineText::plain($m['title']),
                'icon' => $m['icon'],
                'description' => InlineText::plain($m['description']),
                'image' => [
                    'src' => $m['image']['src'],
                    'src_mobile' => $m['image']['src_mobile'] ?? null,
                    'width' => (int) $m['image']['width'],
                    'height' => (int) $m['image']['height'],
                    'alt' => InlineText::plain($m['image']['alt']),
                    'provenance' => $m['image']['provenance'],
                    'rights' => $m['image']['rights'],
                    'label' => InlineText::plain($m['image']['label']),
                ],
            ], $valid['moments']),
        ];
    }
}
