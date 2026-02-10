<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Markdown\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '[Click here](https://example.com)', output: '[Click here](https://example.com)')]
final readonly class MarkdownLinkPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\[[^\]]+\]\([^\)]+\))';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
