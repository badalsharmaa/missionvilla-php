<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use App\Support\InquiryIntents;
use App\Support\InternalLink;
use Illuminate\Support\Facades\Validator;

/**
 * Homepage section 05: "Comfortable Suites & Welcoming Spaces".
 *
 * Left: eyebrow, heading, intro and three selectable options (ARIA tabs).
 * Right: one photograph frame whose image, short label and caption change
 * with the selected option (user-initiated only: no cycling, no scroll
 * triggers). Below: up to two actions (approved mockup, 2026-11-10).
 *
 * The layout is designed for exactly three options. Every image declares
 * provenance (facility | illustrative) and publication rights, plus how it
 * should sit in the frame (`fit: cover` for photographs, `contain` for
 * floor-plan artwork).
 *
 * An action is either a form action (`intent`: opens the shared inquiry
 * modal, never scrolls to a form) or a page link (`href`). A page link is
 * used only once its page is routed; until then it shows `fallback_label`
 * and opens the modal with `fallback_intent` instead of linking to a 404.
 */
final class SuitesSpacesSection implements SectionSchema
{
    public const OPTION_COUNT = 3;

    /** Icons the view knows how to draw (resources/views/partials/icon.blade.php). */
    public const ICONS = ['bed', 'people', 'armchair'];

    public const RIGHTS = ['cleared', 'unconfirmed'];

    public const MAX_ACTIONS = 2;

    public const ACTION_ICONS = ['calendar', 'file-text', 'phone'];

    public static function type(): string
    {
        return 'living.suites';
    }

    public static function label(): string
    {
        return 'Suites & living spaces (three selectable options, one photo frame)';
    }

    public static function view(): string
    {
        return 'sections.suites-spaces.index';
    }

    public function normalize(array $data): array
    {
        $path = ['required', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:40'],
            'heading' => ['required', 'string', 'max:70'],
            'intro' => ['required', 'string', 'max:200'],

            'options' => ['required', 'array', 'size:'.self::OPTION_COUNT],
            'options.*.id' => ['required', 'string', 'regex:/^[a-z][a-z0-9-]{1,30}$/', 'distinct'],
            'options.*.label' => ['required', 'string', 'max:24'],
            'options.*.icon' => ['required', 'in:'.implode(',', self::ICONS)],
            'options.*.kicker' => ['required', 'string', 'max:28'],
            'options.*.caption' => ['required', 'string', 'max:56'],

            'options.*.image.src' => $path,
            'options.*.image.src_mobile' => ['nullable', 'string', 'max:255', 'regex:#^/(?!/)#', 'not_regex:#\.\.#'],
            'options.*.image.width' => ['required', 'integer', 'min:320', 'max:4000'],
            'options.*.image.height' => ['required', 'integer', 'min:200', 'max:4000'],
            'options.*.image.alt' => ['required', 'string', 'max:200'],
            // Honesty guard: real facility imagery vs illustrative imagery.
            'options.*.image.provenance' => ['required', 'in:facility,illustrative'],
            'options.*.image.source_url' => ['nullable', 'url', 'max:255'],
            'options.*.image.rights' => ['required', 'in:'.implode(',', self::RIGHTS)],
            // Short visible label so visitors know what they are looking at (e.g. "Mission Villa photo").
            'options.*.image.label' => ['required', 'string', 'max:40'],
            'options.*.image.fit' => ['nullable', 'in:cover,contain'],
            'options.*.image.position' => ['nullable', 'regex:/^\d{1,3}% \d{1,3}%$/'],


            'actions' => ['present', 'array', 'max:'.self::MAX_ACTIONS],
            'actions.*.label' => ['required', 'string', 'max:34'],
            'actions.*.style' => ['required', 'in:primary,secondary'],
            'actions.*.icon' => ['nullable', 'in:'.implode(',', self::ACTION_ICONS)],
            'actions.*.intent' => ['required_without:actions.*.href', 'nullable', 'in:'.implode(',', InquiryIntents::accepted())],
            'actions.*.href' => ['required_without:actions.*.intent', 'nullable', 'string', 'max:255', 'regex:~^(/(?!/)|https://)~'],
            'actions.*.fallback_label' => ['required_with:actions.*.href', 'nullable', 'string', 'max:34'],
            'actions.*.fallback_intent' => ['required_with:actions.*.href', 'nullable', 'in:'.implode(',', InquiryIntents::accepted())],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        $valid['heading'] = InlineText::sanitize(strip_tags($valid['heading'], '<em>'));
        $valid['eyebrow'] = InlineText::plain($valid['eyebrow']);
        $valid['intro'] = InlineText::plain($valid['intro']);

        $valid['actions'] = array_map(function (array $a) {
            $href = $a['href'] ?? null;
            // A page link only once its page is routed; until then an honest action that does work.
            $linked = $href !== null && ! isset($a['intent']) && InternalLink::isAvailable($href);

            return [
                'label' => InlineText::plain($linked || $href === null ? $a['label'] : $a['fallback_label']),
                'href' => $linked ? $href : null,
                'intent' => $linked ? null : InquiryIntents::resolve($a['intent'] ?? $a['fallback_intent']),
                'style' => $a['style'],
                'icon' => $a['icon'] ?? null,
            ];
        }, array_values($valid['actions']));

        $valid['options'] = array_map(function (array $o) {
            $img = $o['image'];

            return [
                'id' => $o['id'],
                'label' => InlineText::plain($o['label']),
                'icon' => $o['icon'],
                'kicker' => InlineText::plain($o['kicker']),
                'caption' => InlineText::plain($o['caption']),
                'image' => [
                    'src' => $img['src'],
                    'src_mobile' => $img['src_mobile'] ?? null,
                    'width' => (int) $img['width'],
                    'height' => (int) $img['height'],
                    'alt' => InlineText::plain($img['alt']),
                    'provenance' => $img['provenance'],
                    'source_url' => $img['source_url'] ?? null,
                    'rights' => $img['rights'],
                    'label' => InlineText::plain($img['label']),
                    'fit' => $img['fit'] ?? 'cover',
                    'position' => $img['position'] ?? '50% 50%',
                ],
            ];
        }, array_values($valid['options']));

        return $valid;
    }
}
