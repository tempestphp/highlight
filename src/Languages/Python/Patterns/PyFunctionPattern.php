<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Python\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'def fibonacci(n)', output: 'fibonacci')]
final readonly class PyFunctionPattern implements Pattern
{
    use IsPattern;

    #[\Override]
    public function getPattern(): string
    {
        return '\bdef\s+(?<match>\w*)(?=\s*\()';
    }

    #[\Override]
    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
