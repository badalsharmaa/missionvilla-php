<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Contact Section 01: Direct Hospitality Desk, Verified Contact Trio & Arrival Monograph Hero.
 *
 * Grounded in the React reference app/contact/page.tsx.
 * Provides clear phone, email, and address cards, a botanical arch arrival visual plate,
 * and 4 quick-jump anchors for immediate navigation.
 */
final class ContactHeroSection implements SectionSchema
{
    public const ICONS = ['calendar', 'phone', 'compass', 'map-pin'];

    public static function type(): string
    {
        return 'contact.hero';
    }

    public static function label(): string
    {
        return 'Contact Hero (Direct Daly City hospitality desk, phone & guided arrival)';
    }

    public static function view(): string
    {
        return 'sections.contact-hero.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:100'],
            'license' => ['required', 'string', 'max:50'],
            'script_title' => ['required', 'string', 'max:100'],
            'heading' => ['required', 'string', 'max:200'],
            'lead' => ['required', 'string', 'max:1000'],

            'phone' => ['required', 'array'],
            'phone.raw' => ['required', 'string', 'max:30'],
            'phone.formatted' => ['required', 'string', 'max:30'],
            'phone.href' => ['required', 'string', 'max:40'],

            'email' => ['required', 'array'],
            'email.address' => ['required', 'string', 'max:80'],
            'email.href' => ['required', 'string', 'max:80'],

            'address' => ['required', 'array'],
            'address.street' => ['required', 'string', 'max:80'],
            'address.city' => ['required', 'string', 'max:40'],
            'address.state' => ['required', 'string', 'max:20'],
            'address.zip' => ['required', 'string', 'max:20'],
            'address.full' => ['required', 'string', 'max:120'],

            'arrival_plate' => ['required', 'array'],
            'arrival_plate.image' => ['required', 'string', 'max:120'],
            'arrival_plate.alt' => ['required', 'string', 'max:200'],
            'arrival_plate.badge' => ['required', 'string', 'max:60'],
            'arrival_plate.caption_tag' => ['required', 'string', 'max:60'],
            'arrival_plate.caption_text' => ['required', 'string', 'max:200'],

            'directory_card' => ['required', 'array'],
            'directory_card.badge' => ['required', 'string', 'max:60'],
            'directory_card.title' => ['required', 'string', 'max:100'],
            'directory_card.description' => ['required', 'string', 'max:400'],
            'directory_card.care_programs' => ['required', 'string', 'max:150'],
            'directory_card.suite_formats' => ['required', 'string', 'max:200'],
            'directory_card.licensing_info' => ['required', 'string', 'max:150'],
            'directory_card.maps_label' => ['required', 'string', 'max:100'],
            'directory_card.maps_url' => ['required', 'string', 'max:255'],

            'actions' => ['required', 'array', 'min:2', 'max:3'],
            'actions.*.label' => ['required', 'string', 'max:50'],
            'actions.*.style' => ['required', 'in:primary,secondary,phone,jump'],
            'actions.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'actions.*.target' => ['nullable', 'string', 'max:60'],
            'actions.*.href' => ['nullable', 'string', 'max:100'],

            'quick_sections' => ['required', 'array', 'size:4'],
            'quick_sections.*.id' => ['required', 'string', 'max:40'],
            'quick_sections.*.index' => ['required', 'string', 'max:10'],
            'quick_sections.*.title' => ['required', 'string', 'max:60'],
            'quick_sections.*.subtitle' => ['required', 'string', 'max:80'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'license' => InlineText::plain($valid['license']),
            'script_title' => InlineText::plain($valid['script_title']),
            'heading' => InlineText::render($valid['heading']),
            'lead' => InlineText::render($valid['lead']),
            'phone' => $valid['phone'],
            'email' => $valid['email'],
            'address' => $valid['address'],
            'arrival_plate' => $valid['arrival_plate'],
            'directory_card' => $valid['directory_card'],
            'actions' => $valid['actions'],
            'quick_sections' => $valid['quick_sections'],
        ];
    }
}
