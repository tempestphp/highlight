<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Python;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

final class PythonPatternBugsTest extends TestCase
{
    #[DataProvider('provide_highlight_cases')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame($expected, $highlighter->parse($content, 'python'));
    }

    public static function provide_highlight_cases(): iterable
    {
        yield 'and keyword' => [
            'a and b',
            'a <span class="hl-keyword">and</span> b',
        ];

        yield 'wildcard case' => [
            'case _:',
            'case <span class="hl-keyword">_</span>:',
        ];
    }
}
