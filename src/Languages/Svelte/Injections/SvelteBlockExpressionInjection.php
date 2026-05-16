<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Svelte\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;

final class SvelteBlockExpressionInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '\{[#@:\/](?:[a-z]+)\b\s*(?<match>(?:[^{}]++|\{(?&match)\})*+)\}';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return $highlighter->parse($content, 'typescript');
    }
}
