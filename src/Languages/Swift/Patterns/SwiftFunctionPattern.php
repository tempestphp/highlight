<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Swift\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'func greet(name: String)', output: 'greet')]
final readonly class SwiftFunctionPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\bfunc\s+(?<match>\w+)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
