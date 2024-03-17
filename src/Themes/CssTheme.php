<?php

namespace Tempest\Highlight\Themes;

use Tempest\Highlight\Theme;
use Tempest\Highlight\Tokens\TokenType;

final readonly class CssTheme implements Theme
{
    public function before(TokenType $tokenType): string
    {
        $class = match ($tokenType) {
            TokenType::KEYWORD => 'hl-keyword',
            TokenType::PROPERTY => 'hl-property',
            TokenType::TYPE => 'hl-type',
            TokenType::GENERIC => 'hl-generic',
            TokenType::VALUE => 'hl-value',
            TokenType::COMMENT => 'hl-comment',
            TokenType::ATTRIBUTE => 'hl-attribute',
        };

        return "<span class=\"{$class}\">";
    }

    public function after(TokenType $tokenType): string
    {
        return "</span>";
    }
}