<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(
    input: 'private const string BAR',
    output: 'BAR',
)]
final readonly class TypedConstantNamePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return 'const\s[\w]+\s(?<match>[\w]+)\s=';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::PROPERTY;
    }
}
