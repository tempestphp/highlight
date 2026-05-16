<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Svelte\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\Languages\TypeScript\TypeScriptLanguage;
use Tempest\Highlight\PatternTest;

#[PatternTest(input: '{role}', output: 'role')]
#[PatternTest(input: '{role.id}', output: 'role.id')]
#[PatternTest(input: 'onclick={() => count++}', output: '() => count++')]
#[PatternTest(input: 'onclick={() => { updateTab() }}', output: '() => { updateTab() }')]
final class SvelteExpressionInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '\{(?<match>[^#@:\/{}](?:[^{}]++|\{(?&match)\})*+)\}';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return $highlighter->parse($content, 'typescript');
    }
}
