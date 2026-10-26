<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Go\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'value <- input', output: '<-')]
#[PatternTest(input: 'value := 1', output: ':=')]
final readonly class GoOperatorPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match><-|:=|\+\+|--|<<=?|>>=?|&\^=?|&&|\|\||==|!=|<=|>=|\.\.\.|[-+*\/%&|^!<>=]=?|[~.,:;{}()\[\]])/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::OPERATOR;
    }
}
