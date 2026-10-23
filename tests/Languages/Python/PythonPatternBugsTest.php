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

        yield 'wildcard case in match block' => [
            "match x:\n    case _:\n        pass",
            "match x:\n    case <span class=\"hl-keyword\">_</span>:\n        <span class=\"hl-keyword\">pass</span>",
        ];

        yield 'underscore parameter' => [
            'def consume(_: int): pass',
            '<span class="hl-keyword">def</span> <span class="hl-property">consume</span>(_: <span class="hl-type">int</span>): <span class="hl-keyword">pass</span>',
        ];

        yield 'underscore annotated variable' => [
            '_: int = 1',
            '_: <span class="hl-type">int</span> <span class="hl-operator">=</span> <span class="hl-number">1</span>',
        ];

        yield 'underscore dictionary key' => [
            'mapping = {_: "translated"}',
            'mapping <span class="hl-operator">=</span> {_: <span class="hl-value">&quot;translated&quot;</span>}',
        ];

        yield 'underscore lambda parameter' => [
            'lambda _: 0',
            '<span class="hl-keyword">lambda</span> _: <span class="hl-number">0</span>',
        ];
    }
}
