<?php

declare(strict_types=1);

namespace Tempest\Highlight\Themes;

use Tempest\Highlight\Theme;
use Tempest\Highlight\Tokens\TokenType;

final class CssTheme implements Theme
{
    public function before(string|TokenType $tokenType): string
    {
        $class = match ($tokenType) {
            TokenType::KEYWORD => 'hl-keyword',
            TokenType::PROPERTY => 'hl-property',
            TokenType::TYPE => 'hl-type',
            TokenType::GENERIC => 'hl-generic',
            TokenType::VALUE => 'hl-value',
            TokenType::COMMENT => 'hl-comment',
            TokenType::ATTRIBUTE => 'hl-attribute',
            TokenType::INJECTION => 'hl-injection',
            TokenType::VARIABLE => 'hl-variable',
            TokenType::OPERATOR => 'hl-operator',
            default => $tokenType,
        };

        return "<span class=\"{$class}\">";
    }

    public function after(string|TokenType $tokenType): string
    {
        return "</span>";
    }
}
