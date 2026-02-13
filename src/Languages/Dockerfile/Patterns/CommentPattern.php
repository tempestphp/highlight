<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Dockerfile\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '# Hello world!', output: '# Hello world!')]
final class CommentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>\#.*)/';
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::COMMENT;
    }
}
