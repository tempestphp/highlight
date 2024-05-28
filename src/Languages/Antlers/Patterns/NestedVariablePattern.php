<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Antlers\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'skaters:name', output: null)]
#[PatternTest(input: '{{ skaters:name }}', output: 'name')]
#[PatternTest(input: '{{ skaters:0:name }}', output: 'name')]
final readonly class NestedVariablePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        /** @lang PhpRegExp */
        return '/^{{.+(:|\.)(?<match>[\w\/]+).*}}/m';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
