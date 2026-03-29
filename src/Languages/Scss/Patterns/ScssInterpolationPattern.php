<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Scss\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'content: "#{$name}";', output: '#{$name}')]
#[PatternTest(input: '.#{$class}-item {', output: '#{$class}')]
final readonly class ScssInterpolationPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>#\{\$[\w\-]+\})';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VARIABLE;
    }
}
