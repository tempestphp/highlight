<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Tokens;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;
use Tempest\Highlight\Theme;
use Tempest\Highlight\Themes\CssTheme;
use Tempest\Highlight\Tokens\DynamicTokenType;
use Tempest\Highlight\Tokens\RenderTokens;
use Tempest\Highlight\Tokens\Token;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

class RenderTokensMarkupCacheTest extends TestCase
{
    #[Test]
    public function custom_token_type_with_a_built_in_value_gets_its_own_markup(): void
    {
        $theme = new class () implements Theme {
            public function before(TokenType $tokenType): string
            {
                return '[' . ($tokenType instanceof TokenTypeEnum ? 'enum' : 'custom') . ']';
            }

            public function after(TokenType $tokenType): string
            {
                return '[/]';
            }

            public function escape(string $content): string
            {
                return $content;
            }
        };

        $render = new RenderTokens($theme);

        $this->assertSame('[enum]a[/]', $render('a', [new Token(0, 'a', TokenTypeEnum::KEYWORD)]));
        $this->assertSame('[custom]a[/]', $render('a', [new Token(0, 'a', new DynamicTokenType('keyword'))]));
        $this->assertSame('[enum]a[/] [custom]b[/]', $render('a b', [
            new Token(0, 'a', TokenTypeEnum::KEYWORD),
            new Token(2, 'b', new DynamicTokenType('keyword')),
        ]));
    }

    #[Test]
    public function markup_cache_does_not_grow_with_custom_class_names(): void
    {
        $render = new RenderTokens(new CssTheme());

        for ($i = 0; $i < 100; $i++) {
            $render('a', [new Token(0, 'a', new DynamicTokenType("hl-custom-{$i}"))]);
        }

        $render('a', [new Token(0, 'a', TokenTypeEnum::KEYWORD)]);

        $cache = new ReflectionProperty(RenderTokens::class, 'tokenMarkup')->getValue($render);

        $this->assertLessThan(10, count($cache, COUNT_RECURSIVE));
    }
}
