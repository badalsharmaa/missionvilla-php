<?php

namespace App\Content;

use App\Content\Contracts\ContentRepository;
use App\Models\Page;

/**
 * CMS content source: published data from the pages/page_sections tables.
 * Published data is re-validated through the section schema on read, so a
 * bad row can never render outside the approved component limits.
 */
final class DatabaseContentRepository implements ContentRepository
{
    public function __construct(private readonly SectionRegistry $registry) {}

    public function findPublishedPage(string $slug): ?PageDefinition
    {
        $page = Page::query()->where('slug', $slug)->whereNotNull('published_at')->with('sections')->first();
        if (! $page) {
            return null;
        }

        $sections = [];
        foreach ($page->sections as $section) {
            if ($section->published_data === null || ! $this->registry->has($section->type)) {
                continue;
            }
            $sections[] = $this->registry->instantiate([
                'key' => $section->key,
                'type' => $section->type,
                'enabled' => $section->enabled,
                'data' => $section->published_data,
            ]);
        }

        return new PageDefinition($page->slug, $page->seo_published ?? ['title' => $page->title, 'description' => ''], $sections);
    }
}
