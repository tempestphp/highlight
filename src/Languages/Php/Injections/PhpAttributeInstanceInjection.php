<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Injections;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\RequiresSubstring;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[RequiresSubstring('#[')]
final readonly class PhpAttributeInstanceInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        // (*COMMIT) stops the search when an opener has no closer: later openers cannot have one either.
        return '(?<match>\#\[[\w]+\((*COMMIT)[\s\S]*?\)\])';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        $theme = $highlighter->getTheme();

        $parsed = '#[' . $highlighter->parse(str_replace(['#[', ')]'], '', $content), 'php') . ')]';

        return Escape::injection(
            Escape::tokens($theme->before(TokenTypeEnum::ATTRIBUTE))
            . $parsed
            . Escape::tokens($theme->after(TokenTypeEnum::ATTRIBUTE))
        );
    }
}
