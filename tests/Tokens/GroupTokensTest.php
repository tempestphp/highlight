<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Tokens;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\PhpLanguage;
use Tempest\Highlight\Tokens\DynamicTokenType;
use Tempest\Highlight\Tokens\GroupTokens;
use Tempest\Highlight\Tokens\ParseTokens;
use Tempest\Highlight\Tokens\Token;
use Tempest\Highlight\Tokens\TokenTypeEnum;

class GroupTokensTest extends TestCase
{
    public function test_exact_overlaps(): void
    {
        $tokens = [
            new Token(0, 'test', new DynamicTokenType('hl-blur')),
            new Token(0, 'test', TokenTypeEnum::KEYWORD),
            new Token(10, 'Foo', TokenTypeEnum::TYPE),
        ];

        $grouped = (new GroupTokens())($tokens);

        $this->assertCount(2, $grouped);
        $this->assertCount(1, $grouped[0]->children);
        $this->assertInstanceOf(DynamicTokenType::class, $grouped[0]->type);
        $this->assertSame(TokenTypeEnum::KEYWORD, $grouped[0]->children[0]->type);
        $this->assertSame(TokenTypeEnum::TYPE, $grouped[1]->type);
    }

    public function test_exact_overlaps_within_children(): void
    {
        $tokens = (new ParseTokens())('->addExtension(new CommonMarkCoreExtension())', new PhpLanguage());

        $tokens[] = new Token(
            offset: 0,
            value: '->addExtension(new CommonMarkCoreExtension())',
            type: new DynamicTokenType('hl-blur'),
        );

        $tokens = (new GroupTokens())($tokens);

        $this->assertCount(1, $tokens);
        $this->assertCount(3, $tokens[0]->children);
    }
}
