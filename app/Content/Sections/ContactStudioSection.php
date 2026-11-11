<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Contact Section 02: Split Editorial Contact Studio & Guided Inquiry / Request-Visit Form (#schedule-visit).
 *
 * Grounded in React reference app/contact/page.tsx.
 * Left: Verified primary contact card, 4 quick presets, and non-medical privacy guardrail notice.
 * Right: Guided inquiry interactive prototype form with local validation and explicit
 * "Demo only — no inquiry sent" confirmation summary.
 */
final class ContactStudioSection implements SectionSchema
{
    public static function type(): string
    {
        return 'contact.studio';
    }

    public static function label(): string
    {
        return 'Contact Studio (Split editorial directory & guided visit request form)';
    }

    public static function view(): string
    {
        return 'sections.contact-studio.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:80'],
            'heading' => ['required', 'string', 'max:160'],
            'intro' => ['required', 'string', 'max:600'],

            'primary_contact' => ['required', 'array'],
            'primary_contact.badge' => ['required', 'string', 'max:60'],
            'primary_contact.community_name' => ['required', 'string', 'max:80'],
            'primary_contact.license_label' => ['required', 'string', 'max:60'],
            'primary_contact.phone_label' => ['required', 'string', 'max:60'],
            'primary_contact.phone_raw' => ['required', 'string', 'max:30'],
            'primary_contact.phone_href' => ['required', 'string', 'max:40'],
            'primary_contact.phone_note' => ['required', 'string', 'max:300'],
            'primary_contact.email_label' => ['required', 'string', 'max:60'],
            'primary_contact.email_address' => ['required', 'string', 'max:80'],
            'primary_contact.email_href' => ['required', 'string', 'max:80'],
            'primary_contact.address_label' => ['required', 'string', 'max:60'],
            'primary_contact.address_full' => ['required', 'string', 'max:120'],
            'primary_contact.maps_url' => ['required', 'string', 'max:255'],

            'presets' => ['required', 'array', 'size:4'],
            'presets.*.label' => ['required', 'string', 'max:60'],
            'presets.*.inquiry_intent' => ['required', 'string', 'max:60'],
            'presets.*.care_interest' => ['required', 'string', 'max:60'],
            'presets.*.suite_preference' => ['required', 'string', 'max:60'],
            'presets.*.message' => ['required', 'string', 'max:300'],
            'presets.*.referral_note' => ['nullable', 'string', 'max:100'],

            'privacy_guardrail' => ['required', 'array'],
            'privacy_guardrail.title' => ['required', 'string', 'max:80'],
            'privacy_guardrail.text' => ['required', 'string', 'max:400'],

            'form_config' => ['required', 'array'],
            'form_config.badge' => ['required', 'string', 'max:60'],
            'form_config.title' => ['required', 'string', 'max:100'],
            'form_config.demo_pill' => ['required', 'string', 'max:60'],
            'form_config.intent_label' => ['required', 'string', 'max:80'],
            'form_config.intents' => ['required', 'array', 'min:2'],
            'form_config.name_label' => ['required', 'string', 'max:60'],
            'form_config.method_label' => ['required', 'string', 'max:60'],
            'form_config.methods' => ['required', 'array', 'min:2'],
            'form_config.phone_label' => ['required', 'string', 'max:60'],
            'form_config.email_label' => ['required', 'string', 'max:60'],
            'form_config.care_label' => ['required', 'string', 'max:60'],
            'form_config.care_options' => ['required', 'array', 'min:2'],
            'form_config.suite_label' => ['required', 'string', 'max:60'],
            'form_config.suite_options' => ['required', 'array', 'min:2'],
            'form_config.window_label' => ['required', 'string', 'max:60'],
            'form_config.windows' => ['required', 'array', 'min:2'],
            'form_config.timing_label' => ['required', 'string', 'max:80'],
            'form_config.timing_placeholder' => ['required', 'string', 'max:100'],
            'form_config.message_label' => ['required', 'string', 'max:80'],
            'form_config.message_disclaimer' => ['required', 'string', 'max:100'],
            'form_config.message_placeholder' => ['required', 'string', 'max:200'],
            'form_config.consent_text' => ['required', 'string', 'max:500'],
            'form_config.submit_label' => ['required', 'string', 'max:80'],
            'form_config.demo_explainer' => ['required', 'string', 'max:200'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::render($valid['intro']),
            'primary_contact' => $valid['primary_contact'],
            'presets' => $valid['presets'],
            'privacy_guardrail' => $valid['privacy_guardrail'],
            'form_config' => $valid['form_config'],
        ];
    }
}
