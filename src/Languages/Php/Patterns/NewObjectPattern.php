<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'new Foo()', output: 'Foo')]
#[PatternTest(input: 'new Foo\Bar()', output: 'Foo\Bar')]
#[PatternTest(input: '(new Foo)', output: 'Foo')]
#[PatternTest(input: 'new Foo', output: 'Foo')]
final readonly class NewObjectPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return 'new (?<match>[\w\\\\]+)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
