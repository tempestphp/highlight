<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Swift\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'let name = "Swift"', output: '"Swift"')]
#[PatternTest(input: 'print("Hello, \(name)!")', output: '"Hello, \(name)!"')]
#[PatternTest(input: 'let quote = "Say \"hi\""', output: '"Say \"hi\""')]
final readonly class SwiftStringPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>"(?:\\\\.|[^"\\\\\n])*")';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
