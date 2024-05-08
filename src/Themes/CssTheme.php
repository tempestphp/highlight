<?php

declare(strict_types=1);

namespace Tempest\Highlight\Themes;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;
use Tempest\Highlight\WebTheme;

final readonly class CssTheme implements WebTheme
{
    use EscapesWebTheme;

    public function before(TokenType $tokenType): string
    {
        if ($tokenType === TokenTypeEnum::HIDDEN) {
            return '<span style="display: none">';
        }

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

    public function preBefore(Highlighter $highlighter): string
    {
        return "<pre data-lang=\"{$highlighter->getCurrentLanguage()->getName()}\" class=\"notranslate\">";
    }

    public function preAfter(Highlighter $highlighter): string
    {
        return '</pre>';
    }
}
