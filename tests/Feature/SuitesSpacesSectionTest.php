<?php

namespace Tests\Feature;

use App\Content\InvalidSectionData;
use App\Content\Sections\SuitesSpacesSection;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class SuitesSpacesSectionTest extends TestCase
{
    private function shippedData(): array
    {
        $page = require base_path('content/pages/home.php');

        return collect($page['sections'])->firstWhere('key', 'suites')['data'];
    }

    private function normalize(array $data): array
    {
        return (new SuitesSpacesSection)->normalize($data);
    }

    private function assertRejected(array $data): void
    {
        $this->expectException(InvalidSectionData::class);
        $this->normalize($data);
    }

    public function test_shipped_content_is_valid(): void
    {
        $data = $this->normalize($this->shippedData());

        $this->assertCount(3, $data['options']);
        $this->assertSame(['private', 'shared', 'community'], array_column($data['options'], 'id'));
        foreach ($data['options'] as $option) {
            $this->assertSame('facility', $option['image']['provenance']);
            $this->assertSame('unconfirmed', $option['image']['rights']);
            $this->assertFileExists(public_path(ltrim($option['image']['src'], '/')));
        }
        $this->assertSame('contain', $data['options'][1]['image']['fit']);
        $this->assertSame('cover', $data['options'][0]['image']['fit']);
    }

    public function test_floor_plan_action_falls_back_to_inquiry_while_page_is_unrouted(): void
    {
        $actions = $this->normalize($this->shippedData())['actions'];

        $this->assertCount(2, $actions);
        // Never a 404: the unrouted floor-plan page becomes an availability request (alias resolved).
        $this->assertSame('View Suite & Floor Plans', $actions[0]['label']);
        $this->assertSame('/suites-and-floor-plans', $actions[0]['href']);
        $this->assertNull($actions[0]['intent']);
        $this->assertSame('secondary', $actions[0]['style']);
        // The pricing action is always a form action.
        $this->assertSame('Request Availability & Pricing', $actions[1]['label']);
        $this->assertSame('request_pricing', $actions[1]['intent']);
        $this->assertSame('primary', $actions[1]['style']);
    }

    public function test_floor_plan_action_uses_real_page_once_routed(): void
    {
        Route::get('/suites-and-floor-plans', fn () => 'ok');
        app('router')->getRoutes()->refreshNameLookups();

        $action = $this->normalize($this->shippedData())['actions'][0];

        $this->assertSame('View Suite & Floor Plans', $action['label']);
        $this->assertSame('/suites-and-floor-plans', $action['href']);
        $this->assertNull($action['intent']);
    }

    public function test_panels_carry_no_paragraphs_or_ctas(): void
    {
        foreach ($this->normalize($this->shippedData())['options'] as $option) {
            $this->assertArrayNotHasKey('detail', $option);
            $this->assertArrayNotHasKey('cta', $option);
        }
    }

    public function test_rejects_unknown_action_intent(): void
    {
        $data = $this->shippedData();
        $data['actions'][1]['intent'] = 'subscribe';
        $this->assertRejected($data);
    }

    public function test_rejects_more_than_two_actions(): void
    {
        $data = $this->shippedData();
        $data['actions'][] = $data['actions'][1];
        $this->assertRejected($data);
    }

    public function test_rejects_wrong_option_count(): void
    {
        $data = $this->shippedData();
        $data['options'] = array_slice($data['options'], 0, 2);
        $this->assertRejected($data);
    }

    public function test_rejects_missing_provenance(): void
    {
        $data = $this->shippedData();
        unset($data['options'][0]['image']['provenance']);
        $this->assertRejected($data);
    }

    public function test_rejects_unknown_rights(): void
    {
        $data = $this->shippedData();
        $data['options'][0]['image']['rights'] = 'maybe';
        $this->assertRejected($data);
    }

    public function test_rejects_unknown_fit(): void
    {
        $data = $this->shippedData();
        $data['options'][0]['image']['fit'] = 'stretch';
        $this->assertRejected($data);
    }

    public function test_rejects_protocol_relative_image_src(): void
    {
        $data = $this->shippedData();
        $data['options'][0]['image']['src'] = '//cdn.example.test/a.webp';
        $this->assertRejected($data);
    }

    public function test_rejects_parent_traversal_in_image_src(): void
    {
        $data = $this->shippedData();
        $data['options'][0]['image']['src'] = '/images/../.env';
        $this->assertRejected($data);
    }

    public function test_rejects_javascript_cta_href(): void
    {
        $data = $this->shippedData();
        $data['actions'][0]['href'] = 'javascript:alert(1)';
        $this->assertRejected($data);
    }

    public function test_rejects_invalid_icon(): void
    {
        $data = $this->shippedData();
        $data['options'][0]['icon'] = 'skull';
        $this->assertRejected($data);
    }

    public function test_rejects_duplicate_ids(): void
    {
        $data = $this->shippedData();
        $data['options'][1]['id'] = 'private';
        $this->assertRejected($data);
    }

    public function test_heading_allows_only_em(): void
    {
        $data = $this->shippedData();
        $data['heading'] = '<script>x</script>Hi <em>there</em>';

        $heading = $this->normalize($data)['heading'];

        $this->assertStringNotContainsString('<script', $heading);
        $this->assertStringContainsString('<em>there</em>', $heading);
    }
}
