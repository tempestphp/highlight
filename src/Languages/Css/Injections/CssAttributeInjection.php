<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Css\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;

final class CssAttributeInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return 'style="(?<match>(.|\n)*?)"';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return $highlighter->parse($content, 'css');
    }
}
