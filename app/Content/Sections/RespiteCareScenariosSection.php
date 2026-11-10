<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Respite Care Section 02: When Families Choose Respite Care.
 *
 * 4-scenario interactive selector with editorial narrative, checkmarked points,
 * and photography. Grid-stacked panels eliminate layout shift.
 */
final class RespiteCareScenariosSection implements SectionSchema
{
    public const RIGHTS = ['cleared', 'unconfirmed'];

    public const ICONS = ['heart', 'briefcase', 'check-circle', 'people', 'home', 'calendar'];

    public static function type(): string
    {
        return 'respite-care.scenarios';
    }

    public static function label(): string
    {
        return 'Respite Care Scenarios (4-scenario interactive selector with panel & photography)';
    }

    public static function view(): string
    {
        return 'sections.respite-care-scenarios.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:100'],
            'intro' => ['required', 'string', 'max:350'],

            'scenarios' => ['required', 'array', 'size:4'],
            'scenarios.*.id' => ['required', 'string', 'max:40', 'distinct'],
            'scenarios.*.tab_label' => ['required', 'string', 'max:40'],
            'scenarios.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'scenarios.*.kicker' => ['required', 'string', 'max:30'],
            'scenarios.*.title' => ['required', 'string', 'max:60'],
            'scenarios.*.subtitle' => ['required', 'string', 'max:100'],
            'scenarios.*.narrative' => ['required', 'string', 'max:400'],
            'scenarios.*.points' => ['required', 'array', 'min:2', 'max:4'],
            'scenarios.*.points.*' => ['required', 'string', 'max:120'],

            'scenarios.*.image' => ['required', 'array'],
            'scenarios.*.image.src' => $path,
            'scenarios.*.image.src_mobile' => ['nullable', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'],
            'scenarios.*.image.width' => ['required', 'integer', 'min:320', 'max:3000'],
            'scenarios.*.image.height' => ['required', 'integer', 'min:200', 'max:3000'],
            'scenarios.*.image.alt' => ['required', 'string', 'max:200'],
            'scenarios.*.image.provenance' => ['required', 'in:facility,illustrative'],
            'scenarios.*.image.source_url' => ['nullable', 'url', 'max:255'],
            'scenarios.*.image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],
            'scenarios.*.image.label' => ['required', 'string', 'max:60'],
            'scenarios.*.image.caption' => ['required', 'string', 'max:120'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'scenarios' => array_map(fn (array $s) => [
                'id' => $s['id'],
                'tab_label' => InlineText::plain($s['tab_label']),
                'icon' => $s['icon'],
                'kicker' => InlineText::plain($s['kicker']),
                'title' => InlineText::plain($s['title']),
                'subtitle' => InlineText::plain($s['subtitle']),
                'narrative' => InlineText::plain($s['narrative']),
                'points' => array_map(fn (string $p) => InlineText::plain($p), $s['points']),
                'image' => [
                    'src' => $s['image']['src'],
                    'src_mobile' => $s['image']['src_mobile'] ?? null,
                    'width' => (int) $s['image']['width'],
                    'height' => (int) $s['image']['height'],
                    'alt' => InlineText::plain($s['image']['alt']),
                    'provenance' => $s['image']['provenance'],
                    'source_url' => $s['image']['source_url'] ?? null,
                    'rights' => $s['image']['rights'],
                    'label' => InlineText::plain($s['image']['label']),
                    'caption' => InlineText::plain($s['image']['caption']),
                ],
            ], $valid['scenarios']),
        ];
    }
}
