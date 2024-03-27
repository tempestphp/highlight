<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Xml\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '<x-hello attr="">', output: 'x-hello')]
#[PatternTest(input: '<a href="">', output: 'a')]
#[PatternTest(input: '<br/>', output: 'br')]
final readonly class XmlOpenTagPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '<(?<match>[\w\-]+)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
