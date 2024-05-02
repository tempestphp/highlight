<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'function foo(): Bar;', output: 'Bar')]
#[PatternTest(input: 'function foo(): Bar{}', output: 'Bar')]
#[PatternTest(input: 'function foo(): Bar {}', output: 'Bar')]
#[PatternTest(input: 'function foo(): Bar 
{}', output: 'Bar')]
#[PatternTest(input: 'function foo(): ?Bar;', output: '?Bar')]
#[PatternTest(input: 'function foo(): Foo|Bar;', output: 'Foo|Bar')]
#[PatternTest(input: 'function foo(): Foo&Bar;', output: 'Foo&Bar')]
#[PatternTest(input: 'function foo(): (Foo&Bar)|null;', output: '(Foo&Bar)|null')]
final readonly class ReturnTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\)\s*\:\s*(?<match>[\w\(\)\&\|\?]+)[\s{;\n]';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
