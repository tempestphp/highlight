<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use InvalidArgumentException;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class CombinedKeywordPattern implements Pattern
{
    private string $compiledPattern;

    /**
     * @param string[] $keywords
     */
    public function __construct(
        array $keywords,
        private bool $caseInsensitive = false,
    ) {
        $keywords = array_values(array_unique($keywords));

        if ($keywords === []) {
            throw new InvalidArgumentException('At least one keyword is required.');
        }

        usort($keywords, static fn (string $a, string $b): int => strlen($b) <=> strlen($a));

        $alternation = implode(
            '|',
            array_map(
                static fn (string $keyword): string => preg_quote($keyword, '/'),
                $keywords,
            ),
        );

        $flags = $this->caseInsensitive ? 'i' : '';

        $this->compiledPattern = "/\b(?<!\$)(?<!->)(?<match>(?:{$alternation}))(\$|,|\)|;|:|\s|\()/{$flags}";
    }

    public function match(string $content): array
    {
        preg_match_all($this->compiledPattern, $content, $matches, PREG_OFFSET_CAPTURE);

        return $matches;
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
