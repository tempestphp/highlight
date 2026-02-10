<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tokens;

use Tempest\Highlight\Language;
use Tempest\Highlight\Languages\Php\Patterns\GenericPattern;

final readonly class ParseTokens
{
    /**
     * @return Token[]
     */
    public function __invoke(string $content, Language $language): array
    {
        return $this->parse($content, $language->getPatterns());
    }

    /**
     * @param array<int|string, mixed> $patterns
     * @return Token[]
     */
    public function parse(string $content, array $patterns): array
    {
        $tokens = [];
        $seen = [];

        // Match tokens from patterns
        foreach ($patterns as $key => $pattern) {
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

            $tokenType = $pattern->getTokenType();
            $tokenTypeValue = $tokenType->getValue();

            foreach ($match as $item) {
                $offset = $item[1];
                $value = $item[0];

                $hashKey = $offset . ':' . $tokenTypeValue . ':' . $value;

                if (isset($seen[$hashKey])) {
                    continue;
                }

                $seen[$hashKey] = true;

                $tokens[] = new Token(
                    offset: $offset,
                    value: $value,
                    type: $tokenType,
                    pattern: $pattern,
                );
            }
        }

        return $tokens;
    }
}
