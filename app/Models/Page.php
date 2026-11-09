<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    protected $fillable = ['slug', 'title', 'seo_draft', 'seo_published', 'published_at', 'published_by'];

    protected function casts(): array
    {
        return [
            'seo_draft' => 'array',
            'seo_published' => 'array',
            'published_at' => 'datetime',
        ];
    }

    public function sections(): HasMany
    {
        return $this->hasMany(PageSection::class)->orderBy('position');
    }
}
