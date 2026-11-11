<?php

namespace Tests\Feature;

use App\Content\InvalidSectionData;
use App\Content\Media\LifeGalleryManifest;
use App\Content\Sections\LifeGallerySection;
use App\Support\InternalLink;
use Tests\TestCase;

class LifeGallerySectionTest extends TestCase
{
    private const DIR = 'media/mission-villa/life-at-mission-villa';

    private string $root;

    protected function setUp(): void
    {
        parent::setUp();
        $this->root = sys_get_temp_dir().'/mv-life-'.bin2hex(random_bytes(6));
        mkdir($this->root.'/'.self::DIR, 0777, true);
    }

    protected function tearDown(): void
    {
        $this->rm($this->root);
        parent::tearDown();
    }

    private function rm(string $path): void
    {
        if (is_dir($path)) {
            foreach (scandir($path) as $f) {
                if ($f !== '.' && $f !== '..') {
                    $this->rm($path.'/'.$f);
                }
            }
            rmdir($path);
        } elseif (file_exists($path)) {
            unlink($path);
        }
    }

    private function shippedData(): array
    {
        $page = require base_path('content/pages/home.php');

        return collect($page['sections'])->firstWhere('key', 'life-gallery')['data'];
    }

    private function section(): LifeGallerySection
    {
        return new LifeGallerySection(new LifeGalleryManifest($this->root));
    }

    private function touchFile(string $name, string $content = 'x'): void
    {
        file_put_contents($this->root.'/'.self::DIR.'/'.$name, $content);
    }

    private function writeManifest(array|string $manifest): void
    {
        $this->touchFile('media-manifest.json', is_string($manifest) ? $manifest : json_encode($manifest));
    }

    private function manifestChapter(array $overrides = []): array
    {
        return array_replace_recursive([
            'id' => 'living-spaces',
            'title' => 'Living Spaces Film',
            'video' => ['src' => 'living-spaces.mp4', 'type' => 'video/mp4', 'duration_seconds' => 42],
            'poster' => ['src' => 'living-spaces-poster.jpg', 'alt' => 'A poster'],
            'captions' => [['src' => 'living-spaces.vtt', 'srclang' => 'en', 'label' => 'English']],
            'audio' => ['has_audio' => false],
            'provenance' => ['type' => 'illustrative', 'method' => 'ai-generated', 'label' => 'Illustrative film from manifest'],
        ], $overrides);
    }

    private function manifestDoc(array $chapter, array $extra = []): array
    {
        return array_merge(['schema' => LifeGalleryManifest::SCHEMA, 'chapters' => [$chapter]], $extra);
    }

    private function normalize(?array $data = null): array
    {
        return $this->section()->normalize($data ?? $this->shippedData());
    }

    private function assertRejected(array $data): void
    {
        $this->expectException(InvalidSectionData::class);
        (new LifeGallerySection)->normalize($data);
    }

    private function assertAllUnavailable(array $data): void
    {
        foreach ($data['chapters'] as $chapter) {
            $this->assertFalse($chapter['media']['available']);
            $this->assertSame([], $chapter['media']['sources']);
        }
    }

    // 1. Shipped content

    public function test_shipped_homepage_content_is_valid_with_fallback_posters(): void
    {
        $shipped = $this->shippedData();
        $data = $this->normalize();

        $this->assertCount(3, $data['chapters']);
        $this->assertSame(['living-spaces', 'dining-daily-life', 'meaningful-connection'], array_column($data['chapters'], 'id'));

        foreach ($shipped['chapters'] as $chapter) {
            $this->assertFileExists(public_path(ltrim($chapter['fallback_poster']['src'], '/')));
            $this->assertFileExists(public_path(ltrim($chapter['fallback_poster']['src_mobile'], '/')));
        }

        foreach ($data['chapters'] as $chapter) {
            $media = $chapter['media'];
            $this->assertFalse($media['available']);
            $this->assertSame([], $media['sources']);
            $this->assertTrue($media['poster']['is_fallback']);
            $this->assertSame($shipped['labels']['illustrative_image'], $media['provenance_label']);
        }
    }

