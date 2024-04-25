<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Diff\Injections;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\ParsedInjection;

class DiffAdditionInjection
{
    public function parse(string $content, Highlighter $highlighter): ParsedInjection
    {
        $content = preg_replace_callback(
            '/^\+(.*)$/m',
            function ($matches) {
                $open = Escape::tokens('<span class="hl-addition">+ ');
                $close = Escape::tokens('</span>');

                return $open . $matches[1] . $close;
            },
            $content
        );

        return new ParsedInjection($content);
    }
}
