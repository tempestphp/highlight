<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'Foo::$bar', output: '$bar')]
#[PatternTest(input: 'new MyClass()::$bar', output: '$bar')]
final readonly class StaticPropertyPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\:\:(?<match>\\$[\w]+)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
