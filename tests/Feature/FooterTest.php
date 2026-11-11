<?php

namespace Tests\Feature;

use App\Support\FooterNavigation;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class FooterTest extends TestCase
{
    public function test_footer_renders_brand_and_verified_facts(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertSame(1, substr_count($html, '<footer class="site-footer"'));
        $this->assertStringContainsString('/images/brand/mission-villa-logo-honor-560.webp', $html);
        $this->assertStringContainsString('width="560"', $html);
        $this->assertStringContainsString('height="417"', $html);
        $this->assertStringContainsString('href="tel:16507561995"', $html);
        $this->assertStringContainsString('California RCFE License #415601046', $html);
        $this->assertStringContainsString('© '.now()->year, $html);
        $this->assertStringContainsString(config('missionvilla.address.street'), $html);
    }

    public function test_footer_links_never_point_to_unrouted_pages(): void
    {
        $html = $this->get('/')->getContent();
        $footer = substr($html, strpos($html, '<footer class="site-footer"'));

        // /memory-care, /respite-care, /suites-and-floor-plans, /life-at-mission-villa, /gallery, /about, /for-families, and /financial-planning are now routed.
        $this->assertStringContainsString('href="'.url('/memory-care').'"', $footer);
        $this->assertStringContainsString('href="'.url('/respite-care').'"', $footer);
        $this->assertStringContainsString('href="'.url('/suites-and-floor-plans').'"', $footer);
        $this->assertStringContainsString('href="'.url('/life-at-mission-villa').'"', $footer);
        $this->assertStringContainsString('href="'.url('/gallery').'"', $footer);
        $this->assertStringContainsString('href="'.url('/about').'"', $footer);
        $this->assertStringContainsString('href="'.url('/for-families').'"', $footer);
        $this->assertStringContainsString('href="'.url('/financial-planning').'"', $footer);

        foreach (['/contact'] as $path) {
            $this->assertStringNotContainsString('href="'.url($path).'"', $footer, $path);
        }
        $this->assertStringContainsString('href="'.url('/#visit').'"', $footer);
        $this->assertStringNotContainsString('href="'.url('/#faq').'"', $footer);
        // Both Memory Care and Respite Care are routed, so the #care-options fallback is no longer rendered.
        $this->assertStringNotContainsString('href="'.url('/#care-options').'"', $footer);
        // /about is routed, so the #why-families fallback is no longer rendered.
        $this->assertStringNotContainsString('href="'.url('/#why-families').'"', $footer);
        $this->assertStringContainsString('For Families &amp; FAQs', $footer);
        $this->assertStringContainsString('Financial Planning', $footer);
    }

    public function test_privacy_and_terms_show_as_placeholders_until_pages_exist(): void
    {
        $html = $this->get('/')->getContent();
        $bar = substr($html, strpos($html, '<div class="sf__bar">'));

        $this->assertStringContainsString('<a href="#" class="sf__link">Privacy Policy</a>', $bar);
        $this->assertStringContainsString('<a href="#" class="sf__link">Terms of Use</a>', $bar);
        $this->assertStringNotContainsString('href="'.url('/privacy-policy').'"', $bar);
        // No placeholder configured: hidden until the page is routed.
        $this->assertStringNotContainsString('Accessibility Statement', $html);
    }

    public function test_unsafe_hrefs_are_dropped(): void
    {
        $links = FooterNavigation::links([
            ['label' => 'A', 'href' => 'javascript:alert(1)'],
            ['label' => 'B', 'href' => '//evil.test'],
            ['label' => 'C', 'href' => 'data:text/html,hi'],
            ['label' => 'D', 'href' => 'javascript:alert(1)', 'fallback' => '//evil.test'],
        ]);

        $this->assertSame([], $links);
    }

    public function test_unrouted_link_uses_fallback_and_fallback_label(): void
    {
        $links = FooterNavigation::links([
            ['label' => 'Real', 'href' => '/nope', 'fallback' => '/', 'fallback_label' => 'Home Fallback'],
            ['label' => 'Plain', 'href' => '/nope', 'fallback' => '/'],
            ['label' => 'Gone', 'href' => '/nope'],
        ]);

        $this->assertSame([
            ['label' => 'Home Fallback', 'href' => '/', 'pending' => true],
            ['label' => 'Plain', 'href' => '/', 'pending' => true],
        ], $links);
    }

    public function test_group_without_links_is_dropped(): void
    {
        $groups = FooterNavigation::groups([
            ['title' => 'Empty', 'links' => [['label' => 'X', 'href' => '/nope']]],
            ['title' => 'Kept', 'links' => [['label' => 'Home', 'href' => '/']]],
        ]);

        $this->assertCount(1, $groups);
        $this->assertSame('Kept', $groups[0]['title']);
    }

    public function test_routed_href_is_used_when_route_exists(): void
    {
        Route::get('/memory-care', fn () => 'ok');
        app('router')->getRoutes()->refreshNameLookups();

        $links = FooterNavigation::links([
            ['label' => 'Memory', 'href' => '/memory-care', 'fallback' => '/', 'fallback_label' => 'Fallback'],
        ]);

        $this->assertSame([['label' => 'Memory', 'href' => '/memory-care', 'pending' => false]], $links);
    }
}
