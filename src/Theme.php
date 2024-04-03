<?php

declare(strict_types=1);

namespace Tempest\Highlight;

use Tempest\Highlight\Tokens\TokenType;

interface Theme
{
    public function before(TokenType $tokenType): string;

    public function after(TokenType $tokenType): string;

    public function escape(string $content): string;
}
