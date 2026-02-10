<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tokens;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Theme;

final class RenderTokens
{
    private array $tokenMarkup = [];
    private array $tokenMarkupLengths = [];

    public function __construct(
        private Theme $theme,
    ) {
    }

    /**
     * @param string $content
     * @param Token[] $tokens
     * @param int $parsedOffset
     * @return string
     */
    public function __invoke(
        string $content,
        array $tokens,
        int $parsedOffset = 0
    ): string {
        $output = $content;

        foreach ($tokens as $currentToken) {
            [$before, $after] = $this->getTokenMarkup($currentToken->type);

            $value = $currentToken->hasChildren()
                ? ($this)(
                    content: $currentToken->value,
                    tokens: $currentToken->children,
                    parsedOffset: -1 * $currentToken->offset,
                )
                : $currentToken->value;

            $renderedToken = $before . $value . $after;

            $output = substr_replace(
                $output,
                $renderedToken,
                $currentToken->offset + $parsedOffset,
                $currentToken->length,
            );

            foreach ($currentToken->children as $childToken) {
                $parsedOffset += $this->getTokenMarkupLength($childToken->type);
            }

            $parsedOffset += $this->getTokenMarkupLength($currentToken->type);
        }

        return $output;
    }

    private function getTokenMarkup(TokenType $tokenType): array
    {
        $tokenId = spl_object_id($tokenType);

        if (isset($this->tokenMarkup[$tokenId])) {
            return $this->tokenMarkup[$tokenId];
        }

        $before = Escape::tokens($this->theme->before($tokenType));
        $after = Escape::tokens($this->theme->after($tokenType));

        $this->tokenMarkup[$tokenId] = [$before, $after];
        $this->tokenMarkupLengths[$tokenId] = strlen($before) + strlen($after);

        return $this->tokenMarkup[$tokenId];
    }

    private function getTokenMarkupLength(TokenType $tokenType): int
    {
        $tokenId = spl_object_id($tokenType);

        if (! isset($this->tokenMarkupLengths[$tokenId])) {
            $this->getTokenMarkup($tokenType);
        }

        return $this->tokenMarkupLengths[$tokenId];
    }
}
