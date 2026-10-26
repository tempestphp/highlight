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
            'emphasize inside an identifier' => [
                'php',
                'pre{_class_}post',
                'pre<span style="display: none">{_</span><span class="hl-em">class</span><span style="display: none">_}</span>post',
            ],
            'emphasize at the start of an identifier' => [
                'php',
                '{_pre_}class',
                '<span style="display: none">{_</span><span class="hl-em">pre</span><span style="display: none">_}</span>class',
            ],
            'custom class next to an injection' => [
                'php',
                '{:hl-x:function:} ($test) {}',
                '<span class="hl-x"><span class="hl-keyword">function</span></span> (<span class="hl-injection">$test</span>) {}',
            ],
            'emphasize in a tag next to an embedded script' => [
                'vue',
                '<script lang="ts" id="{_demo_}">const x = 1;</script>',
                '&lt;<span class="hl-keyword">script</span> <span class="hl-property">lang</span>=&quot;ts&quot; <span class="hl-property">id</span>=&quot;<span style="display: none">{_</span><span class="hl-em">demo</span><span style="display: none">_}</span>&quot;&gt;<span class="hl-keyword">const</span> <span class="hl-property">x</span> = 1;&lt;/<span class="hl-keyword">script</span>&gt;',
            ],
            'custom class inside an embedded language' => [
                'html',
                '<div style="color: {:hl-x:red:}">hi</div>',
                '&lt;<span class="hl-keyword">div</span> <span class="hl-property">style</span>=&quot;<span class="hl-property">color</span>: <span class="hl-x">red</span>&quot;&gt;hi&lt;/<span class="hl-keyword">div</span>&gt;',
            ],
            'custom class around several tokens of an embedded language' => [
                'html',
                '<div style="{:hl-x:color: red:}">hi</div>',
                '&lt;<span class="hl-keyword">div</span> <span class="hl-property">style</span>=&quot;<span class="hl-x"><span class="hl-property">color</span>: red</span>&quot;&gt;hi&lt;/<span class="hl-keyword">div</span>&gt;',
            ],
            'custom classes inside function parameters' => [
                'php',
                'function foo({:hl-x:$a:}, {:hl-y:$b:}) {}',
                '<span class="hl-keyword">function</span> <span class="hl-property">foo</span>(<span class="hl-injection"><span class="hl-x">$a</span>, <span class="hl-y">$b</span></span>) {}',
            ],
            'custom class around function parameters' => [
                'php',
                'function foo({:hl-x:string $bar:}) {}',
                '<span class="hl-keyword">function</span> <span class="hl-property">foo</span>(<span class="hl-x"><span class="hl-injection"><span class="hl-type">string</span> $bar</span></span>) {}',
            ],
            'marker pair split by an embedded language' => [
                'blade',
                '{~Welcome, {{~} $user->name }}',
                '<span style="display: none">{~</span><span class="hl-blur">Welcome, {{</span><span style="display: none">~}</span> <span class="hl-variable">$user</span>-&gt;<span class="hl-property">name</span> }}',
            ],
            'custom class starting inside an embedded language' => [
                'svelte',
                'let { initial, onchan{:hl-x:ge }: { initi:}al } = $props();',
                'let { initial, onchan<span class="hl-x">ge }: { initi</span>al } = $props();',
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

    #[DataProvider('provide_marker_delimiters_in_ordinary_code_are_not_markers_cases')]
    public function test_marker_delimiters_in_ordinary_code_are_not_markers(string $language, string $content): void
    {
        $parsed = (new Highlighter())->parse($content, $language);

        $this->assertStringNotContainsString('display: none', $parsed);
        $this->assertStringNotContainsString('hl-em', $parsed);
        $this->assertStringNotContainsString('hl-strong', $parsed);
        $this->assertStringNotContainsString('hl-blur', $parsed);
    }

    public static function provide_marker_delimiters_in_ordinary_code_are_not_markers_cases(): iterable
    {
        return [
            'javascript destructuring (#240)' => ['javascript', 'const {_id} = a; const {name_} = b;'],
            'python dicts (#240)' => ['python', "a = {_: 1}\nb = {1: _}"],
            'php braces' => ['php', '$a = "{_id}" . $b . "{name_}";'],
            'strong' => ['javascript', 'f({*a}, {b*});'],
            'blur' => ['javascript', 'f({~a}, {b~});'],
        ];
    }

    public function test_marker_after_ordinary_code_delimiter_still_works(): void
    {
        $this->assertSame(
            '<span class="hl-keyword">const</span> {_id} = a; <span style="display: none">{_</span><span class="hl-em">b</span><span style="display: none">_}</span>;',
            (new Highlighter())->parse('const {_id} = a; {_b_};', 'javascript'),
        );
    }

    #[DataProvider('provide_markers_around_unbalanced_braces_cases')]
    public function test_markers_around_unbalanced_braces(string $content, string $classname): void
    {
        $parsed = (new Highlighter())->parse($content, 'php');

        $this->assertStringContainsString('<span class="' . $classname . '">', $parsed);
        $visible = strip_tags(preg_replace('/<span style="display: none">.*?<\/span>/', '', $parsed));

        $this->assertDoesNotMatchRegularExpression('/{[_*~]|[_*~]}/', $visible);
    }

    public static function provide_markers_around_unbalanced_braces_cases(): iterable
    {
        return [
            'opening brace' => ["{_function foo() {_}\n    return 1;\n}", 'hl-em'],
            'closing brace' => ["function foo() {\n{_    return 1;\n}_}", 'hl-em'],
            'closing then balanced braces' => ['{_}): Foo {}_}', 'hl-em'],
            'else' => ["if (\$x) {\n{_} else {_}\n}", 'hl-em'],
            'end of a block and else' => ["if (\$x) {\n{_    return 1;\n} else {_}\n}", 'hl-em'],
            'catch' => ["try {\n    a();\n{*} catch (E \$e) {*}\n}", 'hl-strong'],
            'finally' => ["try {\n    a();\n{~} finally {~}\n}", 'hl-blur'],
        ];
    }

    public function test_markers_work_with_gutter(): void
    {
        $highlighter = (new Highlighter())->withGutter();

        $parsed = $highlighter->parse('{:hl-x:function ($test) {}:}', 'php');

        $this->assertStringContainsString('(<span class="hl-injection">$test</span>) {}', $parsed);
    }
}
