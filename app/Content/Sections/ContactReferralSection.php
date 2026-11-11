<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Contact Section 05: Referral Interest Pathways (#referral-interest).
 *
 * Grounded in React reference app/contact/page.tsx.
 * Supports Family & Friend Introductions and Senior Care Professional Coordination
 * with explicit client-confirmation notices.
 */
final class ContactReferralSection implements SectionSchema
{
    public static function type(): string
    {
        return 'contact.referral';
    }

    public static function label(): string
    {
        return 'Contact Referral (Family, friend and professional partner introductions)';
    }

    public static function view(): string
    {
        return 'sections.contact-referral.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'script_title' => ['required', 'string', 'max:80'],
            'heading' => ['required', 'string', 'max:160'],

            'pathways' => ['required', 'array', 'size:2'],
            'pathways.*.id' => ['required', 'in:family-friend-referral,professional-care-referral'],
            'pathways.*.badge' => ['required', 'string', 'max:100'],
            'pathways.*.verification_status' => ['required', 'string', 'max:60'],
            'pathways.*.title' => ['required', 'string', 'max:120'],
            'pathways.*.subtitle' => ['required', 'string', 'max:160'],
            'pathways.*.description' => ['required', 'string', 'max:600'],
            'pathways.*.highlights' => ['required', 'array', 'min:2'],
            'pathways.*.highlights.*' => ['required', 'string', 'max:250'],
            'pathways.*.verification_disclosure' => ['required', 'string', 'max:400'],
            'pathways.*.preset_inquiry_note' => ['required', 'string', 'max:300'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'script_title' => InlineText::plain($valid['script_title']),
            'heading' => InlineText::render($valid['heading']),
            'pathways' => $valid['pathways'],
        ];
    }
}
