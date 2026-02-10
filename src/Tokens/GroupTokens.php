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

        $this->sortTokens($tokens);

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

            for ($j = $i + 1; $j < $count; $j++) {
                if (isset($removed[$j])) {
                    continue;
                }

                $compareToken = $tokens[$j];

                if ($compareToken->start >= $tokenEnd) {
                    break;
                }

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
