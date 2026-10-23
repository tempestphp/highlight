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

        yield 'wildcard case after two spaces' => [
            "match value:\n    case  _:\n        pass",
            "match value:\n    case  <span class=\"hl-keyword\">_</span>:\n        <span class=\"hl-keyword\">pass</span>",
        ];

        yield 'wildcard case after space and tab' => [
            "match value:\n    case \t_:\n        pass",
            "match value:\n    case \t<span class=\"hl-keyword\">_</span>:\n        <span class=\"hl-keyword\">pass</span>",
        ];

        yield 'underscore after comment ending in case' => [
            "# Special case\n_: int = 1",
            "<span class=\"hl-comment\"># Special case</span>\n_: <span class=\"hl-type\">int</span> <span class=\"hl-operator\">=</span> <span class=\"hl-number\">1</span>",
        ];

        yield 'wildcard in or pattern' => [
            "match x:\n    case 1 | _:\n        pass",
            "match x:\n    case <span class=\"hl-number\">1</span> <span class=\"hl-operator\">|</span> <span class=\"hl-keyword\">_</span>:\n        <span class=\"hl-keyword\">pass</span>",
        ];

        yield 'wildcard in sequence pattern' => [
            "match x:\n    case (_, x):\n        pass",
            "match x:\n    case (<span class=\"hl-keyword\">_</span>, x):\n        <span class=\"hl-keyword\">pass</span>",
        ];

        yield 'wildcard star pattern' => [
            "match x:\n    case [x, *_]:\n        pass",
            "match x:\n    case [x, <span class=\"hl-operator\">*</span><span class=\"hl-keyword\">_</span>]:\n        <span class=\"hl-keyword\">pass</span>",
        ];

        yield 'wildcard in class pattern' => [
            "match x:\n    case Point(x=_):\n        pass",
            "match x:\n    case Point(<span class=\"hl-variable\">x</span><span class=\"hl-operator\">=</span><span class=\"hl-keyword\">_</span>):\n        <span class=\"hl-keyword\">pass</span>",
        ];

        yield 'wildcard in mapping pattern' => [
            "match x:\n    case {\"k\": _}:\n        pass",
            "match x:\n    case {<span class=\"hl-value\">&quot;k&quot;</span>: <span class=\"hl-keyword\">_</span>}:\n        <span class=\"hl-keyword\">pass</span>",
        ];

        yield 'underscore in guard' => [
            "match x:\n    case _ if _ > 0:\n        pass",
            "match x:\n    case <span class=\"hl-keyword\">_</span> <span class=\"hl-keyword\">if</span> _ <span class=\"hl-operator\">&gt;</span> <span class=\"hl-number\">0</span>:\n        <span class=\"hl-keyword\">pass</span>",
        ];

        yield 'underscore in one-line case body' => [
            "match x:\n    case _: return _",
            "match x:\n    case <span class=\"hl-keyword\">_</span>: <span class=\"hl-keyword\">return</span> _",
        ];

        yield 'underscore in case string' => [
            "match x:\n    case \"_\":\n        pass",
            "match x:\n    case <span class=\"hl-value\">&quot;_&quot;</span>:\n        <span class=\"hl-keyword\">pass</span>",
        ];

        yield 'underscore in case comment' => [
            "match x:\n    case _:  # _ comment\n        pass",
            "match x:\n    case <span class=\"hl-keyword\">_</span>:  <span class=\"hl-comment\"># _ comment</span>\n        <span class=\"hl-keyword\">pass</span>",
        ];

        yield 'underscore value pattern attribute' => [
            "match x:\n    case Color._:\n        pass",
            "match x:\n    case Color._:\n        <span class=\"hl-keyword\">pass</span>",
        ];

        yield 'case identifier with lambda' => [
            "case = lambda _: _",
            "case <span class=\"hl-operator\">=</span> <span class=\"hl-keyword\">lambda</span> _: _",
        ];

        yield 'case outside match block' => [
            "if x:\n    case _:\n        pass",
            "<span class=\"hl-keyword\">if</span> x:\n    case _:\n        <span class=\"hl-keyword\">pass</span>",
        ];

        yield 'case subscript assigned a lambda' => [
            "case = {}\ncase[_] = lambda _: _",
            "case <span class=\"hl-operator\">=</span> {}\ncase[_] <span class=\"hl-operator\">=</span> <span class=\"hl-keyword\">lambda</span> _: _",
        ];

        yield 'case call subscript annotation' => [
            "case(_)[0]: int = 1",
            "case(_)[<span class=\"hl-number\">0</span>]: <span class=\"hl-type\">int</span> <span class=\"hl-operator\">=</span> <span class=\"hl-number\">1</span>",
        ];

        yield 'underscore attribute in mapping key' => [
            "match x:\n    case {_.y: _, 1: z}:\n        pass",
            "match x:\n    case {_.y: <span class=\"hl-keyword\">_</span>, <span class=\"hl-number\">1</span>: z}:\n        <span class=\"hl-keyword\">pass</span>",
        ];

        yield 'wildcard after multi-line match subject' => [
            "match (x,\ny):\n    case _:\n        pass",
            "match (x,\ny):\n    case <span class=\"hl-keyword\">_</span>:\n        <span class=\"hl-keyword\">pass</span>",
        ];

        yield 'wildcard after multi-line string in case body' => [
            "match x:\n    case 1:\n        s = \"\"\"\ndoc\n\"\"\"\n    case _:\n        pass",
            "match x:\n    case <span class=\"hl-number\">1</span>:\n        s <span class=\"hl-operator\">=</span> <span class=\"hl-value\">&quot;&quot;&quot;\ndoc\n&quot;&quot;&quot;</span>\n    case <span class=\"hl-keyword\">_</span>:\n        <span class=\"hl-keyword\">pass</span>",
        ];
    }
}
