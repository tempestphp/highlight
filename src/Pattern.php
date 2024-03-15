<?php

declare(strict_types=1);

namespace Tempest\Highlight;

use Tempest\Highlight\Tokens\TokenType;

interface Pattern
{
    public function match(string $content): array;

    public function getTokenType(): TokenType;
}
