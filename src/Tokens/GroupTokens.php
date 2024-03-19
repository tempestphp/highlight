<?php

namespace Tempest\Highlight\Tokens;

final readonly class GroupTokens
{
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

        while($token = current($tokens)) {
            $token = $token->cloneWithoutParent();

            foreach ($tokens as $compareKey => $compareToken) {
                if ($token->contains($compareToken)) {
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