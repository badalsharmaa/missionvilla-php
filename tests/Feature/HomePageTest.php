<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_homepage_renders_header_and_approved_hero(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('data-site-header', false)
            ->assertSee('data-hero-cinematic', false)
            ->assertSee('A calm, trusted home')
            ->assertSee('where <em>your loved one</em>', false)
            ->assertSee('Mission Villa Care Guide')
            ->assertSee('Schedule a Visit')
            ->assertSee('(650) 756-1995')
            ->assertSee('CA RCFE License #415601046')
            ->assertSee('id="heroSlidesData"', false);
    }

    public function test_homepage_contains_no_unapproved_sections_or_placeholders(): void
    {
        $html = $this->get('/')->getContent();

        // Approved hero + its Care Guide dialog (a <section role="dialog">). Nothing else yet.
        $this->assertSame(2, substr_count($html, '<section'));
        $this->assertSame(1, substr_count($html, 'class="hero-viewport"'));
        $this->assertStringNotContainsStringIgnoringCase('coming soon', $html);
        $this->assertStringNotContainsString('devSafeZoneBanner', $html);
        $this->assertStringNotContainsString('onclick=', $html);
        $this->assertStringNotContainsString('images.pexels.com/photos', $html, 'Hero images must be served locally.');
    }

    public function test_security_headers_are_sent(): void
    {
        $this->get('/')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    public function test_seo_metadata_comes_from_page_content(): void
    {
        $this->get('/')
            ->assertSee('<title>Mission Villa Senior Living — Memory Care &amp; Respite Care in Daly City, CA</title>', false)
            ->assertSee('<meta name="description"', false)
            ->assertSee('<meta property="og:image"', false);
    }
}
