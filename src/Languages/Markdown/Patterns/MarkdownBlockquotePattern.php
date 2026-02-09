<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Markdown\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '> This is a quote', output: '>')]
#[PatternTest(input: "> First\n> Second", output: ['>', '>'])]
final readonly class MarkdownBlockquotePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/^(?<match>[^\S\n]*>)/m';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
