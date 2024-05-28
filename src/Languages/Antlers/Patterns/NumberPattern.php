<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Antlers\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'd 42', output: '42')]
#[PatternTest(input: 'd', output: null)]
#[PatternTest(input: '3', output: '3')]
final readonly class NumberPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\d+)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::NUMBER;
    }
}
