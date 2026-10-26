<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Base;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\ParsedInjection;
use Tempest\Highlight\Tokens\DynamicTokenType;
use Tempest\Highlight\Tokens\Token;
use Tempest\Highlight\Tokens\TokenTypeEnum;

trait IsHighlightInjection
{
    abstract private function getToken(): string;

    abstract private function getClassname(): string;

    public function parse(string $content, Highlighter $highlighter): ParsedInjection
    {
        $start = '{' . $this->getToken();
        $end = $this->getToken() . '}';

        $openers = $this->findOffsets('/' . preg_quote($start, '/') . '/', $content);
        $closers = $this->findOffsets('/' . preg_quote($end, '/') . '(?!})/', $content);

        $tokens = [];
        $openerIndex = 0;
        $closerIndex = 0;
        $cursor = 0;

        while ($openerIndex < count($openers)) {
            if ($openers[$openerIndex] < $cursor) {
                $openerIndex++;

                continue;
            }

            $contentStart = $openers[$openerIndex] + strlen($start);

            while ($closerIndex < count($closers) && $closers[$closerIndex] < $contentStart) {
                $closerIndex++;
            }

            if ($closerIndex === count($closers)) {
                break;
            }

            $closer = $closers[$closerIndex];

            // Every opener before this closer would end with it, the first one that is a real marker wins
            $candidates = [];

            while ($openerIndex < count($openers) && $openers[$openerIndex] + strlen($start) <= $closer) {
                $candidates[] = $openers[$openerIndex];
                $openerIndex++;
            }

            $opener = $this->findMarkerOpener($content, $candidates, strlen($start), $closer);

            if ($opener === null) {
                continue;
            }

            $contentStart = $opener + strlen($start);

            $tokens[] = new Token(
                offset: $opener,
                value: $start,
                type: TokenTypeEnum::HIDDEN,
            );

            $tokens[] = new Token(
                offset: $contentStart,
                value: substr($content, $contentStart, $closer - $contentStart),
                type: new DynamicTokenType($this->getClassname()),
            );

            $tokens[] = new Token(
                offset: $closer,
                value: $end,
                type: TokenTypeEnum::HIDDEN,
            );

            $cursor = $closer + strlen($end);
        }

        return new ParsedInjection(
            content: $content,
            tokens: $tokens,
        );
    }

    /**
     * @return int[]
     */
    private function findOffsets(string $pattern, string $content): array
    {
        preg_match_all($pattern, $content, $matches, PREG_OFFSET_CAPTURE);

        return array_map(static fn (array $match): int => (int)$match[1], $matches[0]);
    }

    /**
     * In code like `const {_id} = a; const {name_} = b;`, the brace of `{_` is closed by the code itself,
     * so the content between the delimiters leaves one pair of braces and ends inside another: `id} = a; const {name`.
     * Real markers can wrap an unbalanced `{` or `}`, and can start right before a closing brace
     * or end right after an opening brace, like around `} else {`.
     *
     * Brace depths are counted backwards from the closer, so that all openers are checked in a single scan.
     *
     * @param int[] $openers
     */
    private function findMarkerOpener(string $content, array $openers, int $openerLength, int $closer): ?int
    {
        $endsWithOpeningBrace = substr(rtrim(substr($content, $openers[0] + $openerLength, $closer - $openers[0] - $openerLength)), -1) === '{';

        $depth = 0;
        $lowestDepth = 0;
        $position = $closer;
        $isMarker = [];

        foreach (array_reverse($openers) as $opener) {
            $contentStart = $opener + $openerLength;

            while ($position > $contentStart) {
                $position--;

                if ($content[$position] === '{') {
                    $depth++;
                    $lowestDepth = min(0, $lowestDepth + 1);
                } elseif ($content[$position] === '}') {
                    $depth--;
                    $lowestDepth = min(0, $lowestDepth - 1);
                }
            }

            $leavesItsBraces = $lowestDepth < 0 && $depth > $lowestDepth;

            $isMarker[$opener] = ! $leavesItsBraces
                || $endsWithOpeningBrace
                || str_starts_with(ltrim(substr($content, $contentStart, 1 + strspn($content, " \t\r\n", $contentStart))), '}');
        }

        foreach ($openers as $opener) {
            if ($isMarker[$opener]) {
                return $opener;
            }
        }

        return null;
    }
}
