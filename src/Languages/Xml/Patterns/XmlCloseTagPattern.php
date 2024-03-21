<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Xml\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(input: '</x-hello>', output: 'x-hello')]
#[PatternTest(input: '</a>', output: 'a')]
final class XmlCloseTagPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '<\/(?<match>[\w\-]+)';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::KEYWORD;
    }
}
