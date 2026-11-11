<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Support\InquiryIntents;
use Illuminate\Support\Facades\Validator;

/**
 * Suites & Floor Plans Section 03: Authentic Floor Plan & Tour Inspection.
 *
 * Warm cream section spotlighting the authentic Companion Unit architectural
 * diagram, key spatial features, and an honest disclosure about personalized
 * room inspections on tour.
 */
final class SuitesFloorPlansDiagramSection implements SectionSchema
{
    public const RIGHTS = ['cleared', 'unconfirmed'];

    public static function type(): string
    {
        return 'suites-floor-plans.diagram';
    }

    public static function label(): string
    {
        return 'Suites & Floor Plans Authentic Diagram (floor plan image and inspection notes)';
    }

    public static function view(): string
    {
        return 'sections.suites-floor-plans-diagram.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:100'],
            'intro' => ['required', 'string', 'max:350'],

            'diagram' => ['required', 'array'],
            'diagram.badge' => ['required', 'string', 'max:60'],
            'diagram.title' => ['required', 'string', 'max:80'],
            'diagram.subtitle' => ['required', 'string', 'max:120'],
            'diagram.description' => ['required', 'string', 'max:350'],
            'diagram.image' => ['required', 'array'],
            'diagram.image.src' => $path,
            'diagram.image.width' => ['required', 'integer', 'min:300', 'max:3000'],
            'diagram.image.height' => ['required', 'integer', 'min:200', 'max:3000'],
            'diagram.image.alt' => ['required', 'string', 'max:200'],
            'diagram.image.provenance' => ['required', 'in:facility,illustrative'],
            'diagram.image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],
            'diagram.image.label' => ['required', 'string', 'max:60'],

            'highlights' => ['required', 'array', 'min:3', 'max:5'],
            'highlights.*.title' => ['required', 'string', 'max:60'],
            'highlights.*.desc' => ['required', 'string', 'max:160'],

            'disclosure' => ['required', 'array'],
            'disclosure.badge' => ['required', 'string', 'max:50'],
            'disclosure.text' => ['required', 'string', 'max:300'],

            'action' => ['required', 'array'],
            'action.label' => ['required', 'string', 'max:50'],
            'action.intent' => ['required', 'in:'.implode(',', InquiryIntents::accepted())],
            'action.care' => ['nullable', 'string', 'in:memory_care,respite_care,exploring'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'diagram' => [
                'badge' => InlineText::plain($valid['diagram']['badge']),
                'title' => InlineText::plain($valid['diagram']['title']),
                'subtitle' => InlineText::plain($valid['diagram']['subtitle']),
                'description' => InlineText::plain($valid['diagram']['description']),
                'image' => [
                    'src' => $valid['diagram']['image']['src'],
                    'width' => (int) $valid['diagram']['image']['width'],
                    'height' => (int) $valid['diagram']['image']['height'],
                    'alt' => InlineText::plain($valid['diagram']['image']['alt']),
                    'provenance' => $valid['diagram']['image']['provenance'],
                    'rights' => $valid['diagram']['image']['rights'],
                    'label' => InlineText::plain($valid['diagram']['image']['label']),
                ],
            ],
            'highlights' => array_map(fn (array $h) => [
                'title' => InlineText::plain($h['title']),
                'desc' => InlineText::plain($h['desc']),
            ], $valid['highlights']),
            'disclosure' => [
                'badge' => InlineText::plain($valid['disclosure']['badge']),
                'text' => InlineText::plain($valid['disclosure']['text']),
            ],
            'action' => [
                'label' => InlineText::plain($valid['action']['label']),
                'intent' => InquiryIntents::resolve($valid['action']['intent']),
                'care' => $valid['action']['care'] ?? 'exploring',
            ],
        ];
    }
}
