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

    public function canContain(self $other): bool
    {
        return match ($this) {
            self::VALUE => false,
            self::COMMENT => false,
            default => true,
        };
    }
}
