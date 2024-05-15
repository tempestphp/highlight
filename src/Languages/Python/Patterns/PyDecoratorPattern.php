<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Python\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '@decorator', output: '@decorator')]
#[PatternTest(input: '@decorator.chained', output: '@decorator.chained')]
final readonly class PyDecoratorPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(^|\n)\s*(?<match>@\s*\w*(?:\.\w+)*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
