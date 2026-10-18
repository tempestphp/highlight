<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\CSharp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class CSharpTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\b(?<match>bool|byte|sbyte|char|decimal|double|float|int|uint|nint|nuint|long|ulong|short|ushort|object|string|void|dynamic|var|(?<!\[)[A-Z][A-Za-z0-9_]*)\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
