<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\JavaScript\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '// language', output: '// language')]
final readonly class JsSinglelineCommentPattern implements Pattern
{
    use IsPattern;

    #[\Override]
    public function getPattern(): string
    {
        return '(?<match>\/\/(.)*)';
    }

    #[\Override]
    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::COMMENT;
    }
}
