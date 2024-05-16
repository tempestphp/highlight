<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Antlers\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'heey:foo', output: 'foo')]
final readonly class AntlersTagParameter implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/\w+:(?<match>[\w\/]+)/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VARIABLE;
    }
}