    // 2. Layout limits

    public function test_exactly_three_chapters_are_required(): void
    {
        $data = $this->shippedData();
        array_pop($data['chapters']);
        $this->assertRejected($data);
    }

    public function test_four_chapters_are_rejected(): void
    {
        $data = $this->shippedData();
        $data['chapters'][] = $data['chapters'][0];
        $data['chapters'][3]['id'] = 'extra';
        $this->assertRejected($data);
    }

    public function test_overlong_title_is_rejected(): void
    {
        $data = $this->shippedData();
        $data['chapters'][0]['title'] = str_repeat('Long ', 20);
        $this->assertRejected($data);
    }

    public function test_overlong_description_is_rejected(): void
    {
        $data = $this->shippedData();
        $data['chapters'][1]['description'] = str_repeat('Long words ', 30);
        $this->assertRejected($data);
    }

    public function test_unknown_icon_is_rejected(): void
    {
        $data = $this->shippedData();
        $data['chapters'][0]['icon'] = 'skull';
        $this->assertRejected($data);
    }

    public function test_fallback_poster_requires_valid_provenance(): void
    {
        $data = $this->shippedData();
        $data['chapters'][0]['fallback_poster']['provenance'] = 'probably-real';
        $this->assertRejected($data);

        $data = $this->shippedData();
        unset($data['chapters'][2]['fallback_poster']['provenance']);
        $this->assertRejected($data);
    }

    public function test_unsafe_cta_hrefs_are_rejected(): void
    {
        foreach (['javascript:alert(1)', '//evil.example', 'data:text/html,x', 'http://insecure.example'] as $href) {
            $data = $this->shippedData();
            $data['chapters'][0]['cta']['href'] = $href;
            try {
                (new LifeGallerySection)->normalize($data);
                $this->fail("Href [$href] should have been rejected.");
            } catch (InvalidSectionData) {
                $this->addToAssertionCount(1);
            }
        }
    }

    public function test_remote_video_override_is_rejected(): void
    {
        $data = $this->shippedData();
        $data['chapters'][0]['media']['video_src'] = 'https://cdn.example.com/film.mp4';
        $this->assertRejected($data);
    }

    public function test_path_traversal_in_media_overrides_is_rejected(): void
    {
        foreach (['video_src' => '/media/../.env.mp4', 'poster_src' => '/media/../x.jpg', 'captions_src' => '/media/../x.vtt'] as $key => $path) {
            $data = $this->shippedData();
            $data['chapters'][0]['media'][$key] = $path;
            try {
                (new LifeGallerySection)->normalize($data);
                $this->fail("Override [$path] should have been rejected.");
            } catch (InvalidSectionData) {
                $this->addToAssertionCount(1);
            }
        }
    }

    // 3. Manifest resolution

    public function test_valid_manifest_makes_one_chapter_available(): void
    {
        $this->touchFile('living-spaces.mp4');
        $this->touchFile('living-spaces-poster.jpg');
        $this->touchFile('living-spaces.vtt');
        $this->writeManifest($this->manifestDoc($this->manifestChapter()));

        $data = $this->normalize();
        $media = $data['chapters'][0]['media'];

        $this->assertTrue($media['available']);
        $this->assertSame('/media/mission-villa/life-at-mission-villa/living-spaces.mp4', $media['sources'][0]['src']);
        $this->assertSame('video/mp4', $media['sources'][0]['type']);
        $this->assertFalse($media['poster']['is_fallback']);
        $this->assertSame('/media/mission-villa/life-at-mission-villa/living-spaces-poster.jpg', $media['poster']['src']);
        $this->assertCount(1, $media['captions']);
        $this->assertSame('/media/mission-villa/life-at-mission-villa/living-spaces.vtt', $media['captions'][0]['src']);
        $this->assertEquals(42, $media['duration_seconds']);
        $this->assertSame('Illustrative film from manifest', $media['provenance_label']);
        $this->assertSame('illustrative', $media['provenance']);
        $this->assertFalse($media['has_audio']);

        foreach ([1, 2] as $i) {
            $this->assertFalse($data['chapters'][$i]['media']['available']);
            $this->assertTrue($data['chapters'][$i]['media']['poster']['is_fallback']);
        }
    }

