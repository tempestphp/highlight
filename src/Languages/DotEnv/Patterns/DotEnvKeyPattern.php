<?php

namespace Tempest\Highlight\Languages\DotEnv\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'FOO=bar', output: 'FOO')]
final class DotEnvKeyPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>[\w].*)=/';
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::KEYWORD;
    }
}