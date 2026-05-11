<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Graphql;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class GraphqlLanguageTest extends TestCase
{
    #[DataProvider('provide_highlighting_cases')]
    public function test_highlighting(string $content, string $expected)
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            trim($expected),
            trim($highlighter->parse($content, 'graphql'))
        );
    }

    public static function provide_highlighting_cases(): iterable
    {
        return [
            // Test Keywords & Types
            [
                'query GetUser { user { id } }',
                '<span class="hl-keyword">query</span> GetUser <span class="hl-operator">{</span> user <span class="hl-operator">{</span> id <span class="hl-operator">}</span> <span class="hl-operator">}</span>',
            ],
            // Test Literals & Built-in Types
            [
                'scalar Custom String Boolean',
                '<span class="hl-keyword">scalar</span> Custom <span class="hl-type">String</span> <span class="hl-type">Boolean</span>',
            ],
            // Test Variables
            [
                'query($id: ID!)',
                '<span class="hl-keyword">query</span><span class="hl-operator">(</span><span class="hl-variable">$id</span><span class="hl-operator">:</span> <span class="hl-type">ID</span><span class="hl-operator">!</span><span class="hl-operator">)</span>',
            ],
            // Test Fields (Symbols)
            [
                '{ user(name: "Test") }',
                '<span class="hl-operator">{</span> user<span class="hl-operator">(</span><span class="hl-property">name</span><span class="hl-operator">:</span> &quot;<span class="hl-value">Test</span>&quot;<span class="hl-operator">)</span> <span class="hl-operator">}</span>',
            ],
            // Test Directives
            [
                'field @deprecated',
                'field <span class="hl-attribute">@deprecated</span>',
            ],
            // Test Comments
            [
                '# This is a comment',
                '<span class="hl-comment"># This is a comment</span>',
            ],
            [
                '"""
    Multi-line
    Comment
    """
    type User { id: ID }',
                '<span class="hl-comment">&quot;&quot;&quot;
    Multi-line
    Comment
    &quot;&quot;&quot;</span>
    <span class="hl-keyword">type</span> User <span class="hl-operator">{</span> <span class="hl-property">id</span><span class="hl-operator">:</span> <span class="hl-type">ID</span> <span class="hl-operator">}</span>',
            ],
            // Test Numbers
            [
                'offset: 10, price: 1.99',
                '<span class="hl-property">offset</span><span class="hl-operator">:</span> <span class="hl-number">10</span>, <span class="hl-property">price</span><span class="hl-operator">:</span> <span class="hl-number">1.99</span>',
            ],
            // Test Fragments and Spread
            [
                '...UserFragment',
                '<span class="hl-operator">...</span>UserFragment',
            ],
        ];
    }
}
