<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Terraform\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'ami = "abc"', output: '=')]
#[PatternTest(input: 'a == b', output: '==')]
#[PatternTest(input: 'key => value', output: '=>')]
final readonly class TerraformOperatorPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>=>|==|!=|>=|<=|&&|\|\||[=><!\?:])';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::OPERATOR;
    }
}
