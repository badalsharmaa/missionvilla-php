<?php

namespace Tests\Feature;

use App\Content\InvalidSectionData;
use App\Content\Sections\CareOptionsSection;
use Tests\TestCase;

class CareOptionsSectionTest extends TestCase
{
    private function shippedData(): array
    {
        $page = require base_path('content/pages/home.php');

        return collect($page['sections'])->firstWhere('key', 'care-options')['data'];
    }

    private function assertRejected(array $data): void
    {
        $this->expectException(InvalidSectionData::class);
        (new CareOptionsSection)->normalize($data);
    }

    public function test_shipped_homepage_content_is_valid(): void
    {
        $data = (new CareOptionsSection)->normalize($this->shippedData());

        $this->assertSame('Two Paths. <em>One Commitment to Care.</em>', $data['heading']);
        $this->assertCount(2, $data['cards']);
        $this->assertSame(['memory-care', 'respite-care'], array_column($data['cards'], 'id'));
        foreach ($data['cards'] as $card) {
            $this->assertCount(3, $card['back']['benefits']);
            $this->assertFileExists(public_path(ltrim($card['image']['src'], '/')));
            $this->assertFileExists(public_path(ltrim($card['image']['src_mobile'], '/')));
        }
    }

    public function test_layout_requires_exactly_two_cards(): void
    {
        $data = $this->shippedData();
        array_pop($data['cards']);

        $this->assertRejected($data);
    }

    public function test_back_face_requires_exactly_three_benefits(): void
    {
        $data = $this->shippedData();
        $data['cards'][0]['back']['benefits'][] = ['icon' => 'heart', 'text' => 'A fourth benefit'];

        $this->assertRejected($data);
    }

    public function test_every_image_must_declare_provenance(): void
    {
        $data = $this->shippedData();
        $data['cards'][1]['image']['provenance'] = 'probably-real';

        $this->assertRejected($data);
    }

    public function test_overlong_copy_is_rejected_to_protect_the_layout(): void
    {
        $data = $this->shippedData();
        $data['cards'][0]['back']['statement'] = str_repeat('Long words ', 20);

        $this->assertRejected($data);
    }

    public function test_unknown_icons_are_rejected(): void
    {
        $data = $this->shippedData();
        $data['cards'][0]['icon'] = 'skull';

        $this->assertRejected($data);
    }

    public function test_unsafe_link_schemes_are_rejected(): void
    {
        foreach (['javascript:alert(1)', '//evil.example', 'data:text/html,x', 'http://insecure.example'] as $href) {
            $data = $this->shippedData();
            $data['cards'][0]['cta']['href'] = $href;

            try {
                (new CareOptionsSection)->normalize($data);
                $this->fail("Accepted unsafe href [{$href}]");
            } catch (InvalidSectionData) {
                $this->addToAssertionCount(1);
            }
        }
    }

    public function test_editor_markup_is_sanitized(): void
    {
        $data = $this->shippedData();
        $data['heading'] = 'Two <em onclick="x()">Paths</em><script>alert(1)</script>';
        $data['cards'][0]['summary'] = 'Plain <strong>only</strong> text';

        $normalized = (new CareOptionsSection)->normalize($data);

        $this->assertSame('Two <em>Paths</em>alert(1)', $normalized['heading']);
        $this->assertSame('Plain only text', $normalized['cards'][0]['summary']);
    }

    public function test_section_renders_after_the_hero_with_accessible_flip_controls(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringContainsString('id="care-options"', $html);
        $this->assertLessThan(strpos($html, 'id="care-options"'), strpos($html, 'data-hero-cinematic'));
        $this->assertStringContainsString('Two Paths. <em>One Commitment to Care.</em>', $html);

        // Two cards, each with a keyboard toggle wired to its back face, which starts inert.
        $this->assertSame(2, substr_count($html, 'data-care-card'));
        $this->assertSame(2, substr_count($html, 'data-care-toggle'));
        $this->assertStringContainsString('aria-controls="care-memory-care-back"', $html);
        $this->assertStringContainsString('aria-controls="care-respite-care-back"', $html);
        $this->assertSame(2, substr_count($html, 'data-face="back" inert'));

        // Back-face copy and shared actions.
        $this->assertStringContainsString('Legacies™ Memory Care', $html);
        $this->assertStringContainsString('Who this supports', $html);
        $this->assertStringContainsString('data-care-visit', $html);
        $this->assertStringContainsString('data-hero-action="open-care-chat"', $html);

        // Leaf shadows use the botanical SVG, not a flattened screenshot.
        $this->assertStringContainsString('images/decor/botanical-leaf-shadow.svg', $html);
        $this->assertFileExists(public_path('images/decor/botanical-leaf-shadow.svg'));
    }

    public function test_care_options_ship_no_scroll_driven_motion(): void
    {
        $js = file_get_contents(resource_path('js/sections/care-options.js'));
        $css = file_get_contents(resource_path('css/sections/care-options.css'));

        foreach (['ScrollTrigger', 'IntersectionObserver', "addEventListener('scroll'", 'gsap'] as $forbidden) {
            $this->assertStringNotContainsString($forbidden, $js);
        }
        $this->assertStringNotContainsString('animation-timeline', $css);
        $this->assertStringNotContainsString('@keyframes', $css);
    }
}
