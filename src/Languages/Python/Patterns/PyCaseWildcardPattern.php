<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Python\Patterns;

use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\RequiresSubstring;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'case _:', output: '_')]
#[PatternTest(input: "match x:\n    case [y, *_] if _:\n        return _", output: '_')]
#[PatternTest(input: "if x:\n    case _:", output: null)]
#[PatternTest(input: "# Special case\n_: int = 1", output: null)]
#[RequiresSubstring('case')]
final readonly class PyCaseWildcardPattern implements Pattern
{
    /**
     * Finds `_` wildcards in the patterns of `case` clauses whose enclosing block is a `match` statement (or the snippet's top level).
     */
    public function match(string $content): array
    {
        if (! preg_match('/(?:^|(?<=[\r\n]))[ \t\f]*+case(?![\w\x80-\xff])/', $content)) {
            return ['match' => []];
        }

        $strings = $this->multiLineStrings($content);
        $string = 0;
        $wildcards = [];
        $blocks = [];
        $scannedUntil = 0;
        $length = strlen($content);
        $lineStart = 0;

        while ($lineStart < $length) {
            while (isset($strings[$string]) && $strings[$string][1] <= $lineStart) {
                $string++;
            }

            $insideString = ($strings[$string][0] ?? $lineStart) < $lineStart;

            // Lines that continue an earlier header, clause or string are not statements and do not affect indentation
            if ($insideString || $lineStart < $scannedUntil) {
                $lineStart = $this->nextLine($content, max($scannedUntil, $insideString ? $strings[$string][1] : 0));

                continue;
            }

            $indentLength = strspn($content, " \t\f", $lineStart);
            $first = $lineStart + $indentLength;

            if (str_contains("#\r\n", $content[$first] ?? "\n")) {
                $lineStart = $this->nextLine($content, $first);

                continue;
            }

            $indent = $this->indentWidth(substr($content, $lineStart, $indentLength));

            while ($blocks !== [] && $blocks[array_key_last($blocks)][0] >= $indent) {
                array_pop($blocks);
            }

            $enclosedByMatch = $blocks === [] || $blocks[array_key_last($blocks)][1];
            $isMatchHeader = false;

            if (preg_match('/\G(?:match|case)(?![\w\x80-\xff])/', $content, $keyword, 0, $first)) {
                [$scannedUntil, $isStatement, $clauseWildcards] = $this->scan($content, $first + strlen($keyword[0]), $keyword[0] === 'case');

                if ($keyword[0] === 'match') {
                    $isMatchHeader = $isStatement;
                } elseif ($isStatement && $enclosedByMatch) {
                    array_push($wildcards, ...$clauseWildcards);
                }
            }

            $blocks[] = [$indent, $isMatchHeader];
            $lineStart = $this->nextLine($content, max($first, $scannedUntil));
        }

        return ['match' => $wildcards];
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }

    /**
     * Scans a `match` or `case` header from just after its keyword up to its top-level colon.
     *
     * @return array{int, bool, array<int, array{string, int}>}
     */
    private function scan(string $content, int $index, bool $inPattern): array
    {
        $index += strspn($content, " \t\f", $index);

        if (str_contains("=.:)]},#\r\n", $content[$index] ?? "\n")) {
            return [$index, false, []];
        }

        $length = strlen($content);
        $depth = 0;
        $previous = '';
        $wildcards = [];

        while ($index < $length) {
            $char = $content[$index];

            if ($char === ' ' || $char === "\t" || $char === "\f") {
                $index++;

                continue;
            }

            if ($char === "\n" || $char === "\r") {
                if ($depth === 0) {
                    return [$index, false, []];
                }

                $index++;

                continue;
            }

            if ($char === '#') {
                $index += strcspn($content, "\r\n", $index);

                continue;
            }

            if ($char === '\\') {
                $index = $this->skipEscape($content, $index);

                continue;
            }

            if ($char === ':' && $depth === 0) {
                return [$index, true, $wildcards];
            }

            if ($char === '"' || $char === "'") {
                $index = $this->skipString($content, $index);
                $previous = '"';

                continue;
            }

            if (preg_match('/\G[\w\x80-\xff]+/', $content, $word, 0, $index)) {
                $word = $word[0];
                $next = $index + strlen($word);

                if (($content[$next] ?? '') === '"' || ($content[$next] ?? '') === "'") {
                    if (preg_match('/^[rbuft]{1,2}$/i', $word)) {
                        $index = $this->skipString($content, $next);
                        $previous = '"';

                        continue;
                    }
                }

                if ($word === 'if' && $depth === 0) {
                    $inPattern = false;
                } elseif ($inPattern && $word === '_' && $previous !== '.' && ! preg_match('/\G[ \t\f]*(?:=(?!=)|\.)/', $content, $nameOrAttribute, 0, $next)) {
                    $wildcards[] = ['_', $index];
                }

                $index = $next;
                $previous = 'a';

                continue;
            }

            // A pattern never assigns, calls or subscripts at the top level, so this is an ordinary statement using `case` as a name
            if ($inPattern && $depth === 0 && (
                ($char === '=' && $previous !== '=' && ($content[$index + 1] ?? '') !== '=')
                || (($char === '(' || $char === '[') && in_array($previous, [')', ']', '}'], true))
            )) {
                return [$index, false, []];
            }

            if ($char === '(' || $char === '[' || $char === '{') {
                $depth++;
            } elseif ($char === ')' || $char === ']' || $char === '}') {
                $depth = max(0, $depth - 1);
            }

            $previous = $char;
            $index++;
        }

        return [$index, false, []];
    }

    /**
     * @return array<int, array{int, int}> start and end offsets of the strings that span several lines
     */
    private function multiLineStrings(string $content): array
    {
        // Comments and single-line strings are skipped, so only strings that may span lines are returned
        preg_match_all(
            <<<'REGEX'
            /
                (?: \#[^\r\n]*+
                  | "(?!"")(?:[^"\\\r\n]++|\\[^\r\n])*+(?:"|(?=[\r\n]|\z))
                  | '(?!'')(?:[^'\\\r\n]++|\\[^\r\n])*+(?:'|(?=[\r\n]|\z))
                ) (*SKIP)(*FAIL)
              | """(?:[^"\\]++|\\[\s\S]?|"(?!""))*+(?:"""|\z)
              | '''(?:[^'\\]++|\\[\s\S]?|'(?!''))*+(?:'''|\z)
              | "(?:[^"\\\r\n]++|\\[\s\S]?)*+"?
              | '(?:[^'\\\r\n]++|\\[\s\S]?)*+'?
            /x
            REGEX,
            $content,
            $tokens,
            PREG_OFFSET_CAPTURE,
        );

        $strings = [];

        foreach ($tokens[0] as [$token, $offset]) {
            if (strpbrk($token, "\r\n") !== false) {
                $strings[] = [$offset, $offset + strlen($token)];
            }
        }

        return $strings;
    }

    private function skipString(string $content, int $index): int
    {
        $quote = $content[$index];
        $delimiter = substr($content, $index, 3) === $quote . $quote . $quote ? $quote . $quote . $quote : $quote;
        $index += strlen($delimiter);
        $length = strlen($content);

        while ($index < $length) {
            $index += strcspn($content, "\\\r\n" . $quote, $index);
            $char = $content[$index] ?? '';

            if ($char === '\\') {
                $index = $this->skipEscape($content, $index);
            } elseif ($char !== $quote) {
                // An unterminated single-line string ends at the newline
                if ($delimiter === $quote) {
                    return $index;
                }

                $index++;
            } elseif (substr_compare($content, $delimiter, $index, strlen($delimiter)) === 0) {
                return $index + strlen($delimiter);
            } else {
                $index++;
            }
        }

        return $length;
    }

    private function nextLine(string $content, int $offset): int
    {
        $offset += strcspn($content, "\r\n", $offset);

        return $offset + (substr($content, $offset, 2) === "\r\n" ? 2 : 1);
    }

    private function skipEscape(string $content, int $index): int
    {
        return $index + (substr_compare($content, "\\\r\n", $index, 3) === 0 ? 3 : 2);
    }

    private function indentWidth(string $indentation): int
    {
        $width = 0;

        for ($i = 0, $length = strlen($indentation); $i < $length; $i++) {
            $width = match ($indentation[$i]) {
                "\t" => intdiv($width, 8) * 8 + 8,
                "\f" => 0,
                default => $width + 1,
            };
        }

        return $width;
    }
}
