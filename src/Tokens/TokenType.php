<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tokens;

interface TokenType
{
    public function getValue(): string;

    public function canContain(TokenType $other): bool;
}
