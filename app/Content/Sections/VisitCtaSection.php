<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Homepage section 07: "Come See Mission Villa for Yourself".
 *
 * Deep-plum closing band: script eyebrow, heading, short invitation, up to
 * three conversion actions and the verified address/phone.
 *
 * Each action carries an inquiry intent. They all open ONE shared inquiry
 * form (resources/views/components/inquiry/dialog.blade.php) with that intent
 * preselected. Schedule a Visit prefers the existing hero visit dialog when the
 * page has one (window.MissionVilla.openVisit). Contact details are not
 * section copy: they come from the verified site facts in config/missionvilla.php.
 */
final class VisitCtaSection implements SectionSchema
{
    public const INTENTS = ['schedule_visit', 'request_pricing', 'request_callback'];

    public const ICONS = ['calendar', 'file-text', 'phone'];

    public static function type(): string
    {
        return 'visit.cta';
    }

    public static function label(): string
    {
        return 'Final call to action (visit, pricing, callback + contact)';
    }

    public static function view(): string
    {
        return 'sections.visit-cta.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'script' => ['required', 'string', 'max:32'],
            'heading' => ['required', 'string', 'max:60'],
            'body' => ['required', 'string', 'max:220'],
            'actions' => ['required', 'array', 'min:1', 'max:3'],
            'actions.*.intent' => ['required', 'in:'.implode(',', self::INTENTS), 'distinct'],
            'actions.*.label' => ['required', 'string', 'max:24'],
            'actions.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'show_contact' => ['required', 'boolean'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'script' => InlineText::plain($valid['script']),
            'heading' => InlineText::plain($valid['heading']),
            'body' => InlineText::plain($valid['body']),
            // The first action is the primary (terracotta) button; the rest are outlined.
            'actions' => array_map(fn (array $a, int $i) => [
                'intent' => $a['intent'],
                'label' => InlineText::plain($a['label']),
                'icon' => $a['icon'],
                'primary' => $i === 0,
            ], array_values($valid['actions']), array_keys(array_values($valid['actions']))),
            'show_contact' => (bool) $valid['show_contact'],
        ];
    }
}
