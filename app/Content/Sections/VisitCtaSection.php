<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Support\InquiryIntents;
use Illuminate\Support\Facades\Validator;

/**
 * Homepage section 07: "Come See Mission Villa for Yourself".
 *
 * Deep-plum closing band (approved mockup, bottom band, corrected 2026-11-10).
 * Left: script eyebrow, heading, short invitation, up to three vertical
 * conversion actions and the verified address/phone. Right: an inline cream
 * inquiry card (the shared form, components/inquiry/form) for visitors who
 * reach the section naturally.
 *
 * Each action carries an inquiry intent and opens the shared inquiry MODAL
 * with it preselected (website-wide rule: form CTAs never scroll to a form,
 * not even to the card beside them). Contact details are not section copy:
 * they come from the verified site facts in config/missionvilla.php.
 */
final class VisitCtaSection implements SectionSchema
{
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
            'actions.*.intent' => ['required', 'in:'.implode(',', InquiryIntents::accepted()), 'distinct'],
            'actions.*.label' => ['required', 'string', 'max:24'],
            'actions.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'show_contact' => ['required', 'boolean'],
            // Inline inquiry card. Fields and inquiry types come from config/missionvilla.php → inquiries.
            'form' => ['nullable', 'array'],
            'form.enabled' => ['required_with:form', 'boolean'],
            'form.heading' => ['required_with:form', 'string', 'max:60'],
            'form.lede' => ['required_with:form', 'string', 'max:180'],
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
                'intent' => InquiryIntents::resolve($a['intent']),
                'label' => InlineText::plain($a['label']),
                'icon' => $a['icon'],
                'primary' => $i === 0,
            ], array_values($valid['actions']), array_keys(array_values($valid['actions']))),
            'show_contact' => (bool) $valid['show_contact'],
            'form' => ! empty($valid['form']['enabled']) ? [
                'heading' => InlineText::plain($valid['form']['heading']),
                'lede' => InlineText::plain($valid['form']['lede']),
            ] : null,
        ];
    }
}
