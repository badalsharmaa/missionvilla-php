<?php

namespace App\Content;

use RuntimeException;

final class InvalidSectionData extends RuntimeException
{
    /** @param array<string, array<int, string>> $errors */
    public function __construct(public readonly string $sectionType, public readonly array $errors)
    {
        parent::__construct("Invalid content for section [{$sectionType}]: ".json_encode($errors));
    }
}
