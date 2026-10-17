<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: "=begin\nnot code\n=end", output: "=begin\nnot code\n=end")]
final readonly class RubyBlockCommentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/^(?<match>=begin[\s\S]*?^=end.*)$/m';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::COMMENT;
    }
}
