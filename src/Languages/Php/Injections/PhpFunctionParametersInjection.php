<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Injections;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\Languages\Php\PhpTypeLanguage;

final readonly class PhpFunctionParametersInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '(function|fn)[\s\w]*\((?<match>(.|\n)*?)({|\)[\s]*({|;|:|=>))';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return Escape::injection(
            $highlighter->parse($content, new PhpTypeLanguage())
        );
    }
}
