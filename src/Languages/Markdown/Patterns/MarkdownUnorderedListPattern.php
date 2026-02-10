<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Markdown\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '- Item 1', output: '-')]
#[PatternTest(input: '* Item 2', output: '*')]
#[PatternTest(input: '  - Nested item', output: '-')]
final readonly class MarkdownUnorderedListPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/^[\s]*(?<match>[-*+])\s/m';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
