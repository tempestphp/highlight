<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tokens;

final readonly class IgnoreTokenType implements TokenType
{
    #[\Override]
    public function getValue(): string
    {
        return 'ignore';
    }

    #[\Override]
    public function canContain(TokenType $other): bool
    {
        return false;
    }
}
