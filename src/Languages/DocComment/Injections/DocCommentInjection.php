<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\DocComment\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;

final readonly class DocCommentInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '/(?<match>\/\*\*(.|\n)*?\*\/)/m';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return $highlighter->parse($content, 'doc');
    }
}
