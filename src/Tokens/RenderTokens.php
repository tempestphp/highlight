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
        $output = $content;

        foreach ($tokens as $currentToken) {
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
