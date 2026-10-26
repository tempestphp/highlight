<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Cpp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '"hello"', output: '"hello"')]
#[PatternTest(input: 'R"(hello)"', output: 'R"(hello)"')]
#[PatternTest(input: '\'x\'', output: '\'x\'')]
final readonly class CppStringPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>(?:u8|u|U|L)?R"(?<delimiter>[^ ()\\\\\t\r\n]{0,16})\([\s\S]*?\)\k<delimiter>"|(?:u8|u|U|L)?"(?:\\\\.|[^"\\\\\r\n]++)*"|(?:u8|u|U|L)?\'(?:\\\\.|[^\'\\\\\r\n]++)+\')/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
