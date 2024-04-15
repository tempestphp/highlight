<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'Foo::bar()', output: 'Foo')]
#[PatternTest(input: 'Foo::BAR', output: 'Foo')]
#[PatternTest(input: 'Foo\\Bar::BAR', output: 'Foo\\Bar')]
final readonly class StaticClassCallPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<!\\$)(?<match>[\\\\\w]+)\:\:';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
