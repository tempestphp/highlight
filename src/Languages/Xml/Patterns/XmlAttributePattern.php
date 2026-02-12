<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Xml\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '<x-hello attr="">', output: 'attr')]
#[PatternTest(input: '<a href="">', output: 'href')]
#[PatternTest(input: '<a data-type="">', output: 'data-type')]
#[PatternTest(input: '<xsl xmlns:xsl="http">', output: 'xmlns:xsl')]
#[PatternTest(input: "<item attr='value'>", output: 'attr')]
#[PatternTest(input: '<item
    id =
    "multiline-attr">', output: 'id')]
#[PatternTest(input: '<item
    type
    =
    "multiline-attr">', output: 'type')]
#[PatternTest(input: '<item
    a
    ="multiline-attr">', output: 'a')]
final readonly class XmlAttributePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>[\w\-\:]+)\s*=\s*["\']';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
