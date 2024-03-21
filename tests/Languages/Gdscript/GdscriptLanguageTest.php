<?php

declare(strict_types=1);

namespace Languages\Gdscript;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class GdscriptLanguageTest extends TestCase
{
    #[DataProvider('data')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'gdscript'),
        );
    }

    public static function data(): array
    {
        return [
            ['@onready', '<span class="hl-keyword">@onready</span>'],
            ['@export', '<span class="hl-keyword">@export</span>'],
            ['as int', '<span class="hl-keyword">as</span> <span class="hl-type">int</span>'],
            ['class_name Foo', '<span class="hl-keyword">class_name</span> <span class="hl-type">Foo</span>'],
            ['"foo"', '&quot;<span class="hl-value">foo</span>&quot;'],
            ['extends Foo', '<span class="hl-keyword">extends</span> <span class="hl-type">Foo</span>'],
            ['foo.bar()', 'foo.<span class="hl-property">bar</span>()'],
            ['bar()', '<span class="hl-property">bar</span>()'],
            ['bar(1)', '<span class="hl-property">bar</span>(1)'],
            ['func bar()', '<span class="hl-keyword">func</span> <span class="hl-property">bar</span>()'],
            ['foo += bar', 'foo <span class="hl-operator">+=</span> bar'],
            ['bar() -> void :', '<span class="hl-property">bar</span>() <span class="hl-operator">-&gt;</span> <span class="hl-type">void</span> :'],
            ['\'foo\'', '\'<span class="hl-value">foo</span>\''],
            ['# comment', '<span class="hl-comment"># comment</span>'],
            ['var foo : int', '<span class="hl-keyword">var</span> foo : <span class="hl-type">int</span>'],
            ['var foo : int = 1', '<span class="hl-keyword">var</span> foo : <span class="hl-type">int</span> = 1'],
        ];
    }
}
