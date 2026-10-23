<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Twig\Patterns;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Twig\Patterns\CombinedTwigKeywordPattern;
use Tempest\Highlight\Languages\Twig\Patterns\TwigKeywordPattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final class CombinedTwigKeywordPatternTest extends TestCase
{
    private const array KEYWORDS = ['set', 'if', 'endif', 'end', 'for', 'endfor', 'in', 'as', 'with', 'endwith'];

    /**
     * @param array<array{string, int}> $expected
     */
    #[DataProvider('provide_matches_with_offsets_cases')]
    public function test_matches_with_offsets(string $content, array $expected): void
    {
        $matches = new CombinedTwigKeywordPattern(self::KEYWORDS)->match($content);

        $this->assertSame($expected, $matches['match']);
    }

    public static function provide_matches_with_offsets_cases(): iterable
    {
        yield 'multiple matches' => ['for item in items', [['for', 0], ['in', 9]]];
        yield 'keyword that prefixes another' => ['endif end endfor', [['endif', 0], ['end', 6], ['endfor', 10]]];
        yield 'keyword inside identifier' => ['settings ending format inside', []];
        yield 'keyword next to underscore or digit' => ['set_x if1 _for', []];
        yield 'keyword next to punctuation' => ['{%if(x)%}{%endif%}', [['if', 2], ['endif', 11]]];
        yield 'case sensitive' => ['SET If FOR', []];
        yield 'no keywords' => ['{{ name }}', []];
    }

    public function test_matches_the_same_tokens_as_one_pattern_per_keyword(): void
    {
        $content = file_get_contents(__DIR__ . '/../../../Bench/Fixtures/twig.txt');

        $expected = [];

        foreach (self::KEYWORDS as $keyword) {
            foreach (new TwigKeywordPattern($keyword)->match($content)['match'] as $match) {
                $expected[] = $match;
            }
        }

        $actual = new CombinedTwigKeywordPattern(self::KEYWORDS)->match($content)['match'];

        usort($expected, static fn (array $a, array $b): int => $a[1] <=> $b[1]);

        $this->assertNotEmpty($actual);
        $this->assertSame($expected, $actual);
    }

    public function test_duplicate_keywords_match_once(): void
    {
        $matches = new CombinedTwigKeywordPattern(['if', 'if'])->match('if x');

        $this->assertSame([['if', 0]], $matches['match']);
    }

    public function test_token_type_is_keyword(): void
    {
        $this->assertSame(TokenTypeEnum::KEYWORD, new CombinedTwigKeywordPattern(['if'])->getTokenType());
    }

    public function test_requires_a_keyword(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new CombinedTwigKeywordPattern([]);
    }
}
