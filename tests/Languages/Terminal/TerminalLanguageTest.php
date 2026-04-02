<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Terminal;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class TerminalLanguageTest extends TestCase
{
    #[DataProvider('provide_highlight_cases')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'terminal'),
        );

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'console'),
        );

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'term'),
        );
    }

    public static function provide_highlight_cases(): iterable
    {
        return [
            [<<<'TXT'
$ npm install --save express
added 57 packages
$ echo "Hello $USER"
Hello john
# docker ps -a
CONTAINER ID   IMAGE   STATUS
TXT,
            <<<'TXT'
<span class="hl-comment">$</span> <span class="hl-keyword">npm</span> install <span class="hl-generic">--save</span> express
added <span class="hl-number">57</span> packages
<span class="hl-comment">$</span> <span class="hl-keyword">echo</span> <span class="hl-value">&quot;Hello $USER&quot;</span>
Hello john
<span class="hl-comment">#</span> <span class="hl-keyword">docker</span> ps <span class="hl-generic">-a</span>
CONTAINER ID   IMAGE   STATUS
TXT],
        ];
    }
}