    public function test_manifest_referencing_missing_mp4_leaves_chapter_unavailable(): void
    {
        $this->touchFile('living-spaces-poster.jpg');
        $this->touchFile('living-spaces.vtt');
        $this->writeManifest($this->manifestDoc($this->manifestChapter()));

        $data = $this->normalize();

        $this->assertAllUnavailable($data);
        $this->assertTrue($data['chapters'][0]['media']['poster']['is_fallback']);
        $this->assertSame([], $data['chapters'][0]['media']['captions']);
    }

    public function test_invalid_json_manifest_is_ignored_without_exception(): void
    {
        $this->touchFile('living-spaces.mp4');
        $this->writeManifest('{ this is not json');

        $this->assertAllUnavailable($this->normalize());
    }

    public function test_wrong_schema_value_is_ignored(): void
    {
        $this->touchFile('living-spaces.mp4');
        $this->writeManifest($this->manifestDoc($this->manifestChapter(), ['schema' => 'something.else/v9']));

        $this->assertAllUnavailable($this->normalize());
    }

    public function test_facility_provenance_with_ai_generated_method_ignores_manifest(): void
    {
        $this->touchFile('living-spaces.mp4');
        $this->writeManifest($this->manifestDoc($this->manifestChapter([
            'provenance' => ['type' => 'facility', 'method' => 'ai-generated'],
        ])));

        $this->assertAllUnavailable($this->normalize());
    }

    public function test_facility_provenance_with_stock_or_motion_graphics_is_rejected(): void
    {
        $this->touchFile('living-spaces.mp4');
        foreach (['stock', 'motion-graphics'] as $method) {
            $this->writeManifest($this->manifestDoc($this->manifestChapter([
                'provenance' => ['type' => 'facility', 'method' => $method],
            ])));
            $this->assertAllUnavailable($this->normalize());
        }
    }

    public function test_filmed_facility_footage_is_accepted(): void
    {
        $this->touchFile('living-spaces.mp4');
        $this->writeManifest($this->manifestDoc($this->manifestChapter([
            'provenance' => ['type' => 'facility', 'method' => 'filmed', 'label' => 'Filmed at Mission Villa'],
        ])));

        $media = $this->normalize()['chapters'][0]['media'];

        $this->assertTrue($media['available']);
        $this->assertSame('facility', $media['provenance']);
    }

    public function test_unsafe_file_names_in_manifest_are_rejected(): void
    {
        $this->touchFile('living-spaces.mp4');
        foreach (['../living-spaces.mp4', 'sub/living-spaces.mp4', '/etc/passwd.mp4', '/other/living-spaces.mp4', '/media/../x.mp4'] as $src) {
            $this->writeManifest($this->manifestDoc($this->manifestChapter(['video' => ['src' => $src]])));
            $this->assertAllUnavailable($this->normalize());
        }
    }

    public function test_cms_override_video_wins_over_manifest(): void
    {
        $this->touchFile('living-spaces.mp4');
        $this->touchFile('custom.mp4');
        $this->writeManifest($this->manifestDoc($this->manifestChapter()));

        $data = $this->shippedData();
        $data['chapters'][0]['media']['video_src'] = '/media/mission-villa/life-at-mission-villa/custom.mp4';
        $media = $this->normalize($data)['chapters'][0]['media'];

        $this->assertTrue($media['available']);
        $this->assertSame('/media/mission-villa/life-at-mission-villa/custom.mp4', $media['sources'][0]['src']);
        $this->assertCount(1, $media['sources']);
        $this->assertSame([], $media['captions']);
    }

    public function test_cms_override_pointing_at_missing_file_is_ignored(): void
    {
        $data = $this->shippedData();
        $data['chapters'][0]['media']['video_src'] = '/media/mission-villa/life-at-mission-villa/nope.mp4';

        $this->assertAllUnavailable($this->normalize($data));
    }

