<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Injections;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\Tokens\TokenType;

final readonly class PhpAttributeInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '(?<match>\#\[(.|\n)*?\])';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        $theme = $highlighter->getTheme();

        return Escape::tokens($theme->before(TokenType::ATTRIBUTE))
            . $content
            . Escape::tokens($theme->after(TokenType::ATTRIBUTE));
    }
}
