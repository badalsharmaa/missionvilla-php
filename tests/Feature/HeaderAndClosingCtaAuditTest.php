<?php

namespace Tests\Feature;

use Tests\TestCase;

class HeaderAndClosingCtaAuditTest extends TestCase
{
    private const LIGHT_PAGES = [
        '/gallery',
        '/about',
        '/for-families',
        '/financial-planning',
        '/resources',
        '/contact',
    ];

    private const DARK_PAGES = [
        '/',
        '/memory-care',
        '/respite-care',
        '/living-options',
        '/suites-and-floor-plans',
        '/life-at-mission-villa',
        '/services-and-amenities',
    ];

    public function test_light_hero_pages_use_solid_header_variant(): void
    {
        foreach (self::LIGHT_PAGES as $uri) {
            $response = $this->get($uri)->assertOk();
            $html = $response->getContent();

            $this->assertStringContainsString(
                '<header class="site-header" data-site-header data-variant="solid">',
                $html,
                "Page {$uri} must have data-variant=\"solid\" on site-header for high contrast against light hero."
            );
        }
    }

    public function test_all_light_pages_have_closing_cta_with_inline_inquiry_form(): void
    {
        foreach (self::LIGHT_PAGES as $uri) {
            $response = $this->get($uri)->assertOk();
            $html = $response->getContent();

            // Must render the closing visit CTA section (id="visit")
            $this->assertStringContainsString(
                'id="visit"',
                $html,
                "Page {$uri} must include the shared closing visit CTA component."
            );

            // Must contain the right-hand inline form (components/inquiry/form) per docx Section 4 & 10
            $this->assertStringContainsString(
                'data-inquiry-inline',
                $html,
                "Page {$uri} must contain the right-hand inline inquiry form in its closing CTA."
            );

            $this->assertStringContainsString(
                'data-instance="inline"',
                $html,
                "Page {$uri} must render an inline inquiry form instance."
            );
        }
    }

    public function test_dark_hero_pages_retain_overlay_header_variant(): void
    {
        foreach (self::DARK_PAGES as $uri) {
            $html = $this->get($uri)->assertOk()->getContent();
            $this->assertStringContainsString(
                'data-variant="overlay"',
                $html,
                "Page {$uri} must retain data-variant=\"overlay\" for full-bleed dark cinematic hero."
            );
        }
    }
}
