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
TXT;

        $expectedOutput = <<<'TXT'
<span class="hl-keyword">function</span> (<span class="hl-injection"><span class="hl-type">(Foo&amp;Bar)|null</span> $bar)</span>)) {}
<span class="hl-keyword">function</span> (<span class="hl-injection"><span class="hl-type">Foo|false</span> $bar)</span>)) {}
<span class="hl-keyword">fn</span>(<span class="hl-injection"><span class="hl-type">(Foo&amp;Bar)|null</span> $post, <span class="hl-type">(Foo&amp;Bar)|null</span> $foo)</span>)) =&gt; <span class="hl-variable">$foo</span>,
<span class="hl-keyword">fn</span> (<span class="hl-injection"><span class="hl-type">(Foo&amp;Bar)|null</span> $post, <span class="hl-type">(Foo&amp;Bar)|null</span> $foo)</span>)) =&gt; <span class="hl-variable">$foo</span>,
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection"><span class="hl-type">Post</span> $post, <span class="hl-type">Baz</span> $baz)</span>)): <span class="hl-type">Response</span>
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection"><span class="hl-type">(Foo&amp;Bar)|null</span> $post, <span class="hl-type">(Foo&amp;Bar)|null</span> $foo)</span>)): <span class="hl-type">Response</span>
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection"><span class="hl-type">Foo|Bar</span> $post, <span class="hl-type">Boo</span> $boo)</span>)): <span class="hl-type">Response</span>
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection"><span class="hl-type">?Foo</span> $post, <span class="hl-type">Bar</span> $bar)</span>)): <span class="hl-type">Response</span>
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection"><span class="hl-type">Post</span> $post, <span class="hl-type">Baz</span> $baz)</span>)): <span class="hl-type">Response</span>
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection"><span class="hl-type">(Foo&amp;Bar)|null</span> $post, <span class="hl-type">(Foo&amp;Bar)|null</span> $foo)</span>)): <span class="hl-type">Response</span>
{
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection"><span class="hl-type">Foo|Bar</span> $post, <span class="hl-type">Boo</span> $boo)</span>)): <span class="hl-type">Response</span> {
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection"><span class="hl-type">?Foo</span> $post, <span class="hl-type">Bar</span> $bar)</span>)): <span class="hl-type">Response</span>;
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection"><span class="hl-type">?Foo</span> $post, <span class="hl-type">Bar</span> $bar)</span>));
<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection"><span class="hl-type">?Foo</span> $post, <span class="hl-type">Bar</span> $bar)</span>)) {}
<span class="hl-keyword">function</span>(<span class="hl-injection"><span class="hl-type">?Foo</span> $post, <span class="hl-type">Bar</span> $bar)</span>)) {}
<span class="hl-keyword">function</span> (<span class="hl-injection"><span class="hl-type">?Foo</span> $post, <span class="hl-type">Bar</span> $bar)</span>)) {}

<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection">
    <span class="hl-type">?Foo</span> $post, 
    <span class="hl-type">Bar</span> $bar
)</span>)): <span class="hl-type">Response</span>;

<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection">
    <span class="hl-type">?Foo</span> $post, 
    <span class="hl-type">Bar</span> $bar
)</span>));

<span class="hl-keyword">public</span> <span class="hl-keyword">function</span> <span class="hl-property">show</span>(<span class="hl-injection">
    <span class="hl-type">?Foo</span> $post, 
    <span class="hl-type">Bar</span> $bar
)</span>)) {}



<span class="hl-keyword">fn</span> (<span class="hl-injection">
    <span class="hl-type">?Foo</span> $post, 
    <span class="hl-type">Bar</span> $bar
)</span>)) =&gt; <span class="hl-variable">$bar</span>,
TXT;

        $highlighter = new Highlighter();

        $output = $highlighter->parse($input, 'php');

        $this->assertSame($expectedOutput, $output);
    }
}
