<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Html\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;

final readonly class PhpInHtmlInjection implements Injection
{
    use IsInjection;

    #[\Override]
    public function getPattern(): string
    {
        return '\<\?php(?<match>(.|\n)*?)\?>';
    }

    #[\Override]
    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return $highlighter->parse($content, 'php');
    }
}
