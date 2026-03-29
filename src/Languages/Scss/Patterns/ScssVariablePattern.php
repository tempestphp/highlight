<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Scss\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '$primary-color: #333;', output: '$primary-color')]
#[PatternTest(input: 'color: $primary-color;', output: '$primary-color')]
#[PatternTest(input: 'border: 1px solid $border-color;', output: '$border-color')]
final readonly class ScssVariablePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\$[\w\-]+)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VARIABLE;
    }
}
