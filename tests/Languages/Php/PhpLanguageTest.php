<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class PhpLanguageTest extends TestCase
{
    #[DataProvider('data')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'php'),
        );
    }

    public static function data(): array
    {
        return [
            ["'php()'", "'<span class=\"hl-value\">php()</span>'"],
            ['$foo && $bar', '<span class="hl-variable">$foo</span> <span class="hl-operator">&amp;&amp;</span> <span class="hl-variable">$bar</span>'],
            ['$foo || $bar', '<span class="hl-variable">$foo</span> <span class="hl-operator">||</span> <span class="hl-variable">$bar</span>'],
            ['$foo <=> $bar', '<span class="hl-variable">$foo</span> <span class="hl-operator">&lt;=&gt;</span> <span class="hl-variable">$bar</span>'],
            ["public const string|\Stringable MESSAGE = 'hi';", '<span class="hl-keyword">public</span> <span class="hl-keyword">const</span> <span class="hl-type">string|\Stringable</span> <span class="hl-property">MESSAGE</span> = \'<span class="hl-value">hi</span>\';'],
            ["public string|\Stringable \$message;", '<span class="hl-keyword">public</span> <span class="hl-type">string|\<span class="hl-type">Stringable</span></span> <span class="hl-property">$message</span>;'],
            ['for($x = 0; $x < 150; $x++) {', '<span class="hl-keyword">for</span>(<span class="hl-variable">$x</span> = 0; <span class="hl-variable">$x</span> &lt; 150; <span class="hl-variable">$x</span>++) {'],
            ["'namespace ';", "'<span class=\"hl-value\">namespace </span>';"],
            ["static::foo()", '<span class="hl-keyword">static</span>::<span class="hl-property">foo</span>()'],
            ['$class', '<span class="hl-variable">$class</span>'],
            ['protected $resolved = [];', '<span class="hl-keyword">protected</span> <span class="hl-property">$resolved</span> = [];'],
            ['protected Foo $resolved = [];', '<span class="hl-keyword">protected</span> <span class="hl-type">Foo</span> <span class="hl-property">$resolved</span> = [];'],
            ['$concrete instanceof Closure', '<span class="hl-variable">$concrete</span> <span class="hl-keyword">instanceof</span> <span class="hl-type">Closure</span>'],
            ['extends Foo implements ArrayAccess, ContainerContract', '<span class="hl-keyword">extends</span> <span class="hl-type">Foo</span> <span class="hl-keyword">implements</span><span class="hl-type"> ArrayAccess, ContainerContract</span>'],
            ['$foo ? $value : null', '<span class="hl-variable">$foo</span> <span class="hl-operator">?</span> <span class="hl-variable">$value</span> : null'],
            ['use Illuminate\Contracts\Container\Container as ContainerContract', '<span class="hl-keyword">use</span> <span class="hl-type">Illuminate\Contracts\Container\Container</span> <span class="hl-keyword">as</span> <span class="hl-type">ContainerContract</span>'],
            ['$foo::class;', '<span class="hl-variable">$foo</span>::<span class="hl-keyword">class</span>;'],
            ['function ((Foo&Bar)|null $bar)', '<span class="hl-keyword">function</span> (<span class="hl-type">(Foo&amp;Bar)</span><span class="hl-type">|null</span> <span class="hl-variable">$bar</span>)'],
            ['fn&(', '<span class="hl-keyword">fn</span>&amp;('],
            [
                "// We'll

foo()

// We'll",
                '<span class="hl-comment">// We\'ll</span>

<span class="hl-property">foo</span>()

<span class="hl-comment">// We\'ll</span>',
            ],
        ];
    }
}
