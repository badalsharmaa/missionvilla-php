<?php

namespace Tests\Feature;

use App\Content\Contracts\ContentRepository;
use App\Content\InvalidSectionData;
use App\Content\Media\LifeGalleryManifest;
use App\Content\PageDefinition;
use App\Content\SectionRegistry;
use App\Content\Sections\WhyFamiliesSection;
use Tests\TestCase;

class WhyFamiliesSectionTest extends TestCase
{
    private const DIR = 'media/mission-villa/life-at-mission-villa';

    private string $root;

    protected function setUp(): void
    {
        parent::setUp();
        $this->root = sys_get_temp_dir().'/mv-why-'.bin2hex(random_bytes(6));
        mkdir($this->root.'/'.self::DIR, 0777, true);
    }

    protected function tearDown(): void
    {
        foreach (glob($this->root.'/'.self::DIR.'/*') ?: [] as $file) {
            unlink($file);
        }
        foreach ([self::DIR, 'media/mission-villa', 'media', ''] as $dir) {
            @rmdir(rtrim($this->root.'/'.$dir, '/'));
        }
        parent::tearDown();
    }

    private function shippedData(): array
    {
        $page = require base_path('content/pages/home.php');

        return collect($page['sections'])->firstWhere('key', 'why-families')['data'];
    }

    private function section(): WhyFamiliesSection
    {
        return new WhyFamiliesSection(new LifeGalleryManifest($this->root));
    }

    private function assertRejected(array $data): void
    {
        $this->expectException(InvalidSectionData::class);
        $this->section()->normalize($data);
    }

    public function test_shipped_homepage_content_is_valid(): void
    {
        $data = $this->section()->normalize($this->shippedData());

        $this->assertSame('A Trusted Partner in Your Family’s <em>Next Chapter</em>', $data['heading']);
        $this->assertCount(WhyFamiliesSection::FACT_COUNT, $data['glance']['facts']);
        $this->assertCount(WhyFamiliesSection::VALUE_COUNT, $data['values']);
        $this->assertFileExists(public_path(ltrim($data['image']['src'], '/')));
        $this->assertFileExists(public_path(ltrim($data['image']['src_mobile'], '/')));
    }

    public function test_courtyard_is_declared_as_facility_photo_with_unconfirmed_rights(): void
    {
        $image = $this->section()->normalize($this->shippedData())['image'];

        $this->assertSame('facility', $image['provenance']);
        $this->assertSame('unconfirmed', $image['rights'], 'Flip to "cleared" only after the client confirms publication rights.');
        $this->assertNotNull($image['source_url']);
    }

    public function test_facts_make_no_unverified_claims(): void
    {
        $text = strtolower(json_encode($this->shippedData()));

        foreach (['award', 'rated', 'ratio', '24/7', 'guarantee', 'licensed nurse', 'years of experience', 'safest', 'best '] as $claim) {
            $this->assertStringNotContainsString($claim, $text);
        }
        $this->assertStringContainsString('995 east market street', $text);
    }

    public function test_layout_requires_exactly_four_facts_and_four_values(): void
    {
        $data = $this->shippedData();
        $data['glance']['facts'][] = ['icon' => 'pin', 'title' => 'A fifth fact', 'text' => 'Too many.'];
        $this->assertRejected($data);
    }

    public function test_values_strip_requires_four_items(): void
    {
        $data = $this->shippedData();
        array_pop($data['values']);
        $this->assertRejected($data);
    }

    public function test_excessive_copy_is_rejected(): void
    {
        $data = $this->shippedData();
        $data['body'] = str_repeat('Long copy breaks the composition. ', 10);
        $this->assertRejected($data);
    }

    public function test_long_fact_text_is_rejected(): void
    {
        $data = $this->shippedData();
        $data['glance']['facts'][0]['text'] = str_repeat('x', 91);
        $this->assertRejected($data);
    }

    public function test_unknown_icon_is_rejected(): void
    {
        $data = $this->shippedData();
        $data['values'][0]['icon'] = 'trophy';
        $this->assertRejected($data);
    }

