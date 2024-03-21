<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sql\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(input: 'COUNT(*)', output: 'COUNT')]
#[PatternTest(input: 'count(*)', output: 'count')]
final class SqlFunctionPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>[\w]+)\(/i';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::PROPERTY;
    }
}
