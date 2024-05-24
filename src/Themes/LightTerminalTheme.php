<?php

declare(strict_types=1);

namespace Tempest\Highlight\Themes;

use Tempest\Highlight\TerminalTheme;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

class LightTerminalTheme implements TerminalTheme
{
    use EscapesTerminalTheme;

    public function before(TokenType $tokenType): string
    {
        $style = match ($tokenType) {
            TokenTypeEnum::KEYWORD => TerminalStyle::FG_DARK_BLUE,
            TokenTypeEnum::TYPE => TerminalStyle::FG_DARK_RED,
            TokenTypeEnum::VALUE => TerminalStyle::FG_BLACK,
            TokenTypeEnum::NUMBER => TerminalStyle::FG_DARK_YELLOW,
            TokenTypeEnum::LITERAL => TerminalStyle::FG_DARK_BLUE,
            TokenTypeEnum::PROPERTY => TerminalStyle::FG_DARK_GREEN,
            TokenTypeEnum::GENERIC => TerminalStyle::FG_DARK_CYAN,
            TokenTypeEnum::COMMENT => TerminalStyle::FG_GRAY,
            default => TerminalStyle::RESET,
        };

        return TerminalStyle::ESC->value . $style->value;
    }

    public function after(TokenType $tokenType): string
    {
        return TerminalStyle::ESC->value . TerminalStyle::RESET->value;
    }
}
