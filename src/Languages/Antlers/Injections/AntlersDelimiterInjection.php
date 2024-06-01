<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Antlers\Injections;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\Languages\Antlers\AntlersDelimitedLanguage;

final readonly class AntlersDelimiterInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        /** @lang PhpRegExp */
        return '/{{(?!(\?|\$))(?<match>.*?)(?<!(\?|\$))}}/s';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return Escape::injection(
            $highlighter->parse($content, new AntlersDelimitedLanguage())
        );
    }
}
