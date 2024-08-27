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
            ["#[PatternTest(input: 'new Foo()', output: 'Foo')]", '<span class="hl-injection"><span class="hl-attribute">#[<span class="hl-type">PatternTest</span>(<span class="hl-property">input</span>: \'<span class="hl-value">new Foo()</span>\', <span class="hl-property">output</span>: \'<span class="hl-value">Foo</span>\')]</span></span>'],
            ['$foo && $bar', '<span class="hl-variable">$foo</span> <span class="hl-operator">&amp;&amp;</span> <span class="hl-variable">$bar</span>'],
            ['$foo || $bar', '<span class="hl-variable">$foo</span> <span class="hl-operator">||</span> <span class="hl-variable">$bar</span>'],
            ['$foo <=> $bar', '<span class="hl-variable">$foo</span> <span class="hl-operator">&lt;=&gt;</span> <span class="hl-variable">$bar</span>'],
            ["public const string|\Stringable MESSAGE = 'hi';", '<span class="hl-keyword">public</span> <span class="hl-keyword">const</span> <span class="hl-type">string|\Stringable</span> <span class="hl-property">MESSAGE</span> = \'<span class="hl-value">hi</span>\';'],
            ["public string|\Stringable \$message;", '<span class="hl-keyword">public</span> <span class="hl-type">string|\Stringable</span> <span class="hl-property">$message</span>;'],
            ['for($x = 0; $x < 150; $x++) {', '<span class="hl-keyword">for</span>(<span class="hl-variable">$x</span> = 0; <span class="hl-variable">$x</span> &lt; 150; <span class="hl-variable">$x</span>++) {'],
            ["'namespace ';", "'<span class=\"hl-value\">namespace </span>';"],
            ["static::foo()", '<span class="hl-keyword">static</span>::<span class="hl-property">foo</span>()'],
            ['$class', '<span class="hl-variable">$class</span>'],
            ['protected $resolved = [];', '<span class="hl-keyword">protected</span> <span class="hl-property">$resolved</span> = [];'],
            ['protected Foo $resolved = [];', '<span class="hl-keyword">protected</span> <span class="hl-type">Foo</span> <span class="hl-property">$resolved</span> = [];'],
            ['$concrete instanceof Closure', '<span class="hl-variable">$concrete</span> <span class="hl-keyword">instanceof</span> <span class="hl-type">Closure</span>'],
            ['extends Foo implements ArrayAccess, ContainerContract', '<span class="hl-keyword">extends</span> <span class="hl-type">Foo</span> <span class="hl-keyword">implements</span><span class="hl-type"> ArrayAccess, ContainerContract</span>'],
            ['$foo ? $value : null', '<span class="hl-variable">$foo</span> <span class="hl-operator">?</span> <span class="hl-variable">$value</span> : <span class="hl-keyword">null</span>'],
            ['use Illuminate\Contracts\Container\Container as ContainerContract', '<span class="hl-keyword">use</span> <span class="hl-type">Illuminate\Contracts\Container\Container</span> <span class="hl-keyword">as</span> <span class="hl-type">ContainerContract</span>'],
            ['$foo::class;', '<span class="hl-variable">$foo</span>::<span class="hl-keyword">class</span>;'],
            ['function ((Foo&Bar)|null $bar) {}', '<span class="hl-keyword">function</span> (<span class="hl-injection"><span class="hl-type">(Foo&amp;Bar)|null</span> $bar</span>) {}'],
            ['function (Foo|false $bar) {}', '<span class="hl-keyword">function</span> (<span class="hl-injection"><span class="hl-type">Foo|false</span> $bar</span>) {}'],
            ['function (Foo|true $bar) {}', '<span class="hl-keyword">function</span> (<span class="hl-injection"><span class="hl-type">Foo|true</span> $bar</span>) {}'],
            ['while (true) {', '<span class="hl-keyword">while</span> (<span class="hl-keyword">true</span>) {'],
            ['catch (Foo|Bar) {}', '<span class="hl-keyword">catch</span> (<span class="hl-type">Foo|Bar</span>) {}'],
            ['fn&(', '<span class="hl-keyword">fn</span>&amp;('],
            ['enum Foo: string', '<span class="hl-keyword">enum</span> <span class="hl-type">Foo</span>: <span class="hl-type">string</span>'],
            ['case Foo;', '<span class="hl-keyword">case</span> <span class="hl-property">Foo</span>;'],
            ['$this->extends("View/base.view.php");', '<span class="hl-variable">$this</span>-&gt;<span class="hl-property">extends</span>(&quot;<span class="hl-value">View/base.view.php</span>&quot;);'],
            ['$foo = null;', '<span class="hl-variable">$foo</span> = <span class="hl-keyword">null</span>;'],
            ['$foo = true;', '<span class="hl-variable">$foo</span> = <span class="hl-keyword">true</span>;'],
            ['$foo = false;', '<span class="hl-variable">$foo</span> = <span class="hl-keyword">false</span>;'],
            ['/** @var Foo $var */', '<span class="hl-comment">/** <span class="hl-value">@var</span> <span class="hl-type">Foo</span> <span class="hl-variable">$var</span> */</span>'],
            ['{~}): Foo {}~}', '<span style="display: none">{~</span><span class="hl-blur">}): <span class="hl-type">Foo</span> {}</span><span style="display: none">~}</span>'],
            ['{~class~} Foo {}', '<span style="display: none">{~</span><span class="hl-blur">class</span><span style="display: none">~}</span> Foo {}'],
            ['#[ConsoleCommand()]', '<span class="hl-injection"><span class="hl-attribute">#[<span class="hl-type">ConsoleCommand</span>()]</span></span>'],
            ['#[ConsoleCommand]', '<span class="hl-attribute">#[<span class="hl-type">ConsoleCommand</span>]</span>'],
            ['#[ConsoleCommand(foo: [])]', '<span class="hl-injection"><span class="hl-attribute">#[<span class="hl-type">ConsoleCommand</span>(<span class="hl-property">foo</span>: [])]</span></span>'],
            [
                'public string $fullName {
                    get => $this->first . " " . $this->last;
                    set (string $value) => $this->first . " " . $this->last;
                }',
                '<span class="hl-keyword">public</span> <span class="hl-type">string</span> <span class="hl-property">$fullName</span> {
                    <span class="hl-keyword">get</span> =&gt; <span class="hl-variable">$this</span>-&gt;<span class="hl-property">first</span> . &quot;<span class="hl-value"> </span>&quot; . <span class="hl-variable">$this</span>-&gt;<span class="hl-property">last</span>;
                    <span class="hl-keyword">set</span> (<span class="hl-type">string</span> <span class="hl-variable">$value</span>) =&gt; <span class="hl-variable">$this</span>-&gt;<span class="hl-property">first</span> . &quot;<span class="hl-value"> </span>&quot; . <span class="hl-variable">$this</span>-&gt;<span class="hl-property">last</span>;
                }',
            ],
            [
                <<<'TXT'
#[ConsoleCommand]
public function info(
    #[ConsoleArgument(
        description: 'The name of the package',
        help: 'Extended help text for this argument',
        aliases: ['n'],
    )]
    string $name
): void {}
TXT,
                <<<'TXT'
