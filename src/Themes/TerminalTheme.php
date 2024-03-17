<?php

namespace Tempest\Highlight\Themes;

use Tempest\Highlight\Theme;
use Tempest\Highlight\Tokens\TokenType;

final readonly class TerminalTheme implements Theme
{
    public function before(string|TokenType $tokenType): string
    {
        $style = match ($tokenType) {
            TokenType::KEYWORD => TerminalStyle::FG_DARK_BLUE,
            TokenType::PROPERTY => TerminalStyle::FG_DARK_GREEN,
            TokenType::TYPE => TerminalStyle::FG_DARK_RED,
            TokenType::GENERIC => TerminalStyle::FG_DARK_CYAN,
            TokenType::VALUE => TerminalStyle::FG_BLACK,
            TokenType::COMMENT => TerminalStyle::FG_GRAY,
            default => TerminalStyle::RESET,
        };

        return TerminalStyle::ESC->value . $style->value;
    }

    public function after(string|TokenType $tokenType): string
    {
        return TerminalStyle::ESC->value . TerminalStyle::RESET->value;
    }
}