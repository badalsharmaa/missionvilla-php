<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Contact Section 04: What Happens After Submitting — Once Backend Is Connected (#what-happens-next).
 *
 * Grounded in React reference app/contact/page.tsx.
 * Transparently explains the 4-step family experience once live backend is wired,
 * contrasted with current prototype behavior and immediate phone assistance.
 */
final class ContactWorkflowSection implements SectionSchema
{
    public static function type(): string
    {
        return 'contact.workflow';
    }

    public static function label(): string
    {
        return 'Contact Workflow (Post-submission experience & unhurried follow-through)';
    }

    public static function view(): string
    {
        return 'sections.contact-workflow.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'script_title' => ['required', 'string', 'max:80'],
            'heading' => ['required', 'string', 'max:160'],
            'intro' => ['required', 'string', 'max:600'],

            'steps' => ['required', 'array', 'size:4'],
            'steps.*.id' => ['required', 'string', 'max:50'],
            'steps.*.step_number' => ['required', 'string', 'max:20'],
            'steps.*.timing_badge' => ['required', 'string', 'max:60'],
            'steps.*.title' => ['required', 'string', 'max:120'],
            'steps.*.subtitle' => ['required', 'string', 'max:160'],
            'steps.*.what_happens_in_production' => ['required', 'string', 'max:500'],
            'steps.*.current_prototype_behavior' => ['required', 'string', 'max:500'],
            'steps.*.family_reassurance' => ['required', 'string', 'max:300'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'script_title' => InlineText::plain($valid['script_title']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::render($valid['intro']),
            'steps' => $valid['steps'],
        ];
    }
}
