<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Scss\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '// this is a comment', output: '// this is a comment')]
#[PatternTest(input: 'color: red; // inline comment', output: '// inline comment')]
final readonly class ScssCommentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>\/\/.*)/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::COMMENT;
    }
}
