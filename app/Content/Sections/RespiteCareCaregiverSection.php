<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Support\InquiryIntents;
use Illuminate\Support\Facades\Validator;

/**
 * Respite Care Section 05: Caring for the Caregiver.
 *
 * Deep plum band with wave top edge, emotional narrative for family caregivers,
 * conversion CTAs, and 3 verified reassurance concept rows.
 */
final class RespiteCareCaregiverSection implements SectionSchema
{
    public const ICONS = ['shield', 'heart', 'sprout', 'heart-handshake', 'people', 'home', 'calendar', 'arrow'];

    public static function type(): string
    {
        return 'respite-care.caregiver';
    }

    public static function label(): string
    {
        return 'Respite Care Caregiver Support (plum band with reassurance concepts and CTAs)';
    }

    public static function view(): string
    {
        return 'sections.respite-care-caregiver.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:80'],
            'subtitle' => ['required', 'string', 'max:80'],
            'narrative' => ['required', 'string', 'max:450'],

            'concepts' => ['required', 'array', 'size:3'],
            'concepts.*.title' => ['required', 'string', 'max:60'],
            'concepts.*.desc' => ['required', 'string', 'max:160'],
            'concepts.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],

            'actions' => ['required', 'array', 'min:1', 'max:2'],
            'actions.*.label' => ['required', 'string', 'max:40'],
            'actions.*.style' => ['required', 'in:primary,secondary'],
            'actions.*.icon' => ['nullable', 'in:'.implode(',', self::ICONS)],
            'actions.*.intent' => ['nullable', 'in:'.implode(',', InquiryIntents::accepted())],
            'actions.*.href' => ['nullable', 'string', 'max:255'],
            'actions.*.care' => ['nullable', 'string', 'in:memory_care,respite_care,exploring'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'subtitle' => InlineText::render($valid['subtitle']),
            'narrative' => InlineText::plain($valid['narrative']),
            'concepts' => array_map(fn (array $c) => [
                'title' => InlineText::plain($c['title']),
                'desc' => InlineText::plain($c['desc']),
                'icon' => $c['icon'],
            ], $valid['concepts']),
            'actions' => array_map(fn (array $a) => [
                'label' => InlineText::plain($a['label']),
                'style' => $a['style'],
                'icon' => $a['icon'] ?? null,
                'intent' => isset($a['intent']) ? InquiryIntents::resolve($a['intent']) : null,
                'href' => $a['href'] ?? null,
                'care' => $a['care'] ?? 'respite_care',
            ], $valid['actions']),
        ];
    }
}
