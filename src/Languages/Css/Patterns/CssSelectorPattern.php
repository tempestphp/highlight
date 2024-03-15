<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Css\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenType;

final readonly class CssSelectorPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>[\@\-\#\.\w\s,\n]+)\{';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::KEYWORD;
    }
}
