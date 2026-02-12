<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Xml\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '<simple>', output: 'simple')]
#[PatternTest(input: '<UPPERCASE>', output: 'UPPERCASE')]
#[PatternTest(input: '<CamelCase>', output: 'CamelCase')]
#[PatternTest(input: '<x-hello attr="">', output: 'x-hello')]
#[PatternTest(input: '<a href="">', output: 'a')]
#[PatternTest(input: '<br/>', output: 'br')]
#[PatternTest(input: '<ns:tag>', output: 'ns:tag')]
#[PatternTest(input: '<point.x>', output: 'point.x')]
#[PatternTest(input: '<point_y>', output: 'point_y')]
#[PatternTest(input: '<_private>', output: '_private')]
# The following are not valid XML tags
#[PatternTest(input: '<1tag>', output: null)]
#[PatternTest(input: '<-tag>', output: null)]
final readonly class XmlOpenTagPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '<(?<match>[a-zA-Z_][\w\-\:\.]*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
