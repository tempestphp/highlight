<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\C\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '"hello"', output: '"hello"')]
#[PatternTest(input: '\'x\'', output: '\'x\'')]
#[PatternTest(input: 'L"wide"', output: 'L"wide"')]
final readonly class CStringPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>(?:u8|u|U|L)?"(?:\\\\.|[^"\\\\\r\n]++)*"|(?:u|U|L)?\'(?:\\\\.|[^\'\\\\\r\n]++)+\')/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
