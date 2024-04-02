<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Base\Injections;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Themes\LightTerminalTheme;

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
<span class="hl-gutter ">  10</span> <span class="hl-keyword">foreach</span> (<span class="hl-variable">$lines</span> <span class="hl-keyword">as</span> <span class="hl-variable">$i</span> =&gt; <span class="hl-variable">$line</span>) {
<span class="hl-gutter ">  11</span>     <span class="hl-variable">$gutterNumber</span> = <span class="hl-variable">$gutterNumbers</span>[<span class="hl-variable">$i</span>];
<span class="hl-gutter ">  12</span> 
<span class="hl-gutter ">  13</span>     <span class="hl-variable">$gutterClass</span> = '<span class="hl-value">hl-gutter </span>' . (<span class="hl-variable">$this</span>-&gt;<span class="hl-property">classes</span>[<span class="hl-variable">$i</span> + 1] ?? '<span class="hl-value"></span>');
<span class="hl-gutter hl-gutter-addition">14 +</span> <span class="hl-addition"></span>
<span class="hl-gutter hl-gutter-addition">15 +</span> <span class="hl-addition">    <span class="hl-variable">$lines</span>[<span class="hl-variable">$i</span>] = <span class="hl-property">sprintf</span>(</span>
<span class="hl-gutter hl-gutter-addition">16 +</span> <span class="hl-addition">        <span class="hl-type">Escape</span>::<span class="hl-property">tokens</span>('<span class="hl-value">&lt;span class=&quot;%s&quot;&gt;%s&lt;/span&gt;%s</span>'),</span>
<span class="hl-gutter ">  17</span>         <span class="hl-variable">$gutterClass</span>,
<span class="hl-gutter ">  18</span>         <span class="hl-property">str_pad</span>(
<span class="hl-gutter hl-gutter-deletion">19 -</span>             <span class="hl-property">string</span>: <span class="hl-deletion"><span class="hl-variable">$gutterNumber</span></span>,
<span class="hl-gutter ">  20</span>             <span class="hl-property">length</span>: <span class="hl-variable">$gutterWidth</span>,
<span class="hl-gutter ">  21</span>             <span class="hl-property">pad_type</span>: <span class="hl-property">STR_PAD_LEFT</span>,
<span class="hl-gutter ">  22</span>         ),
<span class="hl-gutter ">  23</span>         <span class="hl-variable">$line</span>,
<span class="hl-gutter ">  24</span>     );
<span class="hl-gutter ">  25</span> }
TXT;
        $highlighter = (new Highlighter())->withGutter(10);

        $this->assertSame($expected, $highlighter->parse($input, 'php'));
    }

    public function test_gutter_injection_terminal(): void
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
ICAxMCAbWzM0bWZvcmVhY2gbWzBtICgbWzBtJGxpbmVzG1swbSAbWzM0bWFzG1swbSAbWzBtJGkbWzBtID0+IBtbMG0kbGluZRtbMG0pIHsKICAxMSAgICAgG1swbSRndXR0ZXJOdW1iZXIbWzBtID0gG1swbSRndXR0ZXJOdW1iZXJzG1swbVsbWzBtJGkbWzBtXTsKICAxMiAKICAxMyAgICAgG1swbSRndXR0ZXJDbGFzcxtbMG0gPSAnG1szMG1obC1ndXR0ZXIgG1swbScgLiAoG1swbSR0aGlzG1swbS0+G1szMm1jbGFzc2VzG1swbVsbWzBtJGkbWzBtICsgMV0gPz8gJxtbMzBtG1swbScpOwoxNCArIAoxNSArICAgICAbWzBtJGxpbmVzG1swbVsbWzBtJGkbWzBtXSA9IBtbMzJtc3ByaW50ZhtbMG0oCjE2ICsgICAgICAgICAbWzMxbUVzY2FwZRtbMG06OhtbMzJtdG9rZW5zG1swbSgnG1szMG08c3BhbiBjbGFzcz0iJXMiPiVzPC9zcGFuPiVzG1swbScpLAogIDE3ICAgICAgICAgG1swbSRndXR0ZXJDbGFzcxtbMG0sCiAgMTggICAgICAgICAbWzMybXN0cl9wYWQbWzBtKAoxOSAtICAgICAgICAgICAgIBtbMzJtc3RyaW5nG1swbTogG1swbSRndXR0ZXJOdW1iZXIbWzBtLAogIDIwICAgICAgICAgICAgIBtbMzJtbGVuZ3RoG1swbTogG1swbSRndXR0ZXJXaWR0aBtbMG0sCiAgMjEgICAgICAgICAgICAgG1szMm1wYWRfdHlwZRtbMG06IBtbMzJtU1RSX1BBRF9MRUZUG1swbSwKICAyMiAgICAgICAgICksCiAgMjMgICAgICAgICAbWzBtJGxpbmUbWzBtLAogIDI0ICAgICApOwogIDI1IH0=
TXT;

        $highlighter = (new Highlighter(new LightTerminalTheme()))->withGutter(10);

        $this->assertSame(base64_decode($expected), $highlighter->parse($input, 'php'));
    }
}
