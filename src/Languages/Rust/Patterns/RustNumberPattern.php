<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Rust\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '42_u8', output: '42_u8')]
#[PatternTest(input: '0xFF', output: '0xFF')]
#[PatternTest(input: '1.5_f64', output: '1.5_f64')]
final readonly class RustNumberPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<!\w)(?<match>(?:0x[\dA-Fa-f_]+|0o[0-7_]+|0b[01_]+|\d[\d_]*(?:\.\d[\d_]*)?(?:[eE][+-]?[\d_]+)?)(?:f32|f64|i(?:8|16|32|64|128|size)|u(?:8|16|32|64|128|size))?)\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::NUMBER;
    }
}
