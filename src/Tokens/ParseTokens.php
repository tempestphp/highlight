<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tokens;

use Tempest\Highlight\Language;
use Tempest\Highlight\Languages\Php\Patterns\GenericPattern;

final readonly class ParseTokens
{
    /**
     * @return \Tempest\Highlight\Tokens\Token[]
     */
    public function __invoke(string $content, Language $language): array
    {
        $tokens = [];

        // Match tokens from patterns
        foreach ($language->getPatterns() as $key => $pattern) {
            if ($pattern instanceof TokenTypeEnum) {
                $pattern = new GenericPattern(
                    $key,
                    $pattern,
                );
            }

            $matches = $pattern->match($content);

            $match = $matches['match'] ?? null;

            if (! $match) {
                continue;
            }

            foreach ($match as $item) {
                $offset = $item[1];
                $value = $item[0];

                $token = new Token(
                    offset: $offset,
                    value: $value,
                    type: $pattern->getTokenType(),
                    pattern: $pattern,
                );

                if (! $this->tokenAlreadyPresent($tokens, $token)) {
                    $tokens[] = $token;
                }
            }
        }

        return $tokens;
    }

    private function tokenAlreadyPresent(array $tokens, Token $token): bool
    {
        foreach ($tokens as $tokenToCompare) {
            if ($tokenToCompare->equals($token)) {
                return true;
            }
        }

        return false;
    }
}
