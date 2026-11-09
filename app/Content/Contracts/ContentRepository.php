<?php

namespace App\Content\Contracts;

use App\Content\PageDefinition;

interface ContentRepository
{
    /** Published content for a page, or null if the page does not exist. */
    public function findPublishedPage(string $slug): ?PageDefinition;
}
