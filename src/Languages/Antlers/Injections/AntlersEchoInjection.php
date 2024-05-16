<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Antlers\Injections;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;

final readonly class AntlersEchoInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '({{\$)(?<match>.*)(\$}})';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return Escape::injection(
            $highlighter->parse($content, 'php')
        );
    }
}
