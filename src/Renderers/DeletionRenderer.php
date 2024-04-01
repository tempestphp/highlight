<?php

namespace Tempest\Highlight\Renderers;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Renderer;
use Tempest\Highlight\WithGutter;

final class DeletionRenderer implements Renderer, WithGutter
{
    private ?GutterRenderer $gutterRenderer = null;

    public function setGutter(GutterRenderer $gutterRenderer): void
    {
        $this->gutterRenderer = $gutterRenderer;
    }

    public function render(string $content): string
    {
        preg_match_all('/(?<match>\{\-)/', $content, $matches, PREG_OFFSET_CAPTURE);

        $parsedOffset = 0;

        foreach ($matches['match'] as $match) {
            $span = Escape::tokens('<span class="hl-deletion">');

            $content = substr_replace(
                string: $content,
                replace: $span,
                offset: $match[1] + $parsedOffset,
                length: strlen($match[0]),
            );

            if ($this->gutterRenderer) {
                $lineNumber = substr_count(
                        haystack: $content,
                        needle: PHP_EOL,
                        length: $match[1] + $parsedOffset,
                    ) + 1;

                $this->gutterRenderer
                    ->addIcon($lineNumber, '-')
                    ->addClass($lineNumber, 'hl-gutter-deletion');
            }

            $parsedOffset += strlen($span) - strlen($match[0]);
        }

        return str_replace(
            '-}',
            Escape::tokens('</span>'),
            $content,
        );
    }
}