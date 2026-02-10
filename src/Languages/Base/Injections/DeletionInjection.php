<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Base\Injections;

use Tempest\Highlight\After;
use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\ParsedInjection;

#[After]
final readonly class DeletionInjection implements Injection
{
    private const string NEWLINE = "\n";

    public function parse(string $content, Highlighter $highlighter): ParsedInjection
    {
        $content = $this->normalizeLineEndings($content);

        $content = str_replace('❷span class=❹ignore❹❸{-❷/span❸', '{-', $content);
        $content = str_replace('❷span class=❹ignore❹❸-}❷/span❸', '-}', $content);

        preg_match_all('/(\{-)(?!-)((.|\n)*?)(-})/', $content, $matches, PREG_OFFSET_CAPTURE);

        $parsedOffset = 0;

        $open = Escape::tokens('<span class="hl-deletion">');
        $close = Escape::tokens('</span>');

        foreach ($matches[0] as $match) {
            $matchedContent = $match[0];
            $offset = $match[1];
            $replacementOffset = $offset + $parsedOffset;

            $parsedMatchedContent = str_replace(
                ['{-', self::NEWLINE, '-}'],
                [$open, $close . self::NEWLINE . $open, $close],
                $matchedContent,
            );

            if (($gutter = $highlighter->getGutterInjection()) instanceof GutterInjection) {
                $startingLineNumber = substr_count(
                    haystack: $content,
                    needle: self::NEWLINE,
                    length: $replacementOffset,
                ) + 1;

                $totalAmountOfLines = substr_count(
                    haystack: $parsedMatchedContent,
                    needle: self::NEWLINE,
                ) + 1;

                for ($lineNumber = $startingLineNumber; $lineNumber < $startingLineNumber + $totalAmountOfLines; $lineNumber++) {
                    $gutter
                        ->addIcon($lineNumber, '-')
                        ->addClass($lineNumber, 'hl-gutter-deletion');
                }
            }

            $content = substr_replace(
                $content,
                $parsedMatchedContent,
                $replacementOffset,
                strlen($matchedContent),
            );

            $parsedOffset += strlen($parsedMatchedContent) - strlen($matchedContent);
        }

        return new ParsedInjection($content);
    }

    private function normalizeLineEndings(string $content): string
    {
        if (! str_contains($content, "\r")) {
            return $content;
        }

        return str_replace(["\r\n", "\r"], self::NEWLINE, $content);
    }
}
