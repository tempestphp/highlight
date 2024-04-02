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
        preg_match_all('/(\{\+)((.|\n)*?)(\+})/', $content, $matches, PREG_OFFSET_CAPTURE);

        foreach ($matches[0] as $match) {
            $matchedContent = $match[0];
            $offset = $match[1];

            $open = Escape::tokens('<span class="hl-addition">');
            $close = Escape::tokens('</span>');

            // Replace tags + EOLs with appropriate span tags
            $parsedMatchedContent = str_replace(
                ['{+', PHP_EOL, '+}'],
                [$open, $close . PHP_EOL . $open, $close],
                $matchedContent,
            );

            // Inject the parsed match into the content
            $content = str_replace($matchedContent, $parsedMatchedContent, $content);

            // Configure the gutter,
            if ($gutter = $highlighter->getGutterInjection()) {
                $startingLineNumber = substr_count(
                    haystack: $content,
                    needle: PHP_EOL,
                    length: $offset,
                ) + 1;

                $totalAmountOfLines = substr_count(
                    haystack: $parsedMatchedContent,
                    needle: PHP_EOL,
                ) + 1;

                for ($lineNumber = $startingLineNumber; $lineNumber < $startingLineNumber + $totalAmountOfLines; $lineNumber++) {
                    $gutter
                        ->addIcon($lineNumber, '+')
                        ->addClass($lineNumber, 'hl-gutter-addition');
                }
            }
        }

        return $content;
    }
}
