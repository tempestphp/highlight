<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\JavaScript\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\Languages\JavaScript\JsDocLanguage;
use Tempest\Highlight\RequiresSubstring;

#[RequiresSubstring('/**')]
final readonly class JsDocInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        // (*COMMIT) stops the search when an opener has no closer: later openers cannot have one either.
        return '/(?<match>\/\*\*(*COMMIT)[\s\S]*?\*\/)/m';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        // One shared instance, so the highlighter's per-language caches hit on every match
        static $language = new JsDocLanguage();

        return $highlighter->parse($content, $language);
    }
}
