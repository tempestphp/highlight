<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Markdown\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '![Alt text](image.png)', output: '![Alt text](image.png)')]
final readonly class MarkdownImagePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>!\[[^\]]*\]\([^\)]+\))';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
