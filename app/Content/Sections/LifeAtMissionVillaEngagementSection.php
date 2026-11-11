<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Support\InquiryIntents;
use Illuminate\Support\Facades\Validator;

/**
 * Life at Mission Villa Section 04: Activities & Community Engagement.
 *
 * Warm cream section with 4 structured feature cards detailing
 * entertainment, creative workshops, scenic drives, and garden time.
 */
final class LifeAtMissionVillaEngagementSection implements SectionSchema
{
    public const ICONS = ['music', 'palette', 'bus', 'sprout', 'sparkles', 'heart', 'calendar'];

    public static function type(): string
    {
        return 'life-at-mission-villa.engagement';
    }

    public static function label(): string
    {
        return 'Life at Mission Villa Engagement (4 activity cards)';
    }

    public static function view(): string
    {
        return 'sections.life-at-mission-villa-engagement.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:100'],
            'intro' => ['required', 'string', 'max:350'],

            'activities' => ['required', 'array', 'size:4'],
            'activities.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'activities.*.kicker' => ['required', 'string', 'max:40'],
            'activities.*.title' => ['required', 'string', 'max:70'],
            'activities.*.desc' => ['required', 'string', 'max:300'],
            'activities.*.bullets' => ['required', 'array', 'min:2', 'max:4'],
            'activities.*.bullets.*' => ['required', 'string', 'max:120'],

            'action' => ['required', 'array'],
            'action.label' => ['required', 'string', 'max:50'],
            'action.intent' => ['required', 'in:'.implode(',', InquiryIntents::accepted())],
            'action.note' => ['required', 'string', 'max:180'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'activities' => array_map(fn (array $a) => [
                'icon' => $a['icon'],
                'kicker' => InlineText::plain($a['kicker']),
                'title' => InlineText::plain($a['title']),
                'desc' => InlineText::plain($a['desc']),
                'bullets' => array_map(fn ($b) => InlineText::plain($b), $a['bullets']),
            ], $valid['activities']),
            'action' => [
                'label' => InlineText::plain($valid['action']['label']),
                'intent' => InquiryIntents::resolve($valid['action']['intent']),
                'note' => InlineText::plain($valid['action']['note']),
            ],
        ];
    }
}
