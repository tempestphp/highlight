<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tokens;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Theme;

final class RenderTokens
{
    public function __construct(
        private Theme $theme,
    ) {
    }

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

        $output = $content;

        foreach ($groupedTokens as $currentToken) {
            $value = $currentToken->hasChildren()
                ? ($this)(
                    content: $currentToken->value,
                    tokens: $currentToken->children,
                    parsedOffset: -1 * $currentToken->offset,
                )
                : $currentToken->value;

            $renderedToken =
                Escape::tokens($this->theme->before($currentToken->type))
                . $value
                . Escape::tokens($this->theme->after($currentToken->type));

            $output = substr_replace(
                $output,
                $renderedToken,
                $currentToken->offset + $parsedOffset,
                $currentToken->length,
            );

            foreach ($currentToken->children as $childToken) {
                $parsedOffset +=
                    strlen(Escape::tokens($this->theme->before($childToken->type)))
                    + strlen(Escape::tokens($this->theme->after($childToken->type)));
            }

            $parsedOffset +=
                strlen(Escape::tokens($this->theme->before($currentToken->type)))
                + strlen(Escape::tokens($this->theme->after($currentToken->type)));
        }

        return $output;
    }
}
