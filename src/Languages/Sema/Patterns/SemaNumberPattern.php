<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sema\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Sema\SemaSyntax;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '(+ -1.5e3 2)', output: ['-1.5e3', '2'])]
#[PatternTest(input: '[1/2 #xFF 3+4i]', output: ['1/2', '#xFF', '3+4i'])]
#[PatternTest(input: '1st', output: null)]
#[PatternTest(input: '(f 123#(+ % 1) -Inf)', output: ['123', '1'])]
#[PatternTest(input: '#i64(-1 #i64)', output: ['-1', '#i64'])]
final readonly class SemaNumberPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        $real = '\d++(?:\/\d++|(?:\.\d++)?(?:[eE][+-]?\d++)?)';
        $decimal = "(?:#[eEiIdD]){0,2}(?:[+-]?{$real}(?:[+-](?:{$real})?i)?|[+-]?{$real}i|[+-]i)";
        $radix = '(?:#[eEiI])?(?:#[xX](?:#[eEiI])?[+-]?[\da-fA-F]++|#[oO](?:#[eEiI])?[+-]?[0-7]++|#[bB](?:#[eEiI])?[+-]?[01]++)';
        $special = '\+?inf|Inf|\+?Infinity|-inf|-Infinity|nan|NaN|NAN|[+-]nan';

        return SemaSyntax::atom("(?=[\\d#+\\-iInN])(?!#i64\\()(?:{$radix}|{$decimal}|{$special})", SemaSyntax::NUMBER_END);
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::NUMBER;
    }
}
