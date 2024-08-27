<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php\Injections;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class PhpFunctionParametersInjectionTest extends TestCase
{
    public function test_highlight(): void
    {
        $input = <<<'TXT'
public function __construct(public readonly string $name) {
function __invoke(bool $force = false): Foo;
public function __invoke(bool $force = false, Foo $bar = new Foo()): void;
public function __construct(private Console $console) {}
public function __construct(public Console $console) {}
public function __construct(protected Console $console) {}
function ((Foo&Bar)|null $bar)) {}
function (Foo|false $bar)) {}
fn((Foo&Bar)|null $post, (Foo&Bar)|null $foo)) => $foo,
fn ((Foo&Bar)|null $post, (Foo&Bar)|null $foo)) => $foo,
public function show(Post $post, Baz $baz)): Response
public function show((Foo&Bar)|null $post, (Foo&Bar)|null $foo)): Response
public function show(Foo|Bar $post, Boo $boo)): Response
public function show(?Foo $post, Bar $bar)): Response
public function show(Post $post, Baz $baz)): Response
public function show((Foo&Bar)|null $post, (Foo&Bar)|null $foo)): Response
{
public function show(Foo|Bar $post, Boo $boo)): Response {
public function show(?Foo $post, Bar $bar)): Response;
public function show(?Foo $post, Bar $bar));
public function show(?Foo $post, Bar $bar)) {}
function(?Foo $post, Bar $bar)) {}
function (?Foo $post, Bar $bar)) {}

public function show(
    ?Foo $post, 
    Bar $bar
)): Response;

public function show(
    ?Foo $post, 
    Bar $bar
));

public function show(
    ?Foo $post, 
    Bar $bar
)) {}



fn (
    ?Foo $post, 
    Bar $bar
)) => $bar,

public function __construct(
    public string $username { set => strtolower($value); }
) {}
TXT;

        $expectedOutput = <<<'TXT'
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">__construct</span>(<span class="hl-injection"><span class="hl-keyword">public</span> <span class="hl-keyword">readonly</span> <span class="hl-type">string</span> <span class="hl-property">$name</span></span>) {
<span class="hl-keyword">function</span> <span class="hl-property">__invoke</span>(<span class="hl-injection"><span class="hl-type">bool</span> $force = <span class="hl-keyword">false</span></span>): <span class="hl-type">Foo</span>;
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">__invoke</span>(<span class="hl-injection"><span class="hl-type">bool</span> $force = <span class="hl-keyword">false</span>, <span class="hl-type">Foo</span> $bar = <span class="hl-keyword">new</span> <span class="hl-type">Foo</span>()</span>): <span class="hl-type">void</span>;
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">__construct</span>(<span class="hl-injection"><span class="hl-keyword">private</span> <span class="hl-type">Console</span> <span class="hl-property">$console</span></span>) {}
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">__construct</span>(<span class="hl-injection"><span class="hl-keyword">public</span> <span class="hl-type">Console</span> <span class="hl-property">$console</span></span>) {}
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">__construct</span>(<span class="hl-injection"><span class="hl-keyword">protected</span> <span class="hl-type">Console</span> <span class="hl-property">$console</span></span>) {}
<span class="hl-keyword">function</span> (<span class="hl-injection"><span class="hl-type">(Foo&amp;Bar)|null</span> $bar)</span>) {}
<span class="hl-keyword">function</span> (<span class="hl-injection"><span class="hl-type">Foo|false</span> $bar)</span>) {}
<span class="hl-keyword">fn</span>(<span class="hl-injection"><span class="hl-type">(Foo&amp;Bar)|null</span> $post, <span class="hl-type">(Foo&amp;Bar)|null</span> $foo)</span>) =&gt; <span class="hl-variable">$foo</span>,
<span class="hl-keyword">fn</span> (<span class="hl-injection"><span class="hl-type">(Foo&amp;Bar)|null</span> $post, <span class="hl-type">(Foo&amp;Bar)|null</span> $foo)</span>) =&gt; <span class="hl-variable">$foo</span>,
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection"><span class="hl-type">Post</span> $post, <span class="hl-type">Baz</span> $baz)</span>): <span class="hl-type">Response</span>
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection"><span class="hl-type">(Foo&amp;Bar)|null</span> $post, <span class="hl-type">(Foo&amp;Bar)|null</span> $foo)</span>): <span class="hl-type">Response</span>
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection"><span class="hl-type">Foo|Bar</span> $post, <span class="hl-type">Boo</span> $boo)</span>): <span class="hl-type">Response</span>
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection"><span class="hl-type">?Foo</span> $post, <span class="hl-type">Bar</span> $bar)</span>): <span class="hl-type">Response</span>
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection"><span class="hl-type">Post</span> $post, <span class="hl-type">Baz</span> $baz)</span>): <span class="hl-type">Response</span>
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection"><span class="hl-type">(Foo&amp;Bar)|null</span> $post, <span class="hl-type">(Foo&amp;Bar)|null</span> $foo)</span>): <span class="hl-type">Response</span>
{
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection"><span class="hl-type">Foo|Bar</span> $post, <span class="hl-type">Boo</span> $boo)</span>): <span class="hl-type">Response</span> {
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection"><span class="hl-type">?Foo</span> $post, <span class="hl-type">Bar</span> $bar)</span>): <span class="hl-type">Response</span>;
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection"><span class="hl-type">?Foo</span> $post, <span class="hl-type">Bar</span> $bar)</span>);
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection"><span class="hl-type">?Foo</span> $post, <span class="hl-type">Bar</span> $bar)</span>) {}
<span class="hl-keyword">function</span>(<span class="hl-injection"><span class="hl-type">?Foo</span> $post, <span class="hl-type">Bar</span> $bar)</span>) {}
<span class="hl-keyword">function</span> (<span class="hl-injection"><span class="hl-type">?Foo</span> $post, <span class="hl-type">Bar</span> $bar)</span>) {}

<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection">
    <span class="hl-type">?Foo</span> $post, 
    <span class="hl-type">Bar</span> $bar
)</span>): <span class="hl-type">Response</span>;

<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection">
    <span class="hl-type">?Foo</span> $post, 
    <span class="hl-type">Bar</span> $bar
)</span>);

<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection">
    <span class="hl-type">?Foo</span> $post, 
    <span class="hl-type">Bar</span> $bar
)</span>) {}



<span class="hl-keyword">fn</span> (<span class="hl-injection">
    <span class="hl-type">?Foo</span> $post, 
    <span class="hl-type">Bar</span> $bar
)</span>) =&gt; <span class="hl-variable">$bar</span>,

<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">__construct</span>(<span class="hl-injection">
    <span class="hl-keyword">public</span> <span class="hl-type">string</span> <span class="hl-property">$username</span> </span>{ <span class="hl-keyword">set</span> =&gt; <span class="hl-property">strtolower</span>(<span class="hl-variable">$value</span>); }
) {}
TXT;

        $highlighter = new Highlighter();

        $output = $highlighter->parse($input, 'php');

        $this->assertSame($expectedOutput, $output);
    }
}
