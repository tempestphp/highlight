<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Vue\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;

final class VueTypeScriptInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '<script[^>]*\blang="ts"[^>]*>(?<match>[\s\S]*?)<\/script>';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return $highlighter->parse($content, 'typescript');
    }
}
