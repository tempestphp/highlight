```php
        public function before(TokenType $tokenType): string
        {
            $style = match ($tokenType) {
                TokenType::KEYWORD => TerminalStyle::FG_DARK_BLUE,
                TokenType::PROPERTY => TerminalStyle::FG_DARK_GREEN,
                TokenType::TYPE => TerminalStyle::FG_DARK_RED,
                TokenType::GENERIC => TerminalStyle::FG_DARK_CYAN,
                TokenType::VALUE => TerminalStyle::FG_BLACK,
                TokenType::COMMENT => TerminalStyle::FG_GRAY,
                TokenType::ATTRIBUTE => TerminalStyle::RESET,
            };
        
            return TerminalStyle::ESC->value . $style->value;
        }
```