<?php

declare(strict_types=1);

namespace Tempest\Highlight;

interface WebTheme extends Theme
{
    public function preBefore(Highlighter $highlighter): string;

    public function preAfter(Highlighter $highlighter): string;
}
