<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Base\Injections;

use Tempest\Highlight\After;
use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;

#[After]
final readonly class AdditionInjection implements Injection
{
    public function parse(string $content, Highlighter $highlighter): string
    {
        preg_match_all('/(?<match>\{\+)/', $content, $matches, PREG_OFFSET_CAPTURE);

        $parsedOffset = 0;

        foreach ($matches['match'] as $match) {
            $span = Escape::tokens('<span class="hl-addition">');

            $content = substr_replace(
                string: $content,
                replace: $span,
                offset: $match[1] + $parsedOffset,
                length: strlen($match[0]),
            );

            if ($gutter = $highlighter->getGutterInjection()) {
                $lineNumber = substr_count(
                        haystack: $content,
                        needle: PHP_EOL,
                        length: $match[1] + $parsedOffset,
                    ) + 1;

                $gutter
                    ->addIcon($lineNumber, '+')
                    ->addClass($lineNumber, 'hl-gutter-addition');
            }

            $parsedOffset += strlen($span) - strlen($match[0]);
        }

        return str_replace(
            '+}',
            Escape::tokens('</span>'),
            $content,
        );
    }
}
