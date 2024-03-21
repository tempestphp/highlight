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
    case VARIABLE = 'variable';
    case COMMENT = 'comment';
    case INJECTION = 'injection';
    case OPERATOR = 'operator';

    public function canContain(self $other): bool
    {
        return match ($this) {
            self::OPERATOR, self::VARIABLE, self::VALUE, self::INJECTION, self::COMMENT => false,
            self::TYPE => ! in_array($other->value, [self::KEYWORD->value, self::PROPERTY->value]),
            self::GENERIC => ! in_array($other->value, [self::TYPE->value]),
            default => true,
        };
    }
}
