<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Markdown\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'This is *italic* text', output: '*italic*')]
final readonly class MarkdownItalicAsteriskPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<!\*|\w)(?<match>\*(?!\s|\*)(?:(?!\*).)+?\*)(?!\*)/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::ATTRIBUTE;
    }
}
