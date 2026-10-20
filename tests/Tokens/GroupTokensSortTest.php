<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Tokens;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use Tempest\Highlight\Tokens\GroupTokens;
use Tempest\Highlight\Tokens\Token;
use Tempest\Highlight\Tokens\TokenTypeEnum;

class GroupTokensSortTest extends TestCase
{
    #[Test]
    #[DataProvider('provide_sort_order_is_start_ascending_then_end_descending_then_original_index_cases')]
    public function sort_order_is_start_ascending_then_end_descending_then_original_index(array $tokens): void
    {
        $sorted = new ReflectionMethod(GroupTokens::class, 'sortTokens')->invoke(new GroupTokens(), $tokens);

        $this->assertSame(
            array_map(spl_object_id(...), $this->referenceSort($tokens)),
            array_map(spl_object_id(...), $sorted),
        );
    }

    public static function provide_sort_order_is_start_ascending_then_end_descending_then_original_index_cases(): iterable
    {
        mt_srand(42);

        for ($set = 0; $set < 20; $set++) {
            $tokens = [];

            for ($i = 0, $count = mt_rand(2, 300); $i < $count; $i++) {
                $offset = mt_rand(-1, 60);
                $tokens[] = new Token($offset, str_repeat('x', $offset === -1 ? 0 : mt_rand(0, 8)), TokenTypeEnum::KEYWORD);
            }

            yield "random {$set}" => [$tokens];
        }

        $duplicate = new Token(3, 'abc', TokenTypeEnum::TYPE);

        yield 'duplicates and zero length' => [[
            new Token(3, '', TokenTypeEnum::KEYWORD),
            $duplicate,
            new Token(3, 'abc', TokenTypeEnum::KEYWORD),
            new Token(-1, '', TokenTypeEnum::KEYWORD),
            new Token(0, 'abcd', TokenTypeEnum::KEYWORD),
            new Token(3, '', TokenTypeEnum::TYPE),
            $duplicate,
        ]];

        yield 'unmatched group offset before the widest token' => [[
            new Token(0, 'abcdef', TokenTypeEnum::KEYWORD),
            new Token(-1, '', TokenTypeEnum::KEYWORD),
        ]];

        yield 'range too large for a packed key' => [[
            new Token(4_000_000_000, 'b', TokenTypeEnum::KEYWORD),
            new Token(0, 'aa', TokenTypeEnum::KEYWORD),
            new Token(0, 'a', TokenTypeEnum::KEYWORD),
            new Token(0, 'aa', TokenTypeEnum::TYPE),
        ]];
    }

    /**
     * @param Token[] $tokens
     * @return Token[]
     */
    private function referenceSort(array $tokens): array
    {
        $starts = array_map(fn (Token $token) => $token->start, $tokens);
        $negatedEnds = array_map(fn (Token $token) => -$token->end, $tokens);
        $indices = array_keys($tokens);

        array_multisort($starts, SORT_ASC, SORT_NUMERIC, $negatedEnds, SORT_ASC, SORT_NUMERIC, $indices, SORT_ASC, SORT_NUMERIC, $tokens);

        return $tokens;
    }
}
