<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'Bar $bar, Baz $baz', output: ['Bar', 'Baz'])]
#[PatternTest(input: 'Foo|Bar $bar, Baz $baz', output: ['Foo|Bar', 'Baz'])]
#[PatternTest(input: '?Bar $bar, Baz $baz', output: ['?Bar', 'Baz'])]
#[PatternTest(input: 'Foo|Bar|null $bar', output: 'Foo|Bar|null')]
#[PatternTest(input: '(Foo&Bar)|null $bar', output: '(Foo&Bar)|null')]
#[PatternTest(input: 'string|\Stringable $bar', output: 'string|\Stringable')]
#[PatternTest(input: 'Foo ...$params', output: 'Foo')]
final readonly class TypeForVariablePattern implements Pattern
{
    use IsPattern;

    #[\Override]
    public function getPattern(): string
    {
        return '(?<match>[\w\&\(\)\|\\\\\?]+)\s+(\.*)\\$';
    }

    #[\Override]
    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
