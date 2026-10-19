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
#[PatternTest(input: 'let v = "value \(identity("if"))"', output: '"value \(identity("if"))"')]
#[PatternTest(input: 'let v = "\(format(price, "%.2f")) EUR"', output: '"\(format(price, "%.2f")) EUR"')]
final readonly class SwiftStringPattern implements Pattern
{
    use IsPattern;

    /**
     * An interpolation `\(…)` may hold parentheses and strings of its own, so it is matched as a balanced whole.
     */
    public function getPattern(): string
    {
        return '(?<match>(?<string>"(?:\\\\\((?<interpolation>(?:[^()"\n]|(?&string)|\((?&interpolation)\))*)\)|\\\\.|[^"\\\\\n])*"))';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
