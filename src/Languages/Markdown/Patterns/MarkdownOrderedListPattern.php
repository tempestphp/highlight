<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Markdown\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '1. First item', output: '1.')]
#[PatternTest(input: '42. Another item', output: '42.')]
final readonly class MarkdownOrderedListPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/^[\s]*(?<match>\d+\.)\s/m';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
