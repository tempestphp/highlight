<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Swift\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'let million = 1_000_000', output: '1_000_000')]
#[PatternTest(input: 'let mask = 0xFF', output: '0xFF')]
#[PatternTest(input: 'let pi = 3.14', output: '3.14')]
final readonly class SwiftNumberPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\b(?<match>0b[01_]+|0o[0-7_]+|0x[\da-fA-F_]+|\d[\d_]*(?:\.\d[\d_]*)?(?:[eE][+-]?\d+)?)\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::NUMBER;
    }
}
