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

    #[\Override]
    public function before(TokenType $tokenType): string
    {
        if ($tokenType === TokenTypeEnum::HIDDEN) {
            return '<span style="display: none">';
        }

        $class = match ($tokenType) {
            TokenTypeEnum::KEYWORD => 'hl-keyword',
            TokenTypeEnum::OPERATOR => 'hl-operator',
            TokenTypeEnum::TYPE => 'hl-type',
            TokenTypeEnum::VALUE => 'hl-value',
            TokenTypeEnum::VARIABLE => 'hl-variable',
            TokenTypeEnum::PROPERTY => 'hl-property',
            TokenTypeEnum::ATTRIBUTE => 'hl-attribute',
            TokenTypeEnum::GENERIC => 'hl-generic',
            TokenTypeEnum::NUMBER => 'hl-number',
            TokenTypeEnum::LITERAL => 'hl-literal',
            TokenTypeEnum::COMMENT => 'hl-comment',
            TokenTypeEnum::INJECTION => 'hl-injection',
            default => $tokenType->getValue(),
        };

        return "<span class=\"{$class}\">";
    }

    #[\Override]
    public function after(TokenType $tokenType): string
    {
        return "</span>";
    }

    #[\Override]
    public function preBefore(Highlighter $highlighter): string
    {
        return "<pre data-lang=\"{$highlighter->getCurrentLanguage()->getName()}\" class=\"notranslate\">";
    }

    #[\Override]
    public function preAfter(Highlighter $highlighter): string
    {
        return '</pre>';
    }
}
