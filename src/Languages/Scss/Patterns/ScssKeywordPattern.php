<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Scss\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '@mixin rounded {', output: '@mixin')]
#[PatternTest(input: '@include rounded;', output: '@include')]
#[PatternTest(input: '@extend .base;', output: '@extend')]
#[PatternTest(input: '@if $dark {', output: '@if')]
#[PatternTest(input: '@each $color in $colors {', output: '@each')]
#[PatternTest(input: "@use 'colors';", output: '@use')]
#[PatternTest(input: '@function double($value) {', output: '@function')]
#[PatternTest(input: '@return $value * 2;', output: '@return')]
final readonly class ScssKeywordPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>@(?:mixin|include|extend|function|return|if|else|for|each|while|use|forward|at-root|debug|warn|error))\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
