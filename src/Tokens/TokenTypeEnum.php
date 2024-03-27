<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tokens;

enum TokenTypeEnum: string implements TokenType
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

    public function getValue(): string
    {
        return $this->value;
    }

    public function canContain(TokenType $other): bool
    {
        return match ($this) {
            self::OPERATOR, self::VARIABLE, self::VALUE, self::INJECTION, self::COMMENT => false,
            self::TYPE => ! in_array($other->getValue(), [self::KEYWORD->getValue(), self::PROPERTY->getValue()]),
            self::GENERIC => ! in_array($other->getValue(), [self::TYPE->getValue()]),
            default => true,
        };
    }
}
