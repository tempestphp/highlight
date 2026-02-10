<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\JavaScript\Patterns;

use InvalidArgumentException;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class CombinedJsKeywordPattern implements Pattern
{
    private string $compiledPattern;

    /**
     * @param string[] $keywords
     */
    public function __construct(array $keywords)
    {
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

        $this->compiledPattern = "/\b(?<!\.)(?<match>(?:{$alternation}))(,|\.|\)|;|:|\s|\()/";
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
