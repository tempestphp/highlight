<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tokens;

enum TokenType: string
{
    case KEYWORD = 'keyword';
    case PROPERTY = 'property';
    case ATTRIBUTE = 'attribute';
    case TYPE = 'type';
    case GENERIC = 'generic';
    case VALUE = 'value';
    case COMMENT = 'comment';

    public static function inject(string $language)
    {

    }

    public function parse(string $content): string
    {
        return "{$this->before()}{$content}{$this->after()}";
    }

    public function before(): string
    {
        $class = match ($this) {
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

    public function after(): string
    {
        return '</span>';
    }
}
