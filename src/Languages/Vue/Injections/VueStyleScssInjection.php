<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Vue\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;

final class VueStyleScssInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '<style[^>]*\blang="s[ac]ss"[^>]*>(?<match>[\s\S]*?)<\/style>';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return $highlighter->parse($content, 'scss');
    }
}
