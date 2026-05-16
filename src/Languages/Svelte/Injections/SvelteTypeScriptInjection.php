<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Svelte\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\Languages\TypeScript\TypeScriptLanguage;

final class SvelteTypeScriptInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '<script\s+lang="ts">(?<match>[\s\S]*?)<\/script>';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return $highlighter->parse($content, 'typescript');
    }
}
