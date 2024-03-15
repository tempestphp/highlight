<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tokens;

final class RenderTokens
{
    /**
     * @param string $content
     * @param \Tempest\Highlight\Tokens\Token[] $tokens
     * @param int $parsedOffset
     * @return string
     */
    public function __invoke(
        string $content,
        array $tokens,
        int $parsedOffset = 0
    ): string {
        usort($tokens, fn (Token $a, Token $b) => $a->offset <=> $b->offset);

        /** @var \Tempest\Highlight\Tokens\Token[] $groupedTokens */
        $groupedTokens = [];

        while($token = current($tokens)) {
            $token = $token->cloneWithoutParent();

            foreach ($tokens as $compareKey => $compareToken) {
                if ($token->contains($compareToken)) {
                    $token->addChild($compareToken);
                    unset($tokens[$compareKey]);
                }
            }

            if ($token->parent === null) {
                $groupedTokens[] = $token;
            }

            next($tokens);
        }

        $output = $content;

        foreach ($groupedTokens as $currentToken) {
            $value = $currentToken->hasChildren()
                ? ($this)(
                    content: $currentToken->value,
                    tokens: $currentToken->children,
                    parsedOffset: -1 * $currentToken->offset,
                )
                : $currentToken->value;

            $renderedToken = $currentToken->before() . $value . $currentToken->after();

            $output = substr_replace(
                $output,
                $renderedToken,
                $currentToken->offset + $parsedOffset,
                $currentToken->length,
            );

            foreach ($currentToken->children as $childToken) {
                $parsedOffset += strlen($childToken->before()) + strlen($childToken->after());
            }

            $parsedOffset += strlen($currentToken->before()) + strlen($currentToken->after());
        }

        //        dd($output);

        return $output;
    }
}
