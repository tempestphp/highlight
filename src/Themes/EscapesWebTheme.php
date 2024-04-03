<?php

declare(strict_types=1);

namespace Tempest\Highlight\Themes;

use Tempest\Highlight\Escape;

trait EscapesWebTheme
{
    public function escape(string $content): string
    {
        return Escape::html($content);
    }
}