<span class="hl-attribute">#[<span class="hl-type">ConsoleCommand</span>]</span>
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">info</span>(<span class="hl-injection">
    </span><span class="hl-injection"><span class="hl-attribute">#[<span class="hl-type">ConsoleArgument</span>(
        <span class="hl-property">description</span>: '<span class="hl-value"><span class="hl-value">The name of the package</span></span>',
        <span class="hl-property">help</span>: '<span class="hl-value"><span class="hl-value">Extended help text for this argument</span></span>',
        <span class="hl-property">aliases</span>: ['<span class="hl-value"><span class="hl-value">n</span></span>'],
    )]</span></span><span class="hl-injection">
    <span class="hl-type">string</span> $name
</span>): <span class="hl-type">void</span> {}
TXT
            ],
            [
                "// We'll

foo()

// We'll",
                '<span class="hl-comment">// We\'ll</span>

<span class="hl-property">foo</span>()

<span class="hl-comment">// We\'ll</span>',
            ],
            ['use function Tempest\Foo\redirect;', '<span class="hl-keyword">use</span> <span class="hl-keyword">function</span> <span class="hl-type">Tempest\Foo\</span><span class="hl-property">redirect</span>;'],
            ['default: true,', '<span class="hl-property">default</span>: <span class="hl-keyword">true</span>,'],
            ['new MyClass()::CONSTANT;', '<span class="hl-keyword">new</span> <span class="hl-type">MyClass</span>()::<span class="hl-property">CONSTANT</span>;'],
            ['new MyClass()::$staticProperty;', '<span class="hl-keyword">new</span> <span class="hl-type">MyClass</span>()::<span class="hl-property">$staticProperty</span>;'],
            ['/** @return K */', '<span class="hl-comment">/** <span class="hl-value">@return</span> <span class="hl-type">K </span>*/</span>'],
            ['public function __construct(
    #[Lazy] public Author $author,
) {}', '<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">__construct</span>(<span class="hl-injection">
    <span class="hl-attribute">#[<span class="hl-type">Lazy</span>]</span> <span class="hl-keyword">public</span> <span class="hl-type">Author</span> <span class="hl-property">$author</span>,
</span>) {}'],
            ['    public function __construct(
        // Allow a union on a special "missing relation" type:
        public Relation|Author $author,

        // Making the relation nullable would be an option as well:
        /** @var Chapter[] $chapters */
        /**
         * hello */
        public ?array $chapters,
    ) {}', '    <span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">__construct</span>(<span class="hl-injection">
        <span class="hl-comment">// Allow a union on a special &quot;missing relation&quot; type:</span>
        <span class="hl-keyword">public</span> <span class="hl-type">Relation|Author</span> <span class="hl-property">$author</span>,

        <span class="hl-comment">// Making the relation nullable would be an option as well:</span>
        <span class="hl-comment">/** <span class="hl-value"><span class="hl-value">@var</span></span> <span class="hl-type">Chapter[]</span> <span class="hl-variable"><span class="hl-variable">$chapters</span></span> */</span>
        <span class="hl-comment">/**
         * hello */</span>
        <span class="hl-keyword">public</span> <span class="hl-type">?array</span> <span class="hl-property">$chapters</span>,
    </span>) {}'],
            ['public static function new(mixed ...$params): self;', '<span class="hl-keyword">public</span> <span class="hl-keyword">static</span> <span class="hl-keyword">function</span> <span class="hl-property">new</span>(<span class="hl-injection"><span class="hl-type">mixed</span> ...$params</span>): <span class="hl-type">self</span>;'],
        ];
    }
}
