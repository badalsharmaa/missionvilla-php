<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Resources Section 04: Original Blog Inventory Status & Verified Topic Router.
 *
 * Strict zero-fabrication editorial protocol documenting the 4-stage blog migration ledger
 * alongside direct routing to verified live pages.
 */
final class ResourcesBlogSection implements SectionSchema
{
    public static function type(): string
    {
        return 'resources.blog';
    }

    public static function label(): string
    {
        return 'Resources Blog Status (4-stage migration ledger & verified topic bridges)';
    }

    public static function view(): string
    {
        return 'sections.resources-blog.index';
    }

    public function normalize(array $data): array
    {
        $validator = Validator::make($data, [
            'eyebrow' => ['required', 'string', 'max:80'],
            'heading' => ['required', 'string', 'max:140'],
            'intro' => ['required', 'string', 'max:500'],

            'guardrails' => ['required', 'array', 'size:3'],
            'guardrails.*.title' => ['required', 'string', 'max:60'],
            'guardrails.*.text' => ['required', 'string', 'max:240'],

            'stages' => ['required', 'array', 'size:4'],
            'stages.*.id' => ['required', 'string', 'max:50'],
            'stages.*.stepNumber' => ['required', 'string', 'max:20'],
            'stages.*.stageTitle' => ['required', 'string', 'max:80'],
            'stages.*.statusLabel' => ['required', 'string', 'max:60'],
            'stages.*.summary' => ['required', 'string', 'max:400'],
            'stages.*.guardrailDetail' => ['required', 'string', 'max:300'],
            'stages.*.deliverableNote' => ['required', 'string', 'max:200'],

            'router_eyebrow' => ['required', 'string', 'max:80'],
            'router_heading' => ['required', 'string', 'max:140'],
            'router_intro' => ['required', 'string', 'max:300'],

            'bridges' => ['required', 'array', 'size:4'],
            'bridges.*.id' => ['required', 'string', 'max:50'],
            'bridges.*.topicTag' => ['required', 'string', 'max:60'],
            'bridges.*.commonFamilyQuestion' => ['required', 'string', 'max:160'],
            'bridges.*.verifiedDestinationTitle' => ['required', 'string', 'max:100'],
            'bridges.*.whatYouWillFind' => ['required', 'string', 'max:300'],
            'bridges.*.href' => ['required', 'string', 'max:100'],
            'bridges.*.ctaLabel' => ['required', 'string', 'max:60'],
        ]);

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        $valid = $validator->validated();

        return [
            'eyebrow' => InlineText::plain($valid['eyebrow']),
            'heading' => InlineText::render($valid['heading']),
            'intro' => InlineText::render($valid['intro']),
            'guardrails' => array_map(function (array $g) {
                return [
                    'title' => InlineText::plain($g['title']),
                    'text' => trim($g['text']),
                ];
            }, $valid['guardrails']),
            'stages' => array_map(function (array $s) {
                return [
                    'id' => $s['id'],
                    'stepNumber' => InlineText::plain($s['stepNumber']),
                    'stageTitle' => InlineText::plain($s['stageTitle']),
                    'statusLabel' => InlineText::plain($s['statusLabel']),
                    'summary' => InlineText::plain($s['summary']),
                    'guardrailDetail' => InlineText::plain($s['guardrailDetail']),
                    'deliverableNote' => InlineText::plain($s['deliverableNote']),
                ];
            }, $valid['stages']),
            'router_eyebrow' => InlineText::plain($valid['router_eyebrow']),
            'router_heading' => InlineText::render($valid['router_heading']),
            'router_intro' => InlineText::plain($valid['router_intro']),
            'bridges' => array_map(function (array $b) {
                return [
                    'id' => $b['id'],
                    'topicTag' => InlineText::plain($b['topicTag']),
                    'commonFamilyQuestion' => InlineText::plain($b['commonFamilyQuestion']),
                    'verifiedDestinationTitle' => InlineText::plain($b['verifiedDestinationTitle']),
                    'whatYouWillFind' => InlineText::plain($b['whatYouWillFind']),
                    'href' => $b['href'],
                    'ctaLabel' => InlineText::plain($b['ctaLabel']),
                ];
            }, $valid['bridges']),
        ];
    }
}
