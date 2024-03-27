<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'case Foo = "";', output: 'Foo')]
#[PatternTest(input: 'case Foo="";', output: 'Foo')]
#[PatternTest(input: 'case Foo;', output: 'Foo')]
#[PatternTest(input: 'case Foo ;', output: 'Foo')]
final readonly class EnumCasePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return 'case (?<match>[\w]+)(\s)*(=|;)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
