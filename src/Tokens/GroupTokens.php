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
        // Sort tokens in the right order
        usort($tokens, function (Token $a, Token $b) {
            if ($a->start === $b->start) {
                return $b->end <=> $a->end;
            }

            return $a->start <=> $b->start;
        });

        // Group tokens by parent and child
        /** @var Token[] $groupedTokens */
        $groupedTokens = [];

        $count = count($tokens);
        $removed = [];
        for ($i = 0; $i < $count; $i++) {
            if (isset($removed[$i])) {
                continue;
            }

            $token = $tokens[$i]->cloneWithoutParent();

            // Since tokens are sorted by start, only check subsequent tokens
            // that could overlap (start < token->end)
            for ($j = $i + 1; $j < $count; $j++) {
                if (isset($removed[$j])) {
                    continue;
                }

                $compareToken = $tokens[$j];

                // Since tokens are sorted by start position,
                // once compareToken->start >= token->end, no more overlaps possible
                if ($compareToken->start >= $token->end) {
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

            if ($token->parent === null) {
                $groupedTokens[] = $token;
            }
        }

        return $groupedTokens;
    }
}
