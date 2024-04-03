<?php

declare(strict_types=1);

namespace Tempest\Highlight;

interface Injection
{
    public function parse(string $content, Highlighter $highlighter): ParsedInjection;
}
