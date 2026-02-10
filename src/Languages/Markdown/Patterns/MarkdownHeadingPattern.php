<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Markdown\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '# Heading 1', output: '# Heading 1')]
#[PatternTest(input: '## Heading 2', output: '## Heading 2')]
#[PatternTest(input: '### Heading 3', output: '### Heading 3')]
#[PatternTest(input: '###### Heading 6', output: '###### Heading 6')]
final readonly class MarkdownHeadingPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/^(?<match>#{1,6}\s+.*)$/m';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
