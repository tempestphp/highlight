<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Rust\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class RustLifetimePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return "(?<!\\w)(?<match>'[A-Za-z_]\\w*)(?!')\\b";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
