<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Injections;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class PhpAttributeInstanceInjection implements Injection
{
    use IsInjection;

    #[\Override]
    public function getPattern(): string
    {
        return '(?<match>\#\[[\w]+\((.|\n)*?\)\])';
    }

    #[\Override]
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
