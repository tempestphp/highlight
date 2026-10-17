<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'String.new', output: 'String')]
#[PatternTest(input: 'Foo::Bar', output: 'Foo')]
final readonly class RubyConstantPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<!class )(?<!module )\b(?<match>[A-Z]\w*)\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
