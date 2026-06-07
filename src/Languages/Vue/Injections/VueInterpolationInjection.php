<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Vue\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\PatternTest;

#[PatternTest(input: '{{ name }}', output: ' name ')]
#[PatternTest(input: '{{ user.id }}', output: ' user.id ')]
#[PatternTest(input: '{{ count + 1 }}', output: ' count + 1 ')]
final class VueInterpolationInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '\{\{(?<match>[\s\S]*?)\}\}';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return $highlighter->parse($content, 'typescript');
    }
}
