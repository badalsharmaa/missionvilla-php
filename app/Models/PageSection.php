<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PageSection extends Model
{
    protected $fillable = ['page_id', 'key', 'type', 'position', 'enabled', 'draft_data', 'published_data', 'published_at', 'updated_by'];

    protected function casts(): array
    {
        return [
            'enabled' => 'boolean',
            'draft_data' => 'array',
            'published_data' => 'array',
            'published_at' => 'datetime',
        ];
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(SectionRevision::class)->latest('id');
    }
}
