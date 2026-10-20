<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Twig\Injections;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\Languages\Twig\TwigEchoLanguage;
use Tempest\Highlight\RequiresSubstring;

#[RequiresSubstring('{{')]
class TwigEchoInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        // (*COMMIT) stops the search when an opener has no closer: later openers cannot have one either.
        return '(?<match>({{(*COMMIT)[\s\S]*?}}))';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        // One shared instance, so the highlighter's per-language caches hit on every match
        static $language = new TwigEchoLanguage();

        return Escape::injection($highlighter->parse($content, $language));
    }
}
