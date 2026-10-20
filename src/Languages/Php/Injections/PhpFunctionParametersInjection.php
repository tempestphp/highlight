<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Injections;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\Languages\Php\PhpTypeLanguage;
use Tempest\Highlight\RequiresSubstring;

#[RequiresSubstring('function', 'fn')]
final readonly class PhpFunctionParametersInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        // (*COMMIT) stops the search when an opener has no closer: later openers cannot have one either.
        return '(function|fn)[\s\w]*\((*COMMIT)(?<match>[\s\S]*?)(use\s*\(|{|\)[\s]*({|;|:|=>))';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return Escape::injection(
            $highlighter->parse($content, $this->getLanguage())
        );
    }

    private function getLanguage(): PhpTypeLanguage
    {
        static $language = null;

        return $language ??= new PhpTypeLanguage();
    }
}
