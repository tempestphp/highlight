<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tokens;

final readonly class GroupTokens
{
    /**
     * @param \Tempest\Highlight\Tokens\Token[] $tokens
     * @return \Tempest\Highlight\Tokens\Token[]
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
        /** @var \Tempest\Highlight\Tokens\Token[] $groupedTokens */
        $groupedTokens = [];

        while ($token = current($tokens)) {
            $token = $token->cloneWithoutParent();

            foreach ($tokens as $compareKey => $compareToken) {
                if ($token->equals($compareToken)) {
                    continue;
                }

                if ($token->containsOrOverlaps($compareToken)) {
                    if ($token->canContain($compareToken)) {
                        $token->addChild($compareToken);
                    }

                    unset($tokens[$compareKey]);
                }
            }

            if ($token->parent === null) {
                $groupedTokens[] = $token;
            }

            next($tokens);
        }

        return $groupedTokens;
    }
}
