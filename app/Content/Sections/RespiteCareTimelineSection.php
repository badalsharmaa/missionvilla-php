<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Respite Care Section 06: A Simple Stay-Planning Timeline.
 *
 * 5-step interactive planning sequence:
 * 1. Reach Out
 * 2. Care Review
 * 3. Choose Dates
 * 4. Prepare for Arrival
 * 5. Welcome to Mission Villa
 */
final class RespiteCareTimelineSection implements SectionSchema
{
    public const ICONS = ['phone', 'file-text', 'calendar', 'briefcase', 'heart', 'home', 'check'];

    public static function type(): string
    {
        return 'respite-care.timeline';
    }

    public static function label(): string
    {
        return 'Respite Care Timeline (5-step interactive planning sequence)';
    }

    public static function view(): string
    {
        return 'sections.respite-care-timeline.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:100'],
            'intro' => ['required', 'string', 'max:350'],
            'note' => ['required', 'string', 'max:160'],

            'steps' => ['required', 'array', 'size:5'],
            'steps.*.step' => ['required', 'string', 'max:10'],
            'steps.*.title' => ['required', 'string', 'max:50'],
            'steps.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'steps.*.summary' => ['required', 'string', 'max:180'],
            'steps.*.detail' => ['required', 'string', 'max:250'],
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
            'steps' => array_map(fn (array $s, int $i) => [
                'index' => $i + 1,
                'step' => InlineText::plain($s['step']),
                'title' => InlineText::plain($s['title']),
                'icon' => $s['icon'],
                'summary' => InlineText::plain($s['summary']),
                'detail' => InlineText::plain($s['detail']),
            ], $valid['steps'], array_keys($valid['steps'])),
        ];
    }
}
