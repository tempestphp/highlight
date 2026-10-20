<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tokens;

final readonly class GroupTokens
{
    /**
     * @param Token[] $tokens
     * @return Token[]
     */
    public function __invoke(array $tokens): array
    {
        $count = count($tokens);

        if ($count <= 1) {
            return $tokens;
        }

        // Sort tokens in the right order
        $tokens = $this->sortTokens($tokens);

        // Group tokens by parent and child
        /** @var Token[] $groupedTokens */
        $groupedTokens = [];
        $removed = [];

        for ($i = 0; $i < $count; $i++) {
            if (isset($removed[$i])) {
                continue;
            }

            $token = $tokens[$i];
            $token->children = [];
            $token->parent = null;
            $tokenEnd = $token->end;

            // Since tokens are sorted by start, only check subsequent tokens
            // that could overlap (start < token->end)
            for ($j = $i + 1; $j < $count; $j++) {
                if (isset($removed[$j])) {
                    continue;
                }

                $compareToken = $tokens[$j];

                // Since tokens are sorted by start position,
                // once compareToken->start >= token->end, no more overlaps possible
                if ($compareToken->start >= $tokenEnd) {
                    break;
                }

                // At this point we know: token->start <= compareToken->start < token->end
                // and they are not equal (different indices, and sorted order means
                // same-start tokens differ in end). This means containsOrOverlaps is true.
                if ($token->canContain($compareToken)) {
                    $token->addChild($compareToken);
                }

                $removed[$j] = true;
            }

            if (! $token->parent instanceof Token) {
                $groupedTokens[] = $token;
            }
        }

        return $groupedTokens;
    }

    /**
     * Sort tokens by start position ascending, then by end position descending,
     * so that longer/parent tokens come before shorter/child tokens at the same start.
     *
     * Ties keep their original order.
     *
     * @param Token[] $tokens
     * @return Token[]
     */
    private function sortTokens(array $tokens): array
    {
        $low = PHP_INT_MAX;
        $high = PHP_INT_MIN;

        foreach ($tokens as $token) {
            if ($token->start < $low) {
                $low = $token->start;
            }

            if ($token->end < $low) {
                $low = $token->end;
            }

            if ($token->start > $high) {
                $high = $token->start;
            }

            if ($token->end > $high) {
                $high = $token->end;
            }
        }

        $range = $high - $low + 1;

        // One packed key per token uses far less memory than array_multisort over four arrays.
        // Both key parts lie in [0, $range), so a key is unique per (start, end) and below $range ** 2.
        if ($range <= (int) sqrt(PHP_INT_MAX) && array_is_list($tokens)) {
            $keys = [];

            foreach ($tokens as $token) {
                $keys[] = ($token->start - $low) * $range + ($high - $token->end);
            }

            asort($keys, SORT_NUMERIC);

            $sorted = [];

            foreach ($keys as $index => $key) {
                $sorted[] = $tokens[$index];
            }

            return $sorted;
        }

        $starts = [];
        $negatedEnds = [];
        $indices = [];

        foreach ($tokens as $index => $token) {
            $starts[] = $token->start;
            $negatedEnds[] = -$token->end;
            $indices[] = $index;
        }

        array_multisort(
            $starts,
            SORT_ASC,
            SORT_NUMERIC,
            $negatedEnds,
            SORT_ASC,
            SORT_NUMERIC,
            $indices,
            SORT_ASC,
            SORT_NUMERIC,
            $tokens,
        );

        return $tokens;
    }
}
