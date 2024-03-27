<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\Languages\Php\PhpDocCommentLanguage;

final readonly class PhpDocCommentInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '/(?<match>\/\*\*(.|\n)*?\*\/)/m';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return $highlighter->parse($content, new PhpDocCommentLanguage());
    }
}
