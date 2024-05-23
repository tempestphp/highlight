<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Python\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'class MyClass:', output: 'MyClass')]
#[PatternTest(input: 'class HisClass(MyClass):', output: 'HisClass')]
final readonly class PyClassNamePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\bclass\s+(?<match>\w*)(?=[\s*\:(])';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
