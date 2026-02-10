<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Markdown\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'Use `code` here', output: '`code`')]
#[PatternTest(input: 'Multiple `one` and `two`', output: ['`one`', '`two`'])]
final readonly class MarkdownInlineCodePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>`[^`\n]+`)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
