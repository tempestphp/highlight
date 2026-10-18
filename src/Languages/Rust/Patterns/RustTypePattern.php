<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Rust\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class RustTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<![A-Za-z])(?<match>bool|char|str|f32|f64|i(?:8|16|32|64|128|size)|u(?:8|16|32|64|128|size)|[A-Z][\w]*)(?![\w!])';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
