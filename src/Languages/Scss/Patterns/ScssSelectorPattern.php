<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Scss\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '&:hover {', output: '&:hover ')]
#[PatternTest(input: '%placeholder {', output: '%placeholder ')]
#[PatternTest(input: '& .child {', output: '& .child ')]
final readonly class ScssSelectorPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>[\[\]\'\"\=\@\-\#\.\w\s,\n\+\:\(\)\*\&\%]+)\{';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
