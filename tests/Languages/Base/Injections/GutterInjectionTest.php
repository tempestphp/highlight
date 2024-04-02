<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Base\Injections;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class GutterInjectionTest extends TestCase
{
    public function test_gutter_injection(): void
    {
        $input = <<<'TXT'
foreach ($lines as $i => $line) {
    $gutterNumber = $gutterNumbers[$i];

    $gutterClass = 'hl-gutter ' . ($this->classes[$i + 1] ?? '');
{+
    $lines[$i] = sprintf(
        Escape::tokens('<span class="%s">%s</span>%s'),+}
        $gutterClass,
        str_pad(
            string: {-$gutterNumber-},
            length: $gutterWidth,
            pad_type: STR_PAD_LEFT,
        ),
        $line,
    );
}
TXT;

        $expected = <<<'TXT'
<span class="hl-gutter ">  10</span><span class="hl-keyword">foreach</span> (<span class="hl-variable">$lines</span> <span class="hl-keyword">as</span> <span class="hl-variable">$i</span> =&gt; <span class="hl-variable">$line</span>) {
<span class="hl-gutter ">  11</span>    <span class="hl-variable">$gutterNumber</span> = <span class="hl-variable">$gutterNumbers</span>[<span class="hl-variable">$i</span>];
<span class="hl-gutter ">  12</span>
<span class="hl-gutter ">  13</span>    <span class="hl-variable">$gutterClass</span> = '<span class="hl-value">hl-gutter </span>' . (<span class="hl-variable">$this</span>-&gt;<span class="hl-property">classes</span>[<span class="hl-variable">$i</span> + 1] ?? '<span class="hl-value"></span>');
<span class="hl-gutter hl-gutter-addition">14 +</span><span class="hl-addition"></span>
<span class="hl-gutter hl-gutter-addition">15 +</span><span class="hl-addition">    <span class="hl-variable">$lines</span>[<span class="hl-variable">$i</span>] = <span class="hl-property">sprintf</span>(</span>
<span class="hl-gutter hl-gutter-addition">16 +</span><span class="hl-addition">        <span class="hl-type">Escape</span>::<span class="hl-property">tokens</span>('<span class="hl-value">&lt;span class=&quot;%s&quot;&gt;%s&lt;/span&gt;%s</span>'),</span>
<span class="hl-gutter ">  17</span>        <span class="hl-variable">$gutterClass</span>,
<span class="hl-gutter ">  18</span>        <span class="hl-property">str_pad</span>(
<span class="hl-gutter hl-gutter-deletion">19 -</span>            <span class="hl-property">string</span>: <span class="hl-deletion"><span class="hl-variable">$gutterNumber</span></span>,
<span class="hl-gutter ">  20</span>            <span class="hl-property">length</span>: <span class="hl-variable">$gutterWidth</span>,
<span class="hl-gutter ">  21</span>            <span class="hl-property">pad_type</span>: <span class="hl-property">STR_PAD_LEFT</span>,
<span class="hl-gutter ">  22</span>        ),
<span class="hl-gutter ">  23</span>        <span class="hl-variable">$line</span>,
<span class="hl-gutter ">  24</span>    );
<span class="hl-gutter ">  25</span>}
TXT;
        $highlighter = (new Highlighter())->withGutter(10);

        $this->assertSame($expected, $highlighter->parse($input, 'php'));
    }
}
