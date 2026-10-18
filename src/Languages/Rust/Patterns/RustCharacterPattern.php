<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Rust\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class RustCharacterPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return "(?<match>b?'(?:\\\\.|[^'\\\\])')";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
