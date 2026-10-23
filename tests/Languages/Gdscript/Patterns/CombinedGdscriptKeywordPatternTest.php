<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Gdscript\Patterns;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Gdscript\Patterns\CombinedGdscriptKeywordPattern;
use Tempest\Highlight\Languages\Gdscript\Patterns\KeywordPattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final class CombinedGdscriptKeywordPatternTest extends TestCase
{
    private const array KEYWORDS = ['class', 'class_name', 'func', 'var', 'if', 'in', 'is', 'not', 'and', 'self', 'PI', 'INF'];

    /**
     * @param array<array{string, int}> $expected
     */
    #[DataProvider('provide_matches_with_offsets_cases')]
    public function test_matches_with_offsets(string $content, array $expected): void
    {
        $matches = new CombinedGdscriptKeywordPattern(self::KEYWORDS)->match($content);

        $this->assertSame($expected, $matches['match']);
    }

    public static function provide_matches_with_offsets_cases(): iterable
    {
        yield 'multiple matches' => ['if x is not y and z', [['if', 0], ['is', 5], ['not', 8], ['and', 14]]];
        yield 'keyword that prefixes another' => ['class_name Foo', [['class_name', 0]]];
        yield 'keyword inside identifier' => ['classy inside island variable PIE', []];
        yield 'keyword next to underscore or digit' => ['var_x func2 _self', []];
        yield 'keyword next to punctuation' => ['self.x(PI)', [['self', 0], ['PI', 7]]];
        yield 'case sensitive' => ['Func VAR pi inf', []];
        yield 'no keywords' => ['x = 1', []];
    }

    public function test_matches_the_same_tokens_as_one_pattern_per_keyword(): void
    {
        $content = file_get_contents(__DIR__ . '/../../../Bench/Fixtures/gdscript.txt');

        $expected = [];

        foreach (self::KEYWORDS as $keyword) {
            foreach (new KeywordPattern($keyword)->match($content)['match'] as $match) {
                $expected[] = $match;
            }
        }

        $actual = new CombinedGdscriptKeywordPattern(self::KEYWORDS)->match($content)['match'];

        usort($expected, static fn (array $a, array $b): int => $a[1] <=> $b[1]);

        $this->assertNotEmpty($actual);
        $this->assertSame($expected, $actual);
    }

    public function test_duplicate_keywords_match_once(): void
    {
        $matches = new CombinedGdscriptKeywordPattern(['var', 'var'])->match('var x');

        $this->assertSame([['var', 0]], $matches['match']);
    }

    public function test_token_type_is_keyword(): void
    {
        $this->assertSame(TokenTypeEnum::KEYWORD, new CombinedGdscriptKeywordPattern(['var'])->getTokenType());
    }

    public function test_requires_a_keyword(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new CombinedGdscriptKeywordPattern([]);
    }
}
