<?php

namespace App\Content;

final class SectionInstance
{
    /** @param array<string, mixed> $data Normalised by the section schema. */
    public function __construct(
        public readonly string $key,
        public readonly string $type,
        public readonly bool $enabled,
        public readonly array $data,
    ) {}
}
