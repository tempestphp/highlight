<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'name = "Ada #{suffix}"', output: '"Ada #{suffix}"')]
#[PatternTest(input: 'name = "she said \\"hi\\""', output: '"she said \\"hi\\""')]
final readonly class RubyDoubleQuoteStringPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>"(?:\\\\"|.)*?")';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
