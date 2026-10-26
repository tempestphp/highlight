<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Go\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'true', output: 'true')]
#[PatternTest(input: 'nil', output: 'nil')]
final readonly class GoLiteralPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\b(?<match>false|iota|nil|true)\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::LITERAL;
    }
}
