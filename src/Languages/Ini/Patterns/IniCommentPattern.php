<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ini\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '; FOO=bar', output: '; FOO=bar')]
final class IniCommentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>\;.*)/';
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::COMMENT;
    }
}
