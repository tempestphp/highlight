<?php

declare(strict_types=1);

namespace Tempest\Highlight;

use Tempest\Highlight\Tokens\TokenType;

interface Theme
{
    public function before(string|TokenType $tokenType): string;

    public function after(string|TokenType $tokenType): string;
}
