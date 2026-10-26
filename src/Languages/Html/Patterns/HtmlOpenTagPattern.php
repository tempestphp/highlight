<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Html\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '<div>', output: 'div')]
#[PatternTest(input: '<UPPERCASE>', output: 'UPPERCASE')]
#[PatternTest(input: '<CamelCase>', output: 'CamelCase')]
#[PatternTest(input: '<a-component>', output: 'a-component')]
#[PatternTest(input: '<a href="">', output: 'a')]
#[PatternTest(input: '<math-α>', output: 'math-α')]
#[PatternTest(input: '<emotion-😍-emoji>', output: 'emotion-😍-emoji')]
# The following are not HTML valid
#[PatternTest(input: '<αtag>', output: null)]
#[PatternTest(input: '<_private>', output: null)]
#[PatternTest(input: '<ns:tag>', output: null)]
#[PatternTest(input: '<point.x>', output: null)]
#[PatternTest(input: '<point_y>', output: null)]
#[PatternTest(input: '<1tag>', output: null)]
#[PatternTest(input: '<-tag>', output: null)]
final readonly class HtmlOpenTagPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '<(?<match>[a-zA-Z][a-zA-Z0-9\-\x80-\xFF]*(?![:_\.\w\x80-\xFF]))';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
