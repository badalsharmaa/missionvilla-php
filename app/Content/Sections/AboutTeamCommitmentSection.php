<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * About Section 05: Care Team Stewardship (No Fake Bios) & Pet-Friendly Policy Disclosure.
 *
 * Grounded in truthful care stewardship without fabricated portraits, paired with
 * a conditional pet policy disclosure note and direct conversation bridge.
 */
final class AboutTeamCommitmentSection implements SectionSchema
{
    public static function type(): string
    {
        return 'about.team-commitment';
    }

    public static function label(): string
    {
        return 'About Care Team Stewardship & Pet Policy (role explorer with conditional note)';
    }

    public static function view(): string
    {
        return 'sections.about-team-commitment.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:60'],
            'badge' => ['required', 'string', 'max:60'],
            'heading' => ['required', 'string', 'max:120'],
            'intro' => ['required', 'string', 'max:500'],

            'roles' => ['required', 'array', 'min:3', 'max:5'],
            'roles.*.id' => ['required', 'string', 'max:40'],
            'roles.*.role_title' => ['required', 'string', 'max:60'],
            'roles.*.department_tag' => ['required', 'string', 'max:60'],
            'roles.*.how_they_support' => ['required', 'string', 'max:350'],
            'roles.*.tour_question' => ['required', 'string', 'max:200'],

            'pet_policy' => ['required', 'array'],
            'pet_policy.badge' => ['required', 'string', 'max:60'],
            'pet_policy.headline' => ['required', 'string', 'max:80'],
            'pet_policy.summary' => ['required', 'string', 'max:350'],
            'pet_policy.confirmation_items' => ['required', 'array', 'min:2', 'max:5'],
            'pet_policy.confirmation_items.*' => ['required', 'string', 'max:180'],
            'pet_policy.verification_status' => ['required', 'string', 'max:60'],
            'pet_policy.inquiry_note' => ['required', 'string', 'max:250'],

            'direct_call' => ['required', 'array'],
            'direct_call.badge' => ['required', 'string', 'max:40'],
            'direct_call.title' => ['required', 'string', 'max:80'],
            'direct_call.description' => ['required', 'string', 'max:300'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'badge' => InlineText::plain($valid['badge']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::plain($valid['intro']),
            'roles' => array_map(function (array $r): array {
                return [
                    'id' => $r['id'],
                    'role_title' => InlineText::plain($r['role_title']),
                    'department_tag' => InlineText::plain($r['department_tag']),
                    'how_they_support' => InlineText::plain($r['how_they_support']),
                    'tour_question' => InlineText::plain($r['tour_question']),
                ];
            }, $valid['roles']),
            'pet_policy' => [
                'badge' => InlineText::plain($valid['pet_policy']['badge']),
                'headline' => InlineText::plain($valid['pet_policy']['headline']),
                'summary' => InlineText::plain($valid['pet_policy']['summary']),
                'confirmation_items' => array_map(fn ($it) => InlineText::plain($it), $valid['pet_policy']['confirmation_items']),
                'verification_status' => InlineText::plain($valid['pet_policy']['verification_status']),
                'inquiry_note' => InlineText::plain($valid['pet_policy']['inquiry_note']),
            ],
            'direct_call' => [
                'badge' => InlineText::plain($valid['direct_call']['badge']),
                'title' => InlineText::plain($valid['direct_call']['title']),
                'description' => InlineText::render($valid['direct_call']['description']),
            ],
        ];
    }
}
