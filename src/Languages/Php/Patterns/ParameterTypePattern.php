<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(input: 'function foo(Bar $bar, Baz $baz)', output: ['Bar', 'Baz'])]
#[PatternTest(input: 'function foo(Foo|Bar $bar, Baz $baz)', output: ['Foo|Bar', 'Baz'])]
#[PatternTest(input: 'function foo(?Bar $bar, Baz $baz)', output: ['?Bar', 'Baz'])]
final readonly class ParameterTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>[\|\&\?\w]+)\s\\$';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::TYPE;
    }
}
