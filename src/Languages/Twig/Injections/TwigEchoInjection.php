<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Twig\Injections;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\Languages\Twig\TwigEchoLanguage;

class TwigEchoInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '(?<match>({{(.|\n)*?}}))';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return Escape::injection($highlighter->parse($content, new TwigEchoLanguage()));
    }
}
