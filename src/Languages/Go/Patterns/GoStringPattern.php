<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Go\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '"hello"', output: '"hello"')]
#[PatternTest(input: '`raw text`', output: '`raw text`')]
#[PatternTest(input: '\'x\'', output: '\'x\'')]
final readonly class GoStringPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>`[^`]*`|"(?:\\\\.|[^"\\\\\r\n])*"|\'(?:\\\\.|[^\'\\\\\r\n])+\')/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
