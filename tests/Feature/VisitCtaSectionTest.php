<?php

namespace Tests\Feature;

use App\Content\InvalidSectionData;
use App\Content\Sections\VisitCtaSection;
use Tests\TestCase;

class VisitCtaSectionTest extends TestCase
{
    private function shippedData(): array
    {
        $page = require base_path('content/pages/home.php');

        return collect($page['sections'])->firstWhere('key', 'visit')['data'];
    }

    private function normalize(array $data): array
    {
        return (new VisitCtaSection)->normalize($data);
    }

    private function assertRejectedActions(array $actions): void
    {
        $data = ['actions' => $actions] + $this->shippedData();
        $this->expectException(InvalidSectionData::class);
        $this->normalize($data);
    }

    public function test_shipped_content_is_valid(): void
    {
        $actions = $this->normalize($this->shippedData())['actions'];

        $this->assertCount(3, $actions);
        $this->assertSame(['schedule_visit', 'request_pricing', 'request_callback'], array_column($actions, 'intent'));
        $this->assertSame([true, false, false], array_column($actions, 'primary'));
    }

    public function test_duplicate_intent_is_rejected(): void
    {
        $this->assertRejectedActions([
            ['intent' => 'schedule_visit', 'label' => 'A', 'icon' => 'calendar'],
            ['intent' => 'schedule_visit', 'label' => 'B', 'icon' => 'phone'],
        ]);
    }

    public function test_unknown_intent_is_rejected(): void
    {
        $this->assertRejectedActions([['intent' => 'buy_now', 'label' => 'A', 'icon' => 'calendar']]);
    }

    public function test_four_actions_are_rejected(): void
    {
        $this->assertRejectedActions([
            ['intent' => 'schedule_visit', 'label' => 'A', 'icon' => 'calendar'],
            ['intent' => 'request_pricing', 'label' => 'B', 'icon' => 'file-text'],
            ['intent' => 'request_callback', 'label' => 'C', 'icon' => 'phone'],
            ['intent' => 'request_callback', 'label' => 'D', 'icon' => 'phone'],
        ]);
    }
}
