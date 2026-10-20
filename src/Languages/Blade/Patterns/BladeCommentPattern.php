<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Blade\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(
    input: '{{-- test --}} content',
    output: '{{-- test --}}',
)]
final readonly class BladeCommentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        // (*COMMIT) stops the search when an opener has no closer: later openers cannot have one either.
        return '(?<match>\{\{\-\-(?:[\s\S]*?\-\-\}\}|(*COMMIT)(*FAIL)))';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::COMMENT;
    }
}
