<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ini\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'foo=bar', output: 'foo')]
final class IniKeyPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>[\w].*)=/';
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::PROPERTY;
    }
}
