<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tokens;

enum TokenTypeEnum: string implements TokenType
{
    case KEYWORD = 'keyword';
    case OPERATOR = 'operator';
    case TYPE = 'type';
    case VALUE = 'value';
    case VARIABLE = 'variable';
    case PROPERTY = 'property';
    case ATTRIBUTE = 'attribute';
    case GENERIC = 'generic';
    case NUMBER = 'number';
    case LITERAL = 'literal';
    case COMMENT = 'comment';
    case INJECTION = 'injection';
    case HIDDEN = 'hidden';

    public function getValue(): string
    {
        return $this->value;
    }

    public function canContain(TokenType $other): bool
    {
        if ($this === $other) {
            return false;
        }

        return match ($this) {
            self::TYPE => ! in_array($other->getValue(), [self::KEYWORD->getValue(), self::PROPERTY->getValue()]),
            self::GENERIC => ! in_array($other->getValue(), [self::TYPE->getValue()]),
            self::ATTRIBUTE => true,
            default => false,
        };
    }
}
