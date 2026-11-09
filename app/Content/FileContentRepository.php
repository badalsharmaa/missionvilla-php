<?php

namespace App\Content;

use App\Content\Contracts\ContentRepository;

/**
 * Phase 1 content source: PHP arrays in content/pages, reviewed in git.
 */
final class FileContentRepository implements ContentRepository
{
    public function __construct(
        private readonly SectionRegistry $registry,
        private readonly string $directory,
    ) {}

    public function findPublishedPage(string $slug): ?PageDefinition
    {
        if (! preg_match('/^[a-z0-9-]+$/', $slug)) {
            return null;
        }

        $path = $this->directory.DIRECTORY_SEPARATOR.$slug.'.php';
        if (! is_file($path)) {
            return null;
        }

        /** @var array{slug: string, seo: array, sections: list<array>} $raw */
        $raw = require $path;

        return new PageDefinition(
            slug: $raw['slug'],
            seo: $raw['seo'],
            sections: array_map(fn (array $s) => $this->registry->instantiate($s), $raw['sections']),
        );
    }
}
