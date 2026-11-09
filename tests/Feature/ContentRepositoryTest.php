<?php

namespace Tests\Feature;

use App\Content\DatabaseContentRepository;
use App\Content\SectionRegistry;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_repository_renders_only_published_registered_sections(): void
    {
        $home = require base_path('content/pages/home.php');
        $hero = collect($home['sections'])->firstWhere('key', 'hero');
        $page = Page::create(['slug' => 'home', 'title' => 'Home', 'seo_published' => $home['seo'], 'published_at' => now()]);
        $page->sections()->create(['key' => 'hero', 'type' => 'hero.cinematic', 'position' => 0, 'draft_data' => $hero['data'], 'published_data' => $hero['data'], 'published_at' => now()]);
        $page->sections()->create(['key' => 'draft-only', 'type' => 'hero.cinematic', 'position' => 1, 'draft_data' => [], 'published_data' => null]);
        $page->sections()->create(['key' => 'unknown', 'type' => 'not.registered', 'position' => 2, 'draft_data' => [], 'published_data' => ['x' => 1]]);

        $definition = (new DatabaseContentRepository(app(SectionRegistry::class)))->findPublishedPage('home');

        $this->assertNotNull($definition);
        $this->assertSame(['hero'], array_map(fn ($s) => $s->key, $definition->sections));
    }

    public function test_unpublished_page_is_not_found(): void
    {
        Page::create(['slug' => 'draft-page', 'title' => 'Draft']);

        $this->assertNull((new DatabaseContentRepository(app(SectionRegistry::class)))->findPublishedPage('draft-page'));
    }
}
