<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Markdown\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'This is **bold** text', output: '**bold**')]
#[PatternTest(input: 'This is __bold__ text', output: '__bold__')]
final readonly class MarkdownBoldPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\*\*(?!\s)(?:(?!\*\*).)+\*\*|__(?!\s)(?:(?!__).)+__)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::GENERIC;
    }
}
