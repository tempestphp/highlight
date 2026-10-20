<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tokens;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Theme;
use UnitEnum;

final class RenderTokens
{
    /** @var array<class-string, array<string, array{string, string}>> */
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
        $output = '';
        $cursor = 0;

        foreach ($tokens as $currentToken) {
            $relativeOffset = $currentToken->offset - $baseOffset;

            if ($relativeOffset > $cursor) {
                $output .= substr($content, $cursor, $relativeOffset - $cursor);
            }

            $type = $currentToken->type;

            [$beforeMarkup, $afterMarkup] = $type instanceof UnitEnum && isset($markup[$type::class][$type->name])
                ? $markup[$type::class][$type->name]
                : $this->getTokenMarkup($type, $markup);

            $output .= $beforeMarkup
                . ($currentToken->children !== []
                    ? $this->__invoke($currentToken->value, $currentToken->children, $currentToken->offset)
                    : $currentToken->value)
                . $afterMarkup;

            $cursor = $relativeOffset + $currentToken->length;
        }

        if ($cursor < strlen($content)) {
            $output .= substr($content, $cursor);
        }

        return $output;
    }

    /**
     * Only enum types are cached: they are finite and their case identifies the markup.
     *
     * @param array<class-string, array<string, array{string, string}>> $markup
     * @return array{string, string}
     */
    private function getTokenMarkup(TokenType $type, array &$markup): array
    {
        $tokenMarkup = [Escape::tokens($this->theme->before($type)), Escape::tokens($this->theme->after($type))];

        if ($type instanceof UnitEnum) {
            $markup[$type::class][$type->name] = $tokenMarkup;
            $this->tokenMarkup[$type::class][$type->name] = $tokenMarkup;
        }

        return $tokenMarkup;
    }
}
