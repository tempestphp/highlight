<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Html\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\Languages\JavaScript\JavaScriptLanguage;

final readonly class JavaScriptInHtmlInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '<script>(?<match>(.|\n)*)<\/script>';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        // One shared instance, so the highlighter's per-language caches hit on every match
        static $language = new JavaScriptLanguage();

        return $highlighter->parse($content, $language);
    }
}
