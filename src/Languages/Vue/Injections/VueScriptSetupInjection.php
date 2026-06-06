<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Vue\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;

final class VueScriptSetupInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '<script\s+setup\s*>(?<match>[\s\S]*?)<\/script>';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return $highlighter->parse($content, 'javascript');
    }
}
