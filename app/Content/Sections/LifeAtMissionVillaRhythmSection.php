<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Life at Mission Villa Section 03: Daily Rhythm & Flow.
 *
 * Warm cream section illustrating the unhurried morning, midday, afternoon,
 * and evening rhythms of daily life at Mission Villa.
 */
final class LifeAtMissionVillaRhythmSection implements SectionSchema
{
    public const ICONS = ['sun', 'utensils', 'heart', 'moon', 'coffee', 'music', 'sparkles'];

    public static function type(): string
    {
        return 'life-at-mission-villa.rhythm';
    }

    public static function label(): string
    {
        return 'Life at Mission Villa Daily Rhythm (4 time-of-day moments)';
    }

    public static function view(): string
    {
        return 'sections.life-at-mission-villa-rhythm.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:100'],
            'intro' => ['required', 'string', 'max:350'],

            'moments' => ['required', 'array', 'size:4'],
            'moments.*.time' => ['required', 'string', 'max:40'],
            'moments.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'moments.*.title' => ['required', 'string', 'max:70'],
            'moments.*.lead' => ['required', 'string', 'max:90'],
            'moments.*.body' => ['required', 'string', 'max:300'],
            'moments.*.touchpoint' => ['required', 'string', 'max:120'],

            'disclaimer' => ['required', 'string', 'max:280'],
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
                'time' => InlineText::plain($m['time']),
                'icon' => $m['icon'],
                'title' => InlineText::plain($m['title']),
                'lead' => InlineText::plain($m['lead']),
                'body' => InlineText::plain($m['body']),
                'touchpoint' => InlineText::plain($m['touchpoint']),
            ], $valid['moments']),
            'disclaimer' => InlineText::plain($valid['disclaimer']),
        ];
    }
}
