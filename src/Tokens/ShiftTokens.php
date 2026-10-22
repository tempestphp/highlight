<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tokens;

use Tempest\Highlight\Escape;

/**
 * Moves tokens found by earlier injections (like {_ _} or {:class: :}) so that they
 * still point to the same code after a later injection rewrote parts of the content.
 */
final readonly class ShiftTokens
{
    /**
     * @param Token[] $tokens
     * @param array<array{int, int, int}> $replacements Offset and length in the old content, and the length of what replaced it
     * @return Token[]
     */
    public function __invoke(array $tokens, array $replacements, string $oldContent, string $newContent): array
    {
        $markerPairs = $this->getMarkerPairs($tokens);
        $alignments = [];
        $shiftedTokens = [];

        foreach ($tokens as $token) {
            $range = $this->shift($token, $replacements, $oldContent, $newContent, $markerPairs[spl_object_id($token)] ?? null, $alignments);

            if ($range === null) {
                continue;
            }

            [$start, $end] = $range;

            $shiftedTokens[] = new Token(
                offset: $start,
                value: substr($newContent, $start, $end - $start),
                type: $token->type,
                pattern: $token->pattern,
            );
        }

        return $shiftedTokens;
    }

    /**
     * Markers like {_ _} create three tokens: the hidden opening marker, the highlighted code, and the hidden closing marker.
     * This returns the range covered by all three, for each of those tokens.
     *
     * @param Token[] $tokens
     * @return array<int, array{int, int}>
     */
    private function getMarkerPairs(array $tokens): array
    {
        $markersByStart = [];
        $markersByEnd = [];

        foreach ($tokens as $token) {
            if ($token->type === TokenTypeEnum::HIDDEN) {
                $markersByStart[$token->start] = $token;
                $markersByEnd[$token->end] = $token;
            }
        }

        $markerPairs = [];

        foreach ($tokens as $token) {
            if (! $token->type instanceof DynamicTokenType) {
                continue;
            }

            $opening = $markersByEnd[$token->start] ?? null;
            $closing = $markersByStart[$token->end] ?? null;

            if ($opening === null || $closing === null) {
                continue;
            }

            $range = [$opening->start, $closing->end];

            $markerPairs[spl_object_id($opening)] = $range;
            $markerPairs[spl_object_id($token)] = $range;
            $markerPairs[spl_object_id($closing)] = $range;
        }

        return $markerPairs;
    }

    /**
     * @param array<array{int, int, int}> $replacements
     * @param array{int, int}|null $markerPair
     * @param array<int, array<int, int>|null> $alignments
     * @return array{int, int}|null
     */
    private function shift(Token $token, array $replacements, string $oldContent, string $newContent, ?array $markerPair, array &$alignments): ?array
    {
        $isHighlight = $token->type === TokenTypeEnum::HIDDEN || $token->type instanceof DynamicTokenType;
        $delta = 0;
        $start = null;
        $end = null;
        $startIsMapped = false;
        $endIsMapped = false;

        foreach ($replacements as $index => [$offset, $oldLength, $newLength]) {
            $replacementEnd = $offset + $oldLength;

            // Both markers of a pair like {_ _} are part of the rewritten code, so the injection has already highlighted them
            if ($markerPair !== null && $markerPair[0] >= $offset && $markerPair[1] <= $replacementEnd) {
                return null;
            }

            if ($start === null && $token->start < $replacementEnd) {
                // A token that starts right where the rewritten code starts, but ends inside of it,
                // is moved inside of the rewritten code as a whole.
                $startsInside = $token->start > $offset
                    || ($token->start === $offset && $token->end < $replacementEnd);

                if (! $startsInside) {
                    $start = $token->start + $delta;
                } else {
                    // The token starts inside the rewritten code. Custom classes don't have their delimiters anymore,
                    // and a marker without its other half wasn't highlighted by the injection, so they are moved onto the rewritten code.
                    $alignment = $isHighlight ? $this->getAlignment($index, $replacements, $oldContent, $newContent, $alignments) : null;

                    if ($alignment === null) {
                        return null;
                    }

                    $start = $offset + $delta + $alignment[$token->start - $offset];
                    $startIsMapped = true;
                }
            }

            if ($token->end <= $offset) {
                $end = $token->end + $delta;

                break;
            }

            if ($token->end < $replacementEnd || ($startIsMapped && $token->end === $replacementEnd)) {
                // The token ends inside the rewritten code
                $alignment = $isHighlight ? $this->getAlignment($index, $replacements, $oldContent, $newContent, $alignments) : null;

                if ($alignment === null) {
                    return null;
                }

                $end = $offset + $delta + $alignment[$token->end - $offset - 1] + 1;
                $endIsMapped = true;

                break;
            }

            $delta += $newLength - $oldLength;
        }

        $start ??= $token->start + $delta;
        $end ??= $token->end + $delta;

        if (! $startIsMapped && ! $endIsMapped) {
            return [$start, $end];
        }

        if ($this->isBalanced(substr($newContent, $start, $end - $start))) {
            return [$start, $end];
        }

        // Include the opening markup right before the token and the closing markup right after it,
        // for example when a custom class wraps several tokens that were highlighted by the injection.
        while ($startIsMapped && ($markupStart = $this->openingMarkupEndingAt($newContent, $start)) !== null) {
            $start = $markupStart;
        }

        while ($endIsMapped && ($markupEnd = $this->closingMarkupStartingAt($newContent, $end)) !== null) {
            $end = $markupEnd;
        }

        if ($this->isBalanced(substr($newContent, $start, $end - $start))) {
            return [$start, $end];
        }

        return null;
    }

    /**
     * The rewritten code is the original code with highlighting markup added to it,
     * so every position in the original code can be found back by skipping that markup.
     *
     * @param array<array{int, int, int}> $replacements
     * @param array<int, array<int, int>|null> $alignments
     * @return array<int, int>|null Positions in the rewritten code, by position in the original code
     */
    private function getAlignment(int $index, array $replacements, string $oldContent, string $newContent, array &$alignments): ?array
    {
        if (array_key_exists($index, $alignments)) {
            return $alignments[$index];
        }

        $delta = 0;

        for ($i = 0; $i < $index; $i++) {
            $delta += $replacements[$i][2] - $replacements[$i][1];
        }

        [$offset, $oldLength, $newLength] = $replacements[$index];

        $original = substr($oldContent, $offset, $oldLength);
        $rewritten = substr($newContent, $offset + $delta, $newLength);

        $positions = [];
        $originalPosition = 0;
        $rewrittenPosition = 0;

        while ($rewrittenPosition < $newLength) {
            $markupEnd = $this->markupEndingAfter($rewritten, $rewrittenPosition);

            if ($markupEnd !== null) {
                $rewrittenPosition = $markupEnd;

                continue;
            }

            if (($original[$originalPosition] ?? null) !== $rewritten[$rewrittenPosition]) {
                return $alignments[$index] = null;
            }

            $positions[$originalPosition] = $rewrittenPosition;
            $originalPosition++;
            $rewrittenPosition++;
        }

        if ($originalPosition !== $oldLength) {
            return $alignments[$index] = null;
        }

        return $alignments[$index] = $positions;
    }

    private function markupEndingAfter(string $content, int $position): ?int
    {
        $character = substr($content, $position, 3);

        if ($character === Escape::INJECTION_TOKEN) {
            return $position + 3;
        }

        if ($character === '❷') {
            $tagEnd = strpos($content, '❸', $position);

            return $tagEnd === false ? null : $tagEnd + 3;
        }

        return null;
    }

    private function openingMarkupEndingAt(string $content, int $position): ?int
    {
        if ($position < 3) {
            return null;
        }

        $previous = substr($content, $position - 3, 3);

        if ($previous === Escape::INJECTION_TOKEN) {
            return $position - 3;
        }

        if ($previous === '❸') {
            $tagStart = strrpos(substr($content, 0, $position), '❷');

            if ($tagStart === false || substr($content, $tagStart, 4) === '❷/') {
                return null;
            }

            return $tagStart;
        }

        return null;
    }

    private function closingMarkupStartingAt(string $content, int $position): ?int
    {
        $next = substr($content, $position, 4);

        if (str_starts_with($next, Escape::INJECTION_TOKEN)) {
            return $position + 3;
        }

        if ($next === '❷/') {
            $tagEnd = strpos($content, '❸', $position);

            return $tagEnd === false ? null : $tagEnd + 3;
        }

        return null;
    }

    /**
     * Whether the markup inside this content is properly nested, so that it can be wrapped in another tag.
     */
    private function isBalanced(string $content): bool
    {
        $depth = 0;

        preg_match_all('/❷(\/?)/', $content, $tags);

        foreach ($tags[1] as $closing) {
            $depth += $closing === '/' ? -1 : 1;

            if ($depth < 0) {
                return false;
            }
        }

        return $depth === 0;
    }
}