    public function test_image_must_declare_provenance_and_rights(): void
    {
        $data = $this->shippedData();
        $data['image']['rights'] = 'probably-fine';
        $this->assertRejected($data);
    }

    public function test_javascript_links_are_rejected(): void
    {
        $data = $this->shippedData();
        $data['tour_cta']['href'] = 'javascript:alert(1)';
        $this->assertRejected($data);
    }

    public function test_heading_keeps_only_emphasis(): void
    {
        $data = $this->shippedData();
        $data['heading'] = '<b>A</b> <a href="x">B</a> <em class="x">C</em><i>z</i>';

        $this->assertSame('A B <em>C</em>z', $this->section()->normalize($data)['heading']);
    }

    public function test_body_and_facts_are_plain_text(): void
    {
        $data = $this->shippedData();
        $data['body'] = 'Hello <b>world</b> <img src=x onerror=alert(1)>';
        $data['glance']['facts'][0]['title'] = '<em>Daly City</em>';

        $normalized = $this->section()->normalize($data);
        $this->assertSame('Hello world', $normalized['body']);
        $this->assertSame('Daly City', $normalized['glance']['facts'][0]['title']);
    }

    public function test_tour_cta_is_marked_pending_until_a_film_exists(): void
    {
        $this->assertTrue($this->section()->normalize($this->shippedData())['tour_cta']['pending']);

        $dir = $this->root.'/'.self::DIR;
        file_put_contents($dir.'/living-spaces.mp4', 'x');
        file_put_contents($dir.'/media-manifest.json', json_encode([
            'schema' => LifeGalleryManifest::SCHEMA,
            'chapters' => [[
                'id' => 'living-spaces',
                'title' => 'Living Spaces',
                'video' => ['src' => 'living-spaces.mp4', 'type' => 'video/mp4', 'duration_seconds' => 42],
                'audio' => ['has_audio' => false],
                'provenance' => ['type' => 'illustrative', 'method' => 'ai-generated', 'label' => 'Illustrative film'],
            ]],
        ]));

        $this->assertFalse($this->section()->normalize($this->shippedData())['tour_cta']['pending']);
    }

    public function test_tour_cta_is_optional(): void
    {
        $data = $this->shippedData();
        unset($data['tour_cta']);

        $this->assertNull($this->section()->normalize($data)['tour_cta']);
    }

    public function test_homepage_renders_section_after_life_gallery(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertSame(1, substr_count($html, 'class="why-families"'));
        $this->assertLessThan(strpos($html, 'id="why-families"'), strpos($html, 'id="life-at-mission-villa"'));
        $this->assertStringContainsString('A Trusted Partner in Your Family’s <em>Next Chapter</em>', $html);
        $this->assertStringContainsString('data-wf-visit', $html);
        $this->assertStringContainsString('href="#life-at-mission-villa"', $html);
        $this->assertStringContainsString('Films in production', $html);
        $this->assertStringContainsString('courtyard-patio-facility-1024.webp', $html);
        $this->assertStringContainsString('data-provenance="facility" data-rights="unconfirmed"', $html);
    }

    public function test_section_can_be_disabled_through_content(): void
    {
        $this->app->instance(ContentRepository::class, new class implements ContentRepository
        {
            public function findPublishedPage(string $slug): ?PageDefinition
            {
                $raw = require base_path('content/pages/home.php');
                foreach ($raw['sections'] as &$section) {
                    if ($section['key'] === 'why-families') {
                        $section['enabled'] = false;
                    }
                }
                unset($section);
                $registry = app(SectionRegistry::class);

                return new PageDefinition($raw['slug'], $raw['seo'], array_map(fn ($s) => $registry->instantiate($s), $raw['sections']));
            }
        });

        $html = $this->get('/')->assertOk()->getContent();
        $this->assertStringNotContainsString('id="why-families"', $html);
        $this->assertStringContainsString('id="life-at-mission-villa"', $html);
    }
}
