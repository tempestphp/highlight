<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Base\Injections;

use Tempest\Highlight\After;
use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\ParsedInjection;
use Tempest\Highlight\RequiresSubstring;

#[After]
#[RequiresSubstring('{-', '-}', "\r")]
final readonly class DeletionInjection implements Injection
{
    private const string NEWLINE = "\n";

    public function parse(string $content, Highlighter $highlighter): ParsedInjection
    {
        $content = $this->normalizeLineEndings($content);

        $content = str_replace('❷span class=❹ignore❹❸{-❷/span❸', '{-', $content);
        $content = str_replace('❷span class=❹ignore❹❸-}❷/span❸', '-}', $content);

        $firstOpener = strpos($content, '{-');
        $lastCloser = $firstOpener === false ? false : strrpos($content, '-}', $firstOpener);

        while ($lastCloser !== false && ($content[$lastCloser + 2] ?? '') === '}') {
            $lastCloser = $lastCloser > 0 ? strrpos($content, '-}', $lastCloser - 1 - strlen($content)) : false;
        }

        if ($lastCloser === false) {
            return new ParsedInjection($content);
        }

        // No match can end after the last valid closer, so unclosed openers past it are never rescanned to the end.
        // The extra byte keeps the closer's (?!}) lookahead seeing the same character.
        preg_match_all('/(?<!\{)(\{-)(?!-)([\s\S]*?)(-})(?!})/', substr($content, 0, $lastCloser + 3), $matches, PREG_OFFSET_CAPTURE);

        $parsedContent = '';
        $parsedUntil = 0;
        $startingLineNumber = 1;
        $linesCountedUntil = 0;

        $open = Escape::tokens('<span class="hl-deletion">');
        $close = Escape::tokens('</span>');

        foreach ($matches[0] as [$matchedContent, $offset]) {
            $parsedMatchedContent = str_replace(
                ['{-', self::NEWLINE, '-}'],
                [$open, $close . self::NEWLINE . $open, $close],
                $matchedContent,
            );

            if (($gutter = $highlighter->getGutterInjection()) instanceof GutterInjection) {
                $startingLineNumber += substr_count(
                    haystack: $content,
                    needle: self::NEWLINE,
                    offset: $linesCountedUntil,
                    length: $offset - $linesCountedUntil,
                );

                $linesCountedUntil = $offset;

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

            $parsedContent .= substr($content, $parsedUntil, $offset - $parsedUntil) . $parsedMatchedContent;
            $parsedUntil = $offset + strlen($matchedContent);
        }

        return new ParsedInjection($parsedContent . substr($content, $parsedUntil));
    }

    private function normalizeLineEndings(string $content): string
    {
        if (! str_contains($content, "\r")) {
            return $content;
        }

        return str_replace(["\r\n", "\r"], self::NEWLINE, $content);
    }
}
