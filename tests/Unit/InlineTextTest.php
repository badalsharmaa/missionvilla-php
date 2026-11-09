<?php

namespace Tests\Unit;

use App\Content\InlineText;
use PHPUnit\Framework\TestCase;

class InlineTextTest extends TestCase
{
    public function test_only_em_and_strong_survive_without_attributes(): void
    {
        $dirty = 'Hi <strong class="x" onclick="evil()">bold</strong> <em style="color:red">it</em> <script>alert(1)</script><a href="#">link</a>';

        $this->assertSame('Hi <strong>bold</strong> <em>it</em> alert(1)link', InlineText::sanitize($dirty));
    }

    public function test_render_escapes_text_and_applies_component_classes(): void
    {
        $html = InlineText::render('A & B <strong>Legacies™</strong> "quote"', ['strong' => 'font-semibold text-white']);

        $this->assertSame('A &amp; B <strong class="font-semibold text-white">Legacies™</strong> &quot;quote&quot;', $html);
    }

    public function test_entities_are_not_double_escaped(): void
    {
        $this->assertSame('Memory &amp; Respite', InlineText::render('Memory &amp; Respite'));
    }
}
