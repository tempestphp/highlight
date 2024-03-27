<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Escape;
use Tempest\Highlight\Themes\CssTheme;
use Tempest\Highlight\Tokens\GroupTokens;
use Tempest\Highlight\Tokens\RenderTokens;
use Tempest\Highlight\Tokens\Token;
use Tempest\Highlight\Tokens\TokenTypeEnum;

class RenderTokensTest extends TestCase
{
    #[Test]
    public function test_nested_tokens(): void
    {
        $content = '/** @var \Tempest\View\GenericView $this */';

        $tokens = (new GroupTokens())([
            new Token(
                offset: 0,
                value: '/** @var \Tempest\View\GenericView $this */',
                type: TokenTypeEnum::COMMENT,
            ),
            new Token(
                offset: 23,
                value: 'GenericView',
                type: TokenTypeEnum::TYPE,
            ),
        ]);

        $parsed = Escape::html((new RenderTokens(new CssTheme()))($content, $tokens));

        $this->assertSame(
            '<span class="hl-comment">/** @var \Tempest\View\GenericView $this */</span>',
            $parsed,
        );
    }

    #[Test]
    public function test_nested_tokens_b()
    {
        $tokens = (new GroupTokens())([
            new Token(
                offset: 0,
                value: "#[Get(hi: '/')]",
                type: TokenTypeEnum::ATTRIBUTE,
            ),
            new Token(
                offset: 2,
                value: 'get',
                type: TokenTypeEnum::TYPE,
            ),
            new Token(
                offset: 6,
                value: 'hi',
                type: TokenTypeEnum::PROPERTY,
            ),
        ]);

        $output = Escape::html((new RenderTokens(new CssTheme()))("#[Get(hi: '/')]", $tokens));

        $this->assertSame(
            "<span class=\"hl-attribute\">#[<span class=\"hl-type\">get</span>(<span class=\"hl-property\">hi</span>: '/')]</span>",
            $output,
        );
    }

    #[Test]
    public function test_nested_tokens_c()
    {
        $content = "    #[Get(hi: '/')]
    public";

        $tokens = (new GroupTokens())([
            new Token(
                offset: 4,
                value: "#[Get(hi: '/')]",
                type: TokenTypeEnum::ATTRIBUTE,
            ),
            new Token(
                offset: 6,
                value: 'get',
                type: TokenTypeEnum::TYPE,
            ),
            new Token(
                offset: 10,
                value: 'hi',
                type: TokenTypeEnum::PROPERTY,
            ),
            new Token(
                offset: 24,
                value: 'public',
                type: TokenTypeEnum::KEYWORD,
            ),
        ]);

        $output = Escape::html((new RenderTokens(new CssTheme()))($content, $tokens));

        $this->assertSame(
            "    <span class=\"hl-attribute\">#[<span class=\"hl-type\">get</span>(<span class=\"hl-property\">hi</span>: '/')]</span>
    <span class=\"hl-keyword\">public</span>",
            $output,
        );
    }
}
