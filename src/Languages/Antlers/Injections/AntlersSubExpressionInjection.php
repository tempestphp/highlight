<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Antlers\Injections;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\Languages\Antlers\AntlersLanguage;

final readonly class AntlersSubExpressionInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        /** @lang PhpRegExp */
        return '/{{(?![#?$])[^{}]*(?<match>{[^{}]*})[^{}]*}}/m';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        // Fake the sub expression { } to a full antlers tag {{ }}
        $parsed = $highlighter->parse('{'.$content.'}', new AntlersLanguage());
        $parsed = substr($parsed, 1, -1);

        return Escape::injection($parsed);
    }
}
