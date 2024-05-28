<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Antlers\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '<p>This is 10 songs!</p>', output: null)]
#[PatternTest(input: '{{ variable }} 99 {{ variable }}.', output: null)]
#[PatternTest(input: '{{ skaters:12:name }}', output: '12')]
#[PatternTest(input: '{{ if songs === 345 }}', output: '345')]
#[PatternTest(input: '{{ if {collection:count from="episodes"} >= 100 }}', output: '100')]
final readonly class NumberPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        /** @lang PhpRegExp */
        return '{{(?:(?!{{|}}).)*?\b(?<match>\d+)\b(?:(?!{{|}}).)*?}}';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::NUMBER;
    }
}
