<?php

namespace App\Content;

/**
 * A page and its ordered, validated sections, independent of where the
 * content is stored (git-reviewed files today, CMS tables later).
 */
final class PageDefinition
{
    /**
     * @param  array{title: string, description: string, og_image?: string|null}  $seo
     * @param  list<SectionInstance>  $sections
     */
    public function __construct(
        public readonly string $slug,
        public readonly array $seo,
        public readonly array $sections,
    ) {}

    /** @return list<SectionInstance> */
    public function enabledSections(): array
    {
        return array_values(array_filter($this->sections, fn (SectionInstance $s) => $s->enabled));
    }
}
