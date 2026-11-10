<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Respite Care Section 03: Comfort, Care & Everyday Support.
 *
 * Editorial asymmetrical layout presenting 6 verified stay inclusions
 * combining photography and concise service cards.
 */
final class RespiteCareInclusionsSection implements SectionSchema
{
    public const RIGHTS = ['cleared', 'unconfirmed'];

    public const ICONS = ['utensils', 'bed', 'heart-handshake', 'people', 'sparkles', 'file-text'];

    public static function type(): string
    {
        return 'respite-care.inclusions';
    }

    public static function label(): string
    {
        return 'Respite Care Inclusions (editorial cards & photography)';
    }

    public static function view(): string
    {
        return 'sections.respite-care-inclusions.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:100'],
            'intro' => ['required', 'string', 'max:350'],
            'note' => ['required', 'string', 'max:150'],

            'items' => ['required', 'array', 'size:6'],
            'items.*.id' => ['required', 'string', 'max:40', 'distinct'],
            'items.*.title' => ['required', 'string', 'max:50'],
            'items.*.description' => ['required', 'string', 'max:200'],
            'items.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'items.*.theme' => ['required', 'in:cream,plum,media_lead,media_card'],

            // Optional image for media_lead and media_card items
            'items.*.image' => ['nullable', 'array'],
            'items.*.image.src' => ['required_with:items.*.image', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'],
            'items.*.image.width' => ['required_with:items.*.image', 'integer', 'min:320', 'max:3000'],
            'items.*.image.height' => ['required_with:items.*.image', 'integer', 'min:200', 'max:3000'],
            'items.*.image.alt' => ['required_with:items.*.image', 'string', 'max:200'],
            'items.*.image.provenance' => ['required_with:items.*.image', 'in:facility,illustrative'],
            'items.*.image.rights' => ['required_with:items.*.image', 'in:'.implode(',', self::RIGHTS)],
            'items.*.image.label' => ['required_with:items.*.image', 'string', 'max:60'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'note' => InlineText::plain($valid['note']),
            'items' => array_map(fn (array $item) => [
                'id' => $item['id'],
                'title' => InlineText::plain($item['title']),
                'description' => InlineText::plain($item['description']),
                'icon' => $item['icon'],
                'theme' => $item['theme'],
                'image' => isset($item['image']) ? [
                    'src' => $item['image']['src'],
                    'width' => (int) $item['image']['width'],
                    'height' => (int) $item['image']['height'],
                    'alt' => InlineText::plain($item['image']['alt']),
                    'provenance' => $item['image']['provenance'],
                    'rights' => $item['image']['rights'],
                    'label' => InlineText::plain($item['image']['label']),
                ] : null,
            ], $valid['items']),
        ];
    }
}
