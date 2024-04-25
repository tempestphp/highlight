<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Diff\Injections;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\ParsedInjection;

class DiffDeletionInjection
{
    public function parse(string $content, Highlighter $highlighter): ParsedInjection
    {
        $content = preg_replace_callback(
            '/^\-(.*)$/m', // Matches lines starting with '+'
            function ($matches) {
                $open = Escape::tokens('<span class="hl-deletion">- ');
                $close = Escape::tokens('</span>');

                return $open . $matches[1] . $close; // Wraps the matched line with the span
            },
            $content
        );

        return new ParsedInjection($content);
    }
}
