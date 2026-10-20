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
        $this->sortTokens($tokens);

        // Group tokens by parent and child
        /** @var Token[] $groupedTokens */
        $groupedTokens = [];
        $removed = [];

        for ($i = 0; $i < $count; $i++) {
            if (isset($removed[$i])) {
                continue;
            }

            $token = $tokens[$i];
            $token->resetHierarchy();
            $tokenEnd = $token->end;
            $lastChildEnd = 0;
            $childrenOverlap = false;

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
                // A token that runs past the end of this one can't be nested in it,
                // so it's dropped like any other token that can't be contained.
                if (
                    $compareToken->end <= $tokenEnd
                    && $token->canContain($compareToken)
                ) {
                    if ($compareToken->start < $lastChildEnd) {
                        $childrenOverlap = true;
                    }

                    $lastChildEnd = max($lastChildEnd, $compareToken->end);

                    $token->addChild($compareToken);
                }

                $removed[$j] = true;
            }

            // Children can overlap each other as well (for example, a string and
            // the keywords inside it, both wrapped in {_ _}), so they need to be
            // grouped the same way before they can be rendered.
            if ($childrenOverlap) {
                $children = $token->children;
                $token->children = [];

                foreach ($this($children) as $child) {
                    $token->addChild($child);
                }
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
     * @param Token[] $tokens
     */
    private function sortTokens(array &$tokens): void
    {
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
    }
}
