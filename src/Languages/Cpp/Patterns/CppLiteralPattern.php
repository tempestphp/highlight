<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Cpp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'nullptr', output: 'nullptr')]
#[PatternTest(input: 'true', output: 'true')]
final readonly class CppLiteralPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\b(?<match>NULL|false|nullptr|true)\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::LITERAL;
    }
}
