<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tokens;

final readonly class IgnoreTokenType implements TokenType
{
    public function getValue(): string
    {
        return 'ignore';
    }

    public function canContain(TokenType $other): bool
    {
        return false;
    }
}
