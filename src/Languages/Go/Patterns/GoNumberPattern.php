<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Go\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '0xFF', output: '0xFF')]
#[PatternTest(input: '1_000', output: '1_000')]
final readonly class GoNumberPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<![\w.])(?<match>(?:0[xX][\dA-Fa-f](?:_?[\dA-Fa-f])*(?:\.[\dA-Fa-f](?:_?[\dA-Fa-f])*)?(?:[pP][+-]?\d(?:_?\d)*)?|0[bB][01](?:_?[01])*|0[oO][0-7](?:_?[0-7])*|\d(?:_?\d)*(?:\.\d(?:_?\d)*)?(?:[eE][+-]?\d(?:_?\d)*)?)(?:i)?)(?![\w.])/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::NUMBER;
    }
}
