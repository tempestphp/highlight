<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tokens;

final readonly class DynamicTokenType implements TokenType
{
    public function __construct(private string $value)
    {
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function canContain(TokenType $other): bool
    {
        return $this->getValue() !== $other->getValue();
    }
}
