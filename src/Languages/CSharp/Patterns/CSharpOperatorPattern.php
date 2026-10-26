<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\CSharp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'x => x + 1', output: '=>')]
#[PatternTest(input: 'user?.Name', output: '?.')]
final readonly class CSharpOperatorPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>=>|\?\?=|\?\?|\?\.|\?\[|\.\.|<<=?|>>=?|\+\+|--|&&|\|\||==|!=|<=|>=|[-+*\/%&|^~!<>=]=?|[?:;,.{}()\[\]])/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::OPERATOR;
    }
}
