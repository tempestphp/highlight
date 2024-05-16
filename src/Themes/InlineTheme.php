<?php

declare(strict_types=1);

namespace Tempest\Highlight\Themes;

use Exception;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Theme;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;
use Tempest\Highlight\WebTheme;

final class InlineTheme implements Theme, WebTheme
{
    use EscapesWebTheme;

    private array $map = [];

    public function __construct(string $themePath)
    {
        $contents = @file_get_contents($themePath);

        if ($contents === false) {
            throw new Exception("No valid CSS file found at path {$themePath}");
        }

        preg_match_all('/(?<selector>[\w,\.\s\-]+){(?<style>(.|\n)*?)}/', $contents, $matches);

        foreach ($matches[0] as $key => $match) {
            $selector = trim($matches['selector'][$key]);
            $style = str_replace([PHP_EOL, '    ', "\t"], [' ', '', ''], trim($matches['style'][$key]));

            $this->map[$selector] = $style;
        }
    }

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
            TokenTypeEnum::NUMBER => 'hl-number',
            default => $tokenType->getValue(),
        };

        $style = $this->map[".{$class}"] ?? null;

        if (! $style) {
            return '<span>';
        }

        return "<span style=\"{$style}\">";
    }

    public function after(TokenType $tokenType): string
    {
        return '</span>';
    }

    public function preBefore(Highlighter $highlighter): string
    {
        $preStyle = $this->map['pre'] ?? $this->map['pre, code'] ?? '';

        return "<pre data-lang=\"{$highlighter->getCurrentLanguage()->getName()}\" class=\"notranslate\" style=\"{$preStyle}\">";
    }

    public function preAfter(Highlighter $highlighter): string
    {
        return '</pre>';
    }
}
