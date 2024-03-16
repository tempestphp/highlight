<?php

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(
    input: 'private const BAR = "bar";',
    output: 'BAR',
)]
final readonly class UntypedConstantNamePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(const\s(?<match>[\w]+)\s=)';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::PROPERTY;
    }
}