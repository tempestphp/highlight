<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'def fibonacci(n)', output: 'fibonacci')]
#[PatternTest(input: 'def self.create', output: 'create')]
#[PatternTest(input: 'def valid?', output: 'valid?')]
final readonly class RubyMethodPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\bdef\s+(?:self\.)?(?<match>[A-Za-z_]\w*[?!=]?)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
