<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'implements Foo', output: ' Foo')]
#[PatternTest(input: 'implements Foo, Bar', output: ' Foo, Bar')]
final readonly class ImplementsPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return 'implements(?<match>[\s\,\w]+)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
