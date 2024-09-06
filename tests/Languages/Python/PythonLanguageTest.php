<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Python;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class PythonLanguageTest extends TestCase
{
    #[DataProvider('data')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'python'),
        );

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'py'),
        );
    }

    public static function data(): array
    {
        return [
            [<<<TXT
def fib(n):    # write Fibonacci series up to n
    """Print a Fibonacci series up to n."""
    a, b = 0, 1
    while a < n:
        print(a, end=' ')
        a, b = b, a+b
    print()

# Now call the function we just defined:
fib(2000)
TXT,
            <<<TXT
<span class="hl-keyword">def</span> <span class="hl-property">fib</span>(n):    <span class="hl-comment"># write Fibonacci series up to n</span>
    <span class="hl-value">&quot;&quot;&quot;Print a Fibonacci series up to n.&quot;&quot;&quot;</span>
    a, b <span class="hl-operator">=</span> <span class="hl-number">0</span>, <span class="hl-number">1</span>
    <span class="hl-keyword">while</span> a <span class="hl-operator">&lt;</span> n:
        <span class="hl-type">print</span>(a, <span class="hl-variable">end</span><span class="hl-operator">=</span><span class="hl-value">' '</span>)
        a, b <span class="hl-operator">=</span> b, a<span class="hl-operator">+</span>b
    <span class="hl-type">print</span>()

<span class="hl-comment"># Now call the function we just defined:</span>
fib(<span class="hl-number">2000</span>)
TXT],
        ];
    }
}
