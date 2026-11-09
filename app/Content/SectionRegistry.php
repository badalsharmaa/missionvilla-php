<?php

namespace App\Content;

use App\Content\Contracts\SectionSchema;
use InvalidArgumentException;

/**
 * The whitelist of section components a page may contain.
 *
 * Only registered, approved sections can be placed on a page; editors can
 * reorder, enable or disable them and edit their fields, but cannot create
 * arbitrary layouts.
 */
final class SectionRegistry
{
    /** @var array<string, SectionSchema> */
    private array $schemas = [];

    /** @param iterable<SectionSchema> $schemas */
    public function __construct(iterable $schemas = [])
    {
        foreach ($schemas as $schema) {
            $this->register($schema);
        }
    }

    public function register(SectionSchema $schema): void
    {
        $this->schemas[$schema::type()] = $schema;
    }

    public function has(string $type): bool
    {
        return isset($this->schemas[$type]);
    }

    public function get(string $type): SectionSchema
    {
        return $this->schemas[$type]
            ?? throw new InvalidArgumentException("Unknown section type [{$type}]. Register it in SectionRegistry before use.");
    }

    /** @return array<string, SectionSchema> */
    public function all(): array
    {
        return $this->schemas;
    }

    /**
     * Build a validated section instance from raw stored content.
     *
     * @param  array{key: string, type: string, enabled?: bool, data?: array<string, mixed>}  $raw
     */
    public function instantiate(array $raw): SectionInstance
    {
        $schema = $this->get($raw['type']);

        return new SectionInstance(
            key: $raw['key'],
            type: $raw['type'],
            enabled: (bool) ($raw['enabled'] ?? true),
            data: $schema->normalize($raw['data'] ?? []),
        );
    }
}
