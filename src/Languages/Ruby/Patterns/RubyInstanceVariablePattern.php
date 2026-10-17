<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '@name', output: '@name')]
#[PatternTest(input: '@@count', output: '@@count')]
final readonly class RubyInstanceVariablePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>@{1,2}[A-Za-z_]\w*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VARIABLE;
    }
}
