<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'x = 42', output: '42')]
#[PatternTest(input: 'x = 3.14', output: '3.14')]
#[PatternTest(input: 'x = 1_000_000', output: '1_000_000')]
#[PatternTest(input: 'x = 0xFF', output: '0xFF')]
final readonly class RubyNumberPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\b(?<match>0[xX][0-9a-fA-F_]+|0[bB][01_]+|0[oO][0-7_]+|\d[\d_]*(?:\.\d[\d_]*)?(?:[eE][+-]?\d+)?r?i?)\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::NUMBER;
    }
}
