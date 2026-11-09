<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Homepage section 02: "Two Paths. One Commitment to Care."
 *
 * Two full-height flip cards (Memory Care, Respite Care). The front shows the
 * approved photo card; the back shows a short statement, three benefits and
 * "who this supports". Copy is condensed from the React reference
 * (components/CareOptionsSection.tsx + CARE_PROGRAMS).
 *
 * The layout is designed for exactly two cards and three benefits per back
 * face, so the schema enforces those counts and caps text lengths that would
 * otherwise overflow the ~100svh desktop composition.
 */
final class CareOptionsSection implements SectionSchema
{
    public const CARD_COUNT = 2;

    /** Icons the view knows how to draw (resources/views/sections/care-options/icon.blade.php). */
    public const ICONS = ['brain', 'calendar', 'heart', 'people', 'routine', 'bed', 'dining', 'hands'];

    public const CTA_STYLES = ['terracotta', 'cream'];

    public static function type(): string
    {
        return 'care.options';
    }

    public static function label(): string
    {
        return 'Care options (two flip cards)';
    }

    public static function view(): string
    {
        return 'sections.care-options.index';
    }

    public function normalize(array $data): array
    {
        $icon = ['required', 'in:'.implode(',', self::ICONS)];
        // Site-relative paths or https URLs only: never javascript:, data: etc.
        $link = ['required', 'string', 'max:255', 'regex:#^(/(?!/)|https://)#'];

        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:40'],
            'heading' => ['required', 'string', 'max:80'],
            'subheading' => ['required', 'string', 'max:140'],
            'cards' => ['required', 'array', 'size:'.self::CARD_COUNT],
            'cards.*.id' => ['required', 'alpha_dash', 'max:30', 'distinct'],
            'cards.*.icon' => $icon,
            'cards.*.kicker' => ['required', 'string', 'max:30'],
            'cards.*.title' => ['required', 'string', 'max:28'],
            'cards.*.summary' => ['required', 'string', 'max:140'],
            'cards.*.image.src' => ['required', 'string', 'max:255'],
            'cards.*.image.src_mobile' => ['nullable', 'string', 'max:255'],
            'cards.*.image.alt' => ['required', 'string', 'max:200'],
            // Honesty guard: every image must declare whether it is real facility photography.
            'cards.*.image.provenance' => ['required', 'in:facility,illustrative'],
            'cards.*.image.source_url' => ['nullable', 'url', 'max:255'],
            // CSS object-position, e.g. "50% 30%".
            'cards.*.image.position' => ['nullable', 'regex:/^\d{1,3}% \d{1,3}%$/'],
            'cards.*.cta.label' => ['required', 'string', 'max:32'],
            'cards.*.cta.href' => $link,
            'cards.*.cta.style' => ['required', 'in:'.implode(',', self::CTA_STYLES)],
            'cards.*.back.kicker' => ['required', 'string', 'max:36'],
            'cards.*.back.statement' => ['required', 'string', 'max:130'],
            'cards.*.back.benefits' => ['required', 'array', 'size:3'],
            'cards.*.back.benefits.*.icon' => $icon,
            'cards.*.back.benefits.*.text' => ['required', 'string', 'max:56'],
            'cards.*.back.audience_label' => ['required', 'string', 'max:30'],
            'cards.*.back.audience' => ['required', 'string', 'max:110'],
            'visit_cta' => ['required', 'string', 'max:32'],
            'care_guide_cta' => ['nullable', 'string', 'max:48'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        $valid['heading'] = InlineText::sanitize($valid['heading']);
        foreach (['eyebrow', 'subheading', 'visit_cta'] as $field) {
            $valid[$field] = InlineText::plain($valid[$field]);
        }
        $valid['care_guide_cta'] = isset($valid['care_guide_cta']) ? InlineText::plain($valid['care_guide_cta']) : null;

        $valid['cards'] = array_map(function (array $card): array {
            foreach (['kicker', 'title', 'summary'] as $field) {
                $card[$field] = InlineText::plain($card[$field]);
            }
            $card['cta']['label'] = InlineText::plain($card['cta']['label']);
            foreach (['kicker', 'statement', 'audience_label', 'audience'] as $field) {
                $card['back'][$field] = InlineText::plain($card['back'][$field]);
            }
            $card['back']['benefits'] = array_map(fn (array $b) => [
                'icon' => $b['icon'],
                'text' => InlineText::plain($b['text']),
            ], array_values($card['back']['benefits']));
            $card['image']['src_mobile'] ??= null;
            $card['image']['source_url'] ??= null;
            $card['image']['position'] ??= '50% 50%';

            return $card;
        }, array_values($valid['cards']));

        return $valid;
    }
}
