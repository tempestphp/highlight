<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'class Greeter', output: 'Greeter')]
#[PatternTest(input: 'class Greeter < Base', output: 'Greeter')]
#[PatternTest(input: 'module Greetings', output: 'Greetings')]
final readonly class RubyClassNamePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\b(?:class|module)\s+(?<match>[A-Z]\w*(?:::[A-Z]\w*)*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
