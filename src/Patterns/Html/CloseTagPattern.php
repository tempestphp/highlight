<?php

declare(strict_types=1);

namespace Tempest\Highlight\Patterns\Html;

use Tempest\Highlight\Pattern;
use Tempest\Highlight\Patterns\IsPattern;
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
