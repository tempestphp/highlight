<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Http\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '# Test Comment', output: '# Test Comment')]
#[PatternTest(input: '// Test Comment', output: '// Test Comment')]
final class HttpCommentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>(?m)^(\/\/|\#).*)/';
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::COMMENT;
    }
}
