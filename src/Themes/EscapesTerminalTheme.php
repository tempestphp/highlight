<?php

declare(strict_types=1);

namespace Tempest\Highlight\Themes;

use Tempest\Highlight\Escape;

trait EscapesTerminalTheme
{
    public function escape(string $content): string
    {
        return Escape::terminal($content);
    }
}
