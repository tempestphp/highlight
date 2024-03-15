<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Blade\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;

final readonly class BladePhpInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '\@php(?<match>(.|\n)*?)\@endphp';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return $highlighter->parse($content, 'php');
    }
}
