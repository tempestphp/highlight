<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tokens;

use ReflectionClass;
use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Language;
use Tempest\Highlight\Languages\Php\Patterns\GenericPattern;
use Tempest\Highlight\Pattern;

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
        return $this->parseCompiled($content, $this->compile($patterns));
    }

    /**
     * Built-in patterns that use IsPattern::match() get their final regex and token type resolved once.
     * Every other pattern keeps calling its own match() and getTokenType() on each parse.
     *
     * @internal
     * @param array<int|string, mixed> $patterns
     * @return array<int|string, array{?string, Pattern, ?TokenType, ?string}>
     */
    public function compile(array $patterns): array
    {
        $compiled = [];

        foreach ($patterns as $key => $pattern) {
            if ($pattern instanceof TokenTypeEnum) {
                $pattern = new GenericPattern(
                    $key,
                    $pattern,
                );
            }

            if (! $this->usesBuiltInMatch($pattern)) {
                $compiled[$key] = [null, $pattern, null, null];

                continue;
            }

            $regex = $pattern->getPattern();

            if (($regex[0] ?? '') !== '/') {
                $regex = "/{$regex}/";
            }

            $tokenType = $pattern->getTokenType();

            $compiled[$key] = [$regex, $pattern, $tokenType, $tokenType->getValue()];
        }

        return $compiled;
    }

    /**
     * @internal
     * @param array<int|string, array{?string, Pattern, ?TokenType, ?string}> $compiled
     * @return Token[]
     */
    public function parseCompiled(string $content, array $compiled): array
    {
        $tokens = [];
        $seen = [];

        // Match tokens from patterns
        foreach ($compiled as [$regex, $pattern, $tokenType, $tokenTypeValue]) {
            if ($regex !== null) {
                preg_match_all($regex, $content, $matches, PREG_OFFSET_CAPTURE);
            } else {
                $matches = $pattern->match($content);
            }

            $match = $matches['match'] ?? null;

            if (! $match) {
                continue;
            }

            // Built-in patterns have pure token types, so cloning one prototype equals constructing each token
            $prototype = null;

            if ($tokenType === null) {
                $tokenType = $pattern->getTokenType();
                $tokenTypeValue = $tokenType->getValue();
            } else {
                $prototype = new Token(0, '', $tokenType, $pattern, 0);
            }

            foreach ($match as $item) {
                $offset = $item[1];
                $value = $item[0];

                $hashKey = $offset . ':' . $tokenTypeValue . ':' . $value;

                if (isset($seen[$hashKey])) {
                    continue;
                }

                $seen[$hashKey] = true;

                if ($prototype === null) {
                    $tokens[] = new Token($offset, $value, $tokenType, $pattern, strlen((string) $value));

                    continue;
                }

                $token = clone $prototype;
                $token->offset = $token->start = $offset;
                $token->value = $value;
                $token->length = strlen($value);
                $token->end = $offset + $token->length;
                $tokens[] = $token;
            }
        }

        return $tokens;
    }

    private function usesBuiltInMatch(Pattern $pattern): bool
    {
        static $builtIn = [];

        $class = $pattern::class;

        if (! isset($builtIn[$class])) {
            $reflection = new ReflectionClass($class);

            // Anonymous classes are named after their interface, so they would pass the namespace check
            $builtIn[$class] = str_starts_with($class, 'Tempest\\Highlight\\')
                && ! $reflection->isAnonymous()
                && $reflection->getMethod('match')->getFileName() === new ReflectionClass(IsPattern::class)->getFileName();
        }

        return $builtIn[$class];
    }
}
