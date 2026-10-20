<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Rust\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '{', output: '{')]
#[PatternTest(input: ';', output: ';')]
final readonly class RustPunctuationPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>[{}()\[\],;])';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::OPERATOR;
    }
}
