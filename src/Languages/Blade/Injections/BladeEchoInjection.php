<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Blade\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;

final readonly class BladeEchoInjection implements Injection
{
    use IsInjection;

    #[\Override]
    public function getPattern(): string
    {
        return '({{(?!--))(?<match>.*)(}})';
    }

    #[\Override]
    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return $highlighter->parse($content, 'php');
    }
}
