<?php

namespace App\Content\Contracts;

use App\Content\InvalidSectionData;

/**
 * A reusable, validated section component.
 *
 * Each approved design section has exactly one schema. The schema defines
 * which fields editors may change and the limits that keep the approved
 * layout intact; the Blade view owns all presentation.
 */
interface SectionSchema
{
    /** Stable machine name stored with content, e.g. "hero.cinematic". */
    public static function type(): string;

    /** Human label for the CMS. */
    public static function label(): string;

    /** Blade view that renders the section. */
    public static function view(): string;

    /**
     * Validate and normalise editor data.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     *
     * @throws InvalidSectionData
     */
    public function normalize(array $data): array;
}
