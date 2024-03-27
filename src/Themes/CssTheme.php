<?php

declare(strict_types=1);

namespace Tempest\Highlight\Themes;

use Tempest\Highlight\Theme;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class CssTheme implements Theme
{
    public function before(TokenType $tokenType): string
    {
        $class = match ($tokenType) {
            TokenTypeEnum::KEYWORD => 'hl-keyword',
            TokenTypeEnum::PROPERTY => 'hl-property',
            TokenTypeEnum::TYPE => 'hl-type',
            TokenTypeEnum::GENERIC => 'hl-generic',
            TokenTypeEnum::VALUE => 'hl-value',
            TokenTypeEnum::COMMENT => 'hl-comment',
            TokenTypeEnum::ATTRIBUTE => 'hl-attribute',
            TokenTypeEnum::INJECTION => 'hl-injection',
            TokenTypeEnum::VARIABLE => 'hl-variable',
            TokenTypeEnum::OPERATOR => 'hl-operator',
            default => $tokenType->getValue(),
        };

        return "<span class=\"{$class}\">";
    }

    public function after(TokenType $tokenType): string
    {
        return "</span>";
    }
}
