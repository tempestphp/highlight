<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tokens;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Theme;

final class RenderTokens
{
    /** @var array<string, array{string, string}> */
    private array $tokenMarkup = [];

    public function __construct(
        private readonly Theme $theme,
    ) {
    }

    /**
     * @param Token[] $tokens
     * @param int $baseOffset Offset to subtract from token positions (for nested rendering)
     */
    public function __invoke(
        string $content,
        array $tokens,
        int $baseOffset = 0,
    ): string {
        if ($tokens === []) {
            return $content;
        }

        $markup = $this->tokenMarkup;
        $parts = [];
        $cursor = 0;

        foreach ($tokens as $currentToken) {
            $relativeOffset = $currentToken->offset - $baseOffset;

            if ($relativeOffset > $cursor) {
                $parts[] = substr($content, $cursor, $relativeOffset - $cursor);
            }

            [$beforeMarkup, $afterMarkup] = $this->getTokenMarkup($currentToken, $markup);

            $parts[] = $beforeMarkup;
            $parts[] = $currentToken->children !== []
                ? ($this)(
                    content: $currentToken->value,
                    tokens: $currentToken->children,
                    baseOffset: $currentToken->offset,
                )
                : $currentToken->value;
            $parts[] = $afterMarkup;

            $cursor = $relativeOffset + $currentToken->length;
        }

        $contentLength = strlen($content);
        if ($cursor < $contentLength) {
            $parts[] = substr($content, $cursor);
        }

        return implode('', $parts);
    }

    /**
     * @param array<string, array{string, string}> $markup
     * @return array{string, string}
     */
    private function getTokenMarkup(Token $token, array &$markup): array
    {
        if (isset($markup[$token->typeValue])) {
            return $markup[$token->typeValue];
        }

        $beforeMarkup = Escape::tokens($this->theme->before($token->type));
        $afterMarkup = Escape::tokens($this->theme->after($token->type));

        $markup[$token->typeValue] = [$beforeMarkup, $afterMarkup];
        $this->tokenMarkup[$token->typeValue] = [$beforeMarkup, $afterMarkup];

        return $markup[$token->typeValue];
    }
}
