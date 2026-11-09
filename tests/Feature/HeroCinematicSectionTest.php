<?php

namespace Tests\Feature;

use App\Content\InvalidSectionData;
use App\Content\Sections\HeroCinematicSection;
use Tests\TestCase;

class HeroCinematicSectionTest extends TestCase
{
    private function homeHeroData(): array
    {
        $page = require base_path('content/pages/home.php');

        return $page['sections'][0]['data'];
    }

    public function test_shipped_homepage_content_is_valid(): void
    {
        $data = (new HeroCinematicSection)->normalize($this->homeHeroData());

        $this->assertCount(3, $data['slides']);
        $this->assertSame('where <em>your loved one</em>', $data['slides'][0]['line2']);
    }

    public function test_layout_requires_exactly_three_chapters(): void
    {
        $data = $this->homeHeroData();
        array_pop($data['slides']);

        $this->expectException(InvalidSectionData::class);
        (new HeroCinematicSection)->normalize($data);
    }

    public function test_every_image_must_declare_provenance(): void
    {
        $data = $this->homeHeroData();
        $data['slides'][1]['image']['provenance'] = 'real-looking';

        $this->expectException(InvalidSectionData::class);
        (new HeroCinematicSection)->normalize($data);
    }

    public function test_overlong_headline_is_rejected_to_protect_the_layout(): void
    {
        $data = $this->homeHeroData();
        $data['slides'][0]['line1'] = str_repeat('Long words ', 10);

        $this->expectException(InvalidSectionData::class);
        (new HeroCinematicSection)->normalize($data);
    }

    public function test_editor_markup_is_sanitized(): void
    {
        $data = $this->homeHeroData();
        $data['slides'][0]['body'] = 'Safe <strong onclick="x()">text</strong><script>alert(1)</script>';

        $normalized = (new HeroCinematicSection)->normalize($data);
        $client = HeroCinematicSection::clientSlides($normalized);

        $this->assertSame('Safe <strong>text</strong>alert(1)', $normalized['slides'][0]['body']);
        $this->assertSame('Safe <strong class="font-semibold text-white">text</strong>alert(1)', $client[0]['body']);
    }
}
