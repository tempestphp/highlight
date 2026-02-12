<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Html\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '</simple>', output: 'simple')]
#[PatternTest(input: '</UPPERCASE>', output: 'UPPERCASE')]
#[PatternTest(input: '</CamelCase>', output: 'CamelCase')]
#[PatternTest(input: '</x-hello>', output: 'x-hello')]
#[PatternTest(input: '</a>', output: 'a')]
# The following are not HTML valid
#[PatternTest(input: '</ns:tag>', output: null)]
#[PatternTest(input: '</point.x>', output: null)]
#[PatternTest(input: '</point_y>', output: null)]
#[PatternTest(input: '</_private>', output: null)]
#[PatternTest(input: '</1tag>', output: null)]
#[PatternTest(input: '</-tag>', output: null)]
final readonly class HtmlCloseTagPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '<\/(?<match>[a-zA-Z][a-zA-Z0-9\-]*(?![:_\.\w]))';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
