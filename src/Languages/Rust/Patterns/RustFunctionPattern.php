<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Rust\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class RustFunctionPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\b(?<match>(?:r#)?[A-Za-z_]\w*)(?=\s*(?:<[^<>{};()]*>)?\s*\()';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
