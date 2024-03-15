<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Html\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenType;

final readonly class CloseTagPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '&lt;\/(?<match>[\w\-]+)';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::KEYWORD;
    }
}