    public function test_manifest_illustrative_provenance_stays_illustrative(): void
    {
        $this->touchFile('living-spaces.mp4');
        $this->writeManifest($this->manifestDoc($this->manifestChapter([
            'provenance' => ['type' => 'illustrative', 'method' => 'filmed', 'label' => null],
        ])));

        $shipped = $this->shippedData();
        $media = $this->normalize()['chapters'][0]['media'];

        $this->assertSame('illustrative', $media['provenance']);
        $this->assertSame($shipped['labels']['illustrative_video'], $media['provenance_label']);
    }

    // 4. Homepage rendering

    public function test_homepage_renders_life_gallery_after_care_options(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $care = strpos($html, 'id="care-options"');
        $life = strpos($html, 'id="life-at-mission-villa"');
        $this->assertNotFalse($care);
        $this->assertNotFalse($life);
        $this->assertGreaterThan($care, $life);

        $this->assertStringContainsString('A Closer Look at', $html);
        $this->assertStringContainsString('<em>Life Here</em>', $html);
        $this->assertStringContainsString('role="tablist"', $html);
        $life = $this->lifeSection($html);
        $this->assertSame(3, preg_match_all('/role="tab"/', $life));
        $this->assertMatchesRegularExpression('/role="tab"[^>]*id="life-tab-living-spaces"[^>]*aria-selected="true"/s', $life);
        $this->assertSame(1, preg_match_all('/aria-selected="true"/', $life));
        $this->assertStringNotContainsString('autoplay', $life);
    }

    public function test_homepage_video_element_has_no_sources_when_no_films_exist(): void
    {
        if (glob(public_path('media/mission-villa/life-at-mission-villa/*.mp4'))) {
            $this->markTestSkipped('Real life-gallery films exist on disk.');
        }

        $life = $this->lifeSection($this->get('/')->assertOk()->getContent());

        $this->assertSame(1, preg_match_all('/<video\b/', $life));
        preg_match('#<video\b[^>]*>(.*?)</video>#s', $life, $m, PREG_OFFSET_CAPTURE);
        $this->assertStringContainsString('preload="none"', $life);
        $this->assertStringNotContainsString('<source', $m[1][0]);
        preg_match('#<video\b[^>]*>#s', $life, $open);
        $this->assertMatchesRegularExpression('/\bhidden\b/', $open[0]);
        $this->assertStringContainsString('preload="none"', $open[0]);
    }

    public function test_homepage_embeds_chapter_json_and_falls_back_for_unrouted_ctas(): void
    {
        $life = $this->lifeSection($this->get('/')->assertOk()->getContent());

        $this->assertSame(1, preg_match('#<script type="application/json" data-life-data>(.*?)</script>#s', $life, $m));
        $json = json_decode($m[1], true);
        $this->assertIsArray($json);
        $this->assertCount(3, $json['chapters']);

        // Floor-plan page is now built: chapter 0 links directly to /suites-and-floor-plans
        $this->assertStringContainsString('href="/suites-and-floor-plans"', $life);
        $this->assertStringContainsString('Explore Our Suites', $life);
    }

    private function lifeSection(string $html): string
    {
        $start = strpos($html, 'id="life-at-mission-villa"');
        $this->assertNotFalse($start);
        $end = strpos($html, '</section>', $start);

        return substr($html, $start, $end - $start);
    }

    // 5. InternalLink

    public function test_internal_link_availability(): void
    {
        $this->assertTrue(InternalLink::isAvailable('/'));
        $this->assertTrue(InternalLink::isAvailable('https://example.com'));
        $this->assertTrue(InternalLink::isAvailable('/suites-and-floor-plans'));
        $this->assertFalse(InternalLink::isAvailable('//evil'));
        $this->assertFalse(InternalLink::isAvailable('javascript:x'));
        $this->assertFalse(InternalLink::isAvailable('http://example.com'));
    }
}
