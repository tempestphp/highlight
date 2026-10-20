<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Html\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\RequiresSubstring;

#[RequiresSubstring('</style>')]
final readonly class CssInHtmlInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        // (*COMMIT) stops the search when an opener has no closer: later openers cannot have one either.
        return '<style>(*COMMIT)(?<match>[\s\S]*?)<\/style>';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return $highlighter->parse($content, 'css');
    }
}
