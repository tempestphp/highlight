<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Markdown\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'This is _italic_ text', output: '_italic_')]
final readonly class MarkdownItalicUnderscorePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<!_|\w)(?<match>_(?!\s|_)(?:(?!_).)+?_)(?!_|\w)/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::ATTRIBUTE;
    }
}
