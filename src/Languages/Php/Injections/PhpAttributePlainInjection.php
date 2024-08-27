<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Injections;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class PhpAttributePlainInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '(?<match>\#\[[\w]+\])';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        $theme = $highlighter->getTheme();

        $parsed = '#[' . $highlighter->parse(str_replace(['#[', ']'], '', $content), 'php') . ']';

        return Escape::tokens($theme->before(TokenTypeEnum::ATTRIBUTE))
            . $parsed
            . Escape::tokens($theme->after(TokenTypeEnum::ATTRIBUTE));
    }
}
