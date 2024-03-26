<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Twig\Injections;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\Tokens\TokenType;

class TwigCommentInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '(?<match>\{#(.|\n)*?#})';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        $theme = $highlighter->getTheme();

        return Escape::injection(
            Escape::tokens($theme->before(TokenType::COMMENT))
            . $content
            . Escape::tokens($theme->after(TokenType::COMMENT)),
        );
    }
}
