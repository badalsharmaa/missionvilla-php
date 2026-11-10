<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Brand rule: the header uses official logo artwork, never an HTML-text wordmark.
 * See .agents/skills/missionvilla-design-standard/references/brand-logo.md.
 */
class HeaderBrandTest extends TestCase
{
    private function header(): string
    {
        $html = $this->get('/')->assertOk()->getContent();
        $start = strpos($html, '<header class="site-header"');
        $this->assertNotFalse($start);

        return substr($html, $start, strpos($html, '</header>', $start) - $start);
    }

    public function test_header_uses_official_logo_artwork_not_text(): void
    {
        $header = $this->header();
        $brand = substr($header, 0, strpos($header, '<nav'));

        $this->assertStringContainsString('/images/brand/mission-villa-logo-header-light.webp', $brand);
        $this->assertStringContainsString('width="1046"', $brand);
        $this->assertStringContainsString('height="168"', $brand);
        $this->assertStringContainsString('aria-label="Mission Villa Senior Living — Home"', $brand);
        // The leaf-only fallback is the official mark, served through <picture>.
        $this->assertStringContainsString('/images/brand/mission-villa-mark-160.webp', $brand);

        // No recreated wordmark: the brand link has no visible text.
        $this->assertSame('', trim(strip_tags($brand)));
        $this->assertStringNotContainsString('site-header__name', $header);
        $this->assertStringNotContainsString('MISSION VILLA', $header);
    }

    public function test_logo_derivatives_exist_with_expected_dimensions(): void
    {
        foreach (['light', 'colour'] as $variant) {
            $path = public_path("images/brand/mission-villa-logo-header-{$variant}.webp");
            $this->assertFileExists($path);
            [$w, $h] = getimagesize($path);
            $this->assertSame([1046, 168], [$w, $h], $variant);
        }
        $this->assertFileExists(resource_path('brand/mission-villa-logo-honor.png'));
    }
}
