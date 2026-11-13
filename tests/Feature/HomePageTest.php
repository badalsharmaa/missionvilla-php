<?php

namespace Tests\Feature;

use App\Content\Contracts\ContentRepository;
use App\Content\PageDefinition;
use App\Content\SectionRegistry;
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

        // Hero + its Care Guide dialog (a <section role="dialog">) + Care Options + Life gallery + Why Families + Suites + FAQ + Visit CTA.
        $this->assertSame(8, substr_count($html, '<section'));
        $this->assertSame(1, substr_count($html, 'class="hero-viewport"'));
        $this->assertSame(1, substr_count($html, 'class="care-options"'));
        $this->assertSame(1, substr_count($html, 'class="life-gallery"'));
        $this->assertSame(1, substr_count($html, 'class="why-families"'));
        $this->assertSame(1, substr_count($html, 'class="suites-spaces"'));
        $this->assertSame(1, substr_count($html, 'class="faq-featured"'));
        $this->assertSame(1, substr_count($html, 'class="visit-cta"'));
        $this->assertSame(1, substr_count($html, '<footer class="site-footer"'));
        $this->assertSame(1, substr_count($html, 'id="inquiry-dialog"'));
        $this->assertStringNotContainsStringIgnoringCase('coming soon', $html);
        $this->assertStringNotContainsString('devSafeZoneBanner', $html);
        $this->assertStringNotContainsString('onclick=', $html);
        $this->assertStringNotContainsString('images.pexels.com/photos', $html, 'Hero images must be served locally.');
    }

    public function test_sections_render_in_approved_order(): void
    {
        $html = $this->get('/')->getContent();

        $positions = array_map(fn ($needle) => strpos($html, $needle), [
            'class="why-families"', 'class="suites-spaces"', 'class="faq-featured"', 'class="visit-cta"', '<footer class="site-footer"',
        ]);

        $this->assertNotContains(false, $positions);
        $sorted = $positions;
        sort($sorted);
        $this->assertSame($sorted, $positions);
    }

    public function test_opening_shutters_render_before_the_hero_and_can_be_skipped(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringContainsString('id="conservatory-shutters"', $html);
        $this->assertStringContainsString('“The honor they deserve,”', $html);
        $this->assertStringContainsString('“the care you’ll love.”', $html);
        $this->assertStringContainsString('id="skip-intro-btn"', $html);
        // Pre-paint gate honours reduced motion and ?skipIntro=1.
        $this->assertStringContainsString('prefers-reduced-motion: reduce', $html);
        $this->assertStringContainsString("q.get('skipIntro') === '1'", $html);
        $this->assertLessThan(strpos($html, 'data-hero-cinematic'), strpos($html, 'id="conservatory-shutters"'));
    }

    public function test_intro_can_be_disabled_through_content(): void
    {
        $this->app->instance(ContentRepository::class, new class implements ContentRepository
        {
            public function findPublishedPage(string $slug): ?PageDefinition
            {
                $raw = require base_path('content/pages/home.php');
                $raw['sections'][0]['enabled'] = false;
                $registry = app(SectionRegistry::class);

                return new PageDefinition($raw['slug'], $raw['seo'], array_map(fn ($s) => $registry->instantiate($s), $raw['sections']));
            }
        });

        $html = $this->get('/')->assertOk()->getContent();
        $this->assertStringNotContainsString('id="conservatory-shutters"', $html);
        $this->assertStringContainsString('data-hero-cinematic', $html);
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

    public function test_homepage_closing_cta_displays_honest_notice_and_no_false_promises(): void
    {
        $response = $this->get('/?skipIntro=1');

        $response->assertOk()
            ->assertSee('Submissions save locally while we finalize direct staff notifications.', false)
            ->assertSee('call us directly at (650) 756-1995', false)
            ->assertDontSee('our team will be in touch', false)
            ->assertDontSee('will reach out promptly', false);
    }
}
