<?php

namespace Tests\Feature;

use App\Content\Contracts\ContentRepository;
use App\Content\InvalidSectionData;
use App\Content\PageDefinition;
use App\Content\SectionRegistry;
use App\Content\Sections\FaqFeaturedSection;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class FaqFeaturedSectionTest extends TestCase
{
    private function shippedData(): array
    {
        $page = require base_path('content/pages/home.php');

        return collect($page['sections'])->firstWhere('key', 'faq')['data'];
    }

    private function normalize(array $data): array
    {
        return (new FaqFeaturedSection)->normalize($data);
    }

    private function entry(string $id, int $order, bool $enabled = true, bool $featured = true, string $answer = 'A short answer.'): array
    {
        return [
            'id' => $id, 'question' => "Question $id?", 'answer' => $answer,
            'icon' => 'heart', 'order' => $order, 'enabled' => $enabled, 'featured' => $featured,
        ];
    }

    private function withEntries(array $entries): array
    {
        return ['entries' => $entries] + $this->shippedData();
    }

    public function test_shipped_content_has_the_four_approved_questions_in_order(): void
    {
        $items = $this->normalize($this->shippedData())['items'];

        $this->assertSame([
            'What is included in the Legacies™ Memory Care program?',
            'Can we arrange a short-term Respite Care stay?',
            'What suite options are available?',
            'How can we learn about pricing and schedule a visit?',
        ], array_column($items, 'question'));
    }

    public function test_disabled_or_non_featured_entries_are_excluded(): void
    {
        $items = $this->normalize($this->withEntries([
            $this->entry('one', 1),
            $this->entry('off', 2, enabled: false),
            $this->entry('plain', 3, featured: false),
            $this->entry('two', 4),
        ]))['items'];

        $this->assertSame(['one', 'two'], array_column($items, 'id'));
    }

    public function test_order_field_beats_array_position(): void
    {
        $items = $this->normalize($this->withEntries([
            $this->entry('third', 30),
            $this->entry('first', 10),
            $this->entry('second', 20),
        ]))['items'];

        $this->assertSame(['first', 'second', 'third'], array_column($items, 'id'));
    }

    public function test_only_first_four_featured_by_order_are_shown(): void
    {
        $entries = [];
        foreach ([60, 50, 40, 30, 20, 10] as $order) {
            $entries[] = $this->entry("q$order", $order);
        }

        $items = $this->normalize($this->withEntries($entries))['items'];

        $this->assertSame(['q10', 'q20', 'q30', 'q40'], array_column($items, 'id'));
    }

    public function test_zero_featured_entries_is_rejected(): void
    {
        $this->expectException(InvalidSectionData::class);
        $this->normalize($this->withEntries([$this->entry('a', 1, featured: false), $this->entry('b', 2, enabled: false)]));
    }

    public function test_all_link_hidden_until_page_is_routed(): void
    {
        $this->assertNull($this->normalize($this->shippedData())['all_link']);

        Route::get('/for-families', fn () => 'ok');
        app('router')->getRoutes()->refreshNameLookups();

        $this->assertSame(
            ['label' => 'View All FAQs', 'href' => '/for-families'],
            $this->normalize($this->shippedData())['all_link']
        );
    }

    public function test_overlong_answer_is_rejected(): void
    {
        $this->expectException(InvalidSectionData::class);
        $this->normalize($this->withEntries([$this->entry('long', 1, answer: str_repeat('a', 421))]));
    }

    public function test_html_in_answers_is_escaped_on_the_homepage(): void
    {
        $this->app->instance(ContentRepository::class, new class implements ContentRepository
        {
            public function findPublishedPage(string $slug): ?PageDefinition
            {
                $raw = require base_path('content/pages/home.php');
                foreach ($raw['sections'] as &$s) {
                    if ($s['key'] === 'faq') {
                        $s['data']['entries'][0]['answer'] = 'Safe <script>alert("xss")</script> <b>bold</b> answer.';
                    }
                }
                unset($s);
                $registry = app(SectionRegistry::class);

                return new PageDefinition($raw['slug'], $raw['seo'], array_map(fn ($s) => $registry->instantiate($s), $raw['sections']));
            }
        });

        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringNotContainsString('<script>alert("xss")', $html);
        $this->assertStringNotContainsString('<b>bold</b>', $html);
        // Tags are stripped by InlineText::plain and the remaining text is HTML-escaped.
        $this->assertStringContainsString('Safe alert(&quot;xss&quot;) bold answer.', $html);
    }
}
