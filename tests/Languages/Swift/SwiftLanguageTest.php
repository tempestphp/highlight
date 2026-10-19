<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Swift;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class SwiftLanguageTest extends TestCase
{
    #[DataProvider('provide_highlight_cases')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'swift'),
        );
    }

    public static function provide_highlight_cases(): iterable
    {
        return [
            [<<<'TXT'
@MainActor
struct Greeter: View {
    let name = "Swift" // the language

    var body: some View {
        Text("Hello, \(name)!")
    }

    func count(_ items: [String]) -> Int {
        guard !items.isEmpty else { return 0 }
        return items.count * 1_000
    }
}
TXT,
            <<<'TXT'
<span class="hl-attribute">@MainActor</span>
<span class="hl-keyword">struct</span> <span class="hl-type">Greeter</span>: <span class="hl-type">View</span> {
    <span class="hl-keyword">let</span> name = <span class="hl-value">&quot;Swift&quot;</span> <span class="hl-comment">// the language</span>

    <span class="hl-keyword">var</span> body: <span class="hl-keyword">some</span> <span class="hl-type">View</span> {
        Text(<span class="hl-value">&quot;Hello, \(name)!&quot;</span>)
    }

    <span class="hl-keyword">func</span> <span class="hl-property">count</span>(_ items: [<span class="hl-type">String</span>]) -&gt; <span class="hl-type">Int</span> {
        <span class="hl-keyword">guard</span> !items.isEmpty <span class="hl-keyword">else</span> { <span class="hl-keyword">return</span> <span class="hl-number">0</span> }
        <span class="hl-keyword">return</span> items.count * <span class="hl-number">1_000</span>
    }
}
TXT],
            [<<<'TXT'
/* A multi-line
   comment with return inside */
let text = """
    if this were code
    """
let flag = true && nil == nil
let mask = 0xFF
TXT,
            <<<'TXT'
<span class="hl-comment">/* A multi-line
   comment with return inside */</span>
<span class="hl-keyword">let</span> text = <span class="hl-value">&quot;&quot;&quot;
    if this were code
    &quot;&quot;&quot;</span>
<span class="hl-keyword">let</span> flag = <span class="hl-literal">true</span> &amp;&amp; <span class="hl-literal">nil</span> == <span class="hl-literal">nil</span>
<span class="hl-keyword">let</span> mask = <span class="hl-number">0xFF</span>
TXT],
            [<<<'TXT'
/* outer /* inner */ return nil */
let s = """
    say \""" if
    """
let v = "value \(identity("if"))"
TXT,
            <<<'TXT'
<span class="hl-comment">/* outer /* inner */ return nil */</span>
<span class="hl-keyword">let</span> s = <span class="hl-value">&quot;&quot;&quot;
    say \&quot;&quot;&quot; if
    &quot;&quot;&quot;</span>
<span class="hl-keyword">let</span> v = <span class="hl-value">&quot;value \(identity(&quot;if&quot;))&quot;</span>
TXT],
        ];
    }
}
