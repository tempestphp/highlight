<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\CLike\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'a <=> b', output: '<=>')]
#[PatternTest(input: 'pointer->field', output: '->')]
final readonly class CLikeOperatorPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match><=>|->\*|<<=?|>>=?|\+\+|--|&&|\|\||==|!=|<=|>=|->|::|\.\*|\.\.\.|[-+*\/%&|^~!<>=]=?|[?:;,.{}()\[\]])/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::OPERATOR;
    }
}
