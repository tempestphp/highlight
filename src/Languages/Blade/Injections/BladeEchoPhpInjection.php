<?php

namespace Tempest\Highlight\Languages\Blade\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\Languages\Php\PhpLanguage;

final class BladeEchoPhpInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '({{|{!!)(?<match>.*?)(!!}|}})';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return $highlighter->parse($content, new PhpLanguage());
    }
}