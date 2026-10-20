<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Base;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

final class HighlightMarkersTest extends TestCase
{
    #[DataProvider('provide_markers_wrap_highlighted_code_cases')]
    public function test_markers_wrap_highlighted_code(string $language, string $content, string $expected): void
    {
        $this->assertSame(
            $expected,
            (new Highlighter())->parse($content, $language),
        );
    }

    public static function provide_markers_wrap_highlighted_code_cases(): iterable
    {
        return [
            'emphasize around a string with sql keywords (#148)' => [
                'php',
                '$foo = {_"SELECT * FROM users"_};',
                '<span class="hl-variable">$foo</span> = <span style="display: none">{_</span><span class="hl-em"><span class="hl-value">&quot;SELECT * FROM users&quot;</span></span><span style="display: none">_}</span>;',
            ],
            'strong around a string with sql keywords' => [
                'php',
                '$foo = {*"SELECT * FROM users"*};',
                '<span class="hl-variable">$foo</span> = <span style="display: none">{*</span><span class="hl-strong"><span class="hl-value">&quot;SELECT * FROM users&quot;</span></span><span style="display: none">*}</span>;',
            ],
            'blur around a string with sql keywords' => [
                'php',
                '$foo = {~"SELECT * FROM users"~};',
                '<span class="hl-variable">$foo</span> = <span style="display: none">{~</span><span class="hl-blur"><span class="hl-value">&quot;SELECT * FROM users&quot;</span></span><span style="display: none">~}</span>;',
            ],
            'custom class around a string with sql keywords' => [
                'php',
                '$foo = {:hl-x:"SELECT * FROM users":};',
                '<span class="hl-variable">$foo</span> = <span class="hl-x"><span class="hl-value">&quot;SELECT * FROM users&quot;</span></span>;',
            ],
            'emphasize around a whole line' => [
                'php',
                '{_$foo = "SELECT * FROM users";_}',
                '<span style="display: none">{_</span><span class="hl-em"><span class="hl-variable">$foo</span> = <span class="hl-value">&quot;SELECT * FROM users&quot;</span>;</span><span style="display: none">_}</span>',
            ],
            'emphasize inside a string' => [
                'php',
                '$foo = "Hello {_world_}";',
                '<span class="hl-variable">$foo</span> = <span class="hl-value">&quot;Hello <span style="display: none">{_</span><span class="hl-em">world</span><span style="display: none">_}</span>&quot;</span>;',
            ],
            'nested markers' => [
                'php',
                '{*{_"SELECT * FROM users"_}*}',
                '<span style="display: none">{*</span><span class="hl-strong"><span style="display: none">{_</span><span class="hl-em"><span class="hl-value">&quot;SELECT * FROM users&quot;</span></span><span style="display: none">_}</span></span><span style="display: none">*}</span>',
            ],
            'emphasize around a function with parameters' => [
                'php',
                '{_public function foo(string $bar): Baz {}_}',
                '<span style="display: none">{_</span><span class="hl-em"><span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">foo</span>(<span class="hl-injection"><span class="hl-type">string</span> $bar</span>): <span class="hl-type">Baz</span> {}</span><span style="display: none">_}</span>',
            ],
            'custom class around a function with parameters (#166)' => [
                'php',
                '{:hl-x:function ($test) {:}',
                '<span class="hl-x"><span class="hl-keyword">function</span> (<span class="hl-injection">$test</span>) {</span>',
            ],
            'custom class around a closed function with parameters (#166)' => [
                'php',
                '{:hl-x:function ($test) {}:}',
                '<span class="hl-x"><span class="hl-keyword">function</span> (<span class="hl-injection">$test</span>) {}</span>',
            ],
            'emphasize around html with css in an attribute' => [
                'html',
                '{_<div style="color: red">hi</div>_}',
                '<span style="display: none">{_</span><span class="hl-em">&lt;<span class="hl-keyword">div</span> <span class="hl-property">style</span>=&quot;<span class="hl-property">color</span>: red&quot;&gt;hi&lt;/<span class="hl-keyword">div</span>&gt;</span><span style="display: none">_}</span>',
            ],
            'emphasize inside an html attribute' => [
                'html',
                '<div style="{_color: red_}">hi</div>',
                '&lt;<span class="hl-keyword">div</span> <span class="hl-property">style</span>=&quot;<span style="display: none">{_</span><span class="hl-em"><span class="hl-property">color</span>: red</span><span style="display: none">_}</span>&quot;&gt;hi&lt;/<span class="hl-keyword">div</span>&gt;',
            ],
            'emphasize around blade' => [
                'blade',
                '{_{{ $foo }} @if($x) <b>y</b> @endif_}',
                '<span style="display: none">{_</span><span class="hl-em">{{ <span class="hl-variable">$foo</span> }} <span class="hl-keyword">@if</span>(<span class="hl-variable">$x</span>) &lt;<span class="hl-keyword">b</span>&gt;y&lt;/<span class="hl-keyword">b</span>&gt; <span class="hl-keyword">@endif</span></span><span style="display: none">_}</span>',
            ],
        ];
    }

    #[DataProvider('provide_wrapping_code_in_markers_does_not_change_its_highlighting_cases')]
    public function test_wrapping_code_in_markers_does_not_change_its_highlighting(string $language, string $content): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            '<span style="display: none">{_</span><span class="hl-em">'
            . $highlighter->parse($content, $language)
            . '</span><span style="display: none">_}</span>',
            $highlighter->parse('{_' . $content . '_}', $language),
        );
    }

    public static function provide_wrapping_code_in_markers_does_not_change_its_highlighting_cases(): iterable
    {
        return [
            ['php', '$foo = "SELECT * FROM users";'],
            ['php', 'public function foo(string $bar): Baz {}'],
            ['php', 'function ($test) {}'],
            ['html', '<div style="color: red">hi</div>'],
            ['blade', '{{ $foo }} @if($x) <b>y</b> @endif'],
            ['javascript', 'const f = (a) => `x ${a}`;'],
            ['css', '.a { color: red; }'],
            ['sql', 'SELECT * FROM users WHERE id = "x"'],
            ['python', 'query = "SELECT * FROM users"'],
        ];
    }

    public function test_markers_work_with_gutter(): void
    {
        $highlighter = (new Highlighter())->withGutter();

        $parsed = $highlighter->parse('{:hl-x:function ($test) {}:}', 'php');

        $this->assertStringContainsString('(<span class="hl-injection">$test</span>) {}', $parsed);
    }
}
