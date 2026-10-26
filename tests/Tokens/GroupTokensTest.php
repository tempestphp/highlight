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

    public function test_children_are_grouped_as_well(): void
    {
        $tokens = [
            new Token(0, '"SELECT * FROM users"', new DynamicTokenType('hl-em')),
            new Token(0, '"SELECT * FROM users"', TokenTypeEnum::VALUE),
            new Token(1, 'SELECT', TokenTypeEnum::PROPERTY),
            new Token(10, 'FROM', TokenTypeEnum::PROPERTY),
        ];

        $grouped = (new GroupTokens())($tokens);

        $this->assertCount(1, $grouped);
        $this->assertCount(1, $grouped[0]->children);
        $this->assertSame(TokenTypeEnum::VALUE, $grouped[0]->children[0]->type);
        $this->assertSame([], $grouped[0]->children[0]->children);
    }

    public function test_token_running_past_its_parent_is_dropped(): void
    {
        $tokens = [
            new Token(0, '$foo = "SEL', new DynamicTokenType('hl-em')),
            new Token(7, '"SELECT"', TokenTypeEnum::VALUE),
        ];

        $grouped = (new GroupTokens())($tokens);

        $this->assertCount(1, $grouped);
        $this->assertSame([], $grouped[0]->children);
    }

    public function test_markers_can_be_placed_inside_any_token(): void
    {
        $tokens = [
            new Token(0, '"Hello {_world_}"', TokenTypeEnum::VALUE),
            new Token(7, '{_', TokenTypeEnum::HIDDEN),
            new Token(9, 'world', new DynamicTokenType('hl-em')),
            new Token(14, '_}', TokenTypeEnum::HIDDEN),
        ];

        $grouped = (new GroupTokens())($tokens);

        $this->assertCount(1, $grouped);
        $this->assertCount(3, $grouped[0]->children);
        $this->assertSame('hl-em', $grouped[0]->children[1]->type->getValue());
    }
}
