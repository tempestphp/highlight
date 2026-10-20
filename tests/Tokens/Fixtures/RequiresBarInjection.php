<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Tokens\Fixtures;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\RequiresSubstring;

/** Deliberately declares a substring its regex does not need, so skipping it is visible in the output. */
#[RequiresSubstring('bar')]
class RequiresBarInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '(?<match>foo)';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        return strtoupper($content);
    }
}
