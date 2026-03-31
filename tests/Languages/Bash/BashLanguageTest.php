<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Bash;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class BashLanguageTest extends TestCase
{
    #[DataProvider('provide_highlight_cases')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'bash'),
        );

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'sh'),
        );

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'shell'),
        );
    }

    public static function provide_highlight_cases(): iterable
    {
        return [
            [<<<'TXT'
#!/bin/bash

# Check if file exists
if [ -f "$1" ]; then
    echo "File exists"
    cat "$1" | wc -l
else
    echo "File not found" >> /tmp/log
    exit 1
fi

for i in 1 2 3; do
    echo $i
done
TXT,
            <<<'TXT'
<span class="hl-comment">#!/bin/bash</span>

<span class="hl-comment"># Check if file exists</span>
<span class="hl-keyword">if</span> [ <span class="hl-generic">-f</span> <span class="hl-value">&quot;$1&quot;</span> ]<span class="hl-operator">;</span> <span class="hl-keyword">then</span>
    <span class="hl-type">echo</span> <span class="hl-value">&quot;File exists&quot;</span>
    cat <span class="hl-value">&quot;$1&quot;</span> <span class="hl-operator">|</span> wc <span class="hl-generic">-l</span>
<span class="hl-keyword">else</span>
    <span class="hl-type">echo</span> <span class="hl-value">&quot;File not found&quot;</span> <span class="hl-operator">&gt;&gt;</span> /tmp/log
    <span class="hl-type">exit</span> <span class="hl-number">1</span>
<span class="hl-keyword">fi</span>

<span class="hl-keyword">for</span> i <span class="hl-keyword">in</span> <span class="hl-number">1</span> <span class="hl-number">2</span> <span class="hl-number">3</span><span class="hl-operator">;</span> <span class="hl-keyword">do</span>
    <span class="hl-type">echo</span> <span class="hl-variable">$i</span>
<span class="hl-keyword">done</span>
TXT],
        ];
    }
}