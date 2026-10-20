<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sql\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(
    input: '/*
multi-line comment
*/',
    output: '/*
multi-line comment
*/'
)]
final readonly class SqlMultilineCommentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        // (*COMMIT) stops the search when an opener has no closer: later openers cannot have one either.
        return '/(?<match>\/\*(?:[\s\S]*?\*\/|(*COMMIT)(*FAIL)))/m';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::COMMENT;
    }
}
