<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'public Foo $foo', output: '$foo')]
#[PatternTest(input: 'private Foo $foo', output: '$foo')]
#[PatternTest(input: 'protected Foo $foo', output: '$foo')]
#[PatternTest(input: 'public Foo|Bar $foo', output: '$foo')]
#[PatternTest(input: 'public Foo&Bar $foo', output: '$foo')]
#[PatternTest(input: 'public (Foo&Bar)|null $foo', output: '$foo')]
#[PatternTest(input: 'private(set) Foo $foo;', output: '$foo')]
#[PatternTest(input: 'public(set) Foo $foo;', output: '$foo')]
#[PatternTest(input: 'protected(set) Foo $foo;', output: '$foo')]
final readonly class ClassPropertyPattern implements Pattern
{
    use IsPattern;

    #[\Override]
    public function getPattern(): string
    {
        return '(public|private|protected)(\(set\))?(\s(.+?)) (?<match>\\$[\w]+)';
    }

    #[\Override]
    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
