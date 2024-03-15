<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Tokens\Token;
use Tempest\Highlight\Tokens\TokenType;

class TokenTest extends TestCase
{
    #[Test]
    public function test_contains(): void
    {
        $a = new Token(
            offset: 10,
            value: 'abc',
            type: TokenType::VALUE,
        );

        $b = new Token(
            offset: 11,
            value: 'b',
            type: TokenType::VALUE,
        );

        $this->assertTrue($a->contains($b));
        $this->assertFalse($b->contains($a));
    }
}
