<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Antlers\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'foo', output: null)]
#[PatternTest(input: '{{foo}}', output: 'foo')]
#[PatternTest(input: '{{ foo }}', output: 'foo')]
#[PatternTest(input: '{{ a }} heey {{ b }}', output: 'a')]
// #[PatternTest(input: '{{ if foo }}', output: 'foo')] // TODO: Does not work right now
final readonly class VariablePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        /** @lang RegExp */
        return '/{{[^{}]*?\b(?<match>[_A-Za-z][-_0-9A-Za-z]*[_A-Za-z0-9]*)\b/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VARIABLE;
    }
}
