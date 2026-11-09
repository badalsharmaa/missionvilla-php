<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Immutable snapshot of a section, written on save, publish and rollback. */
class SectionRevision extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = ['page_section_id', 'event', 'data', 'enabled', 'position', 'note', 'created_by'];

    protected function casts(): array
    {
        return ['data' => 'array', 'enabled' => 'boolean'];
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(PageSection::class, 'page_section_id');
    }
}
