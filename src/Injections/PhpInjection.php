<?php

declare(strict_types=1);

namespace Tempest\Highlight\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;

final readonly class PhpInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '\&lt;\?php(?<match>(.|\n)*?)\?&gt;';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return $highlighter->parse($content, 'php');
    }
}
