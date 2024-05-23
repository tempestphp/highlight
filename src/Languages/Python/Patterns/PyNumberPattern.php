<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Python\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class PyNumberPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\b0(?:[bB](?:_?[01])+|[oO](?:_?[0-7])+|[xX](?:_?[a-fA-F0-9])+)\b|(?:\b\d+(?:_\d+)*(?:\.(?:\d+(?:_\d+)*)?)?|\B\.\d+(?:_\d+)*)(?:[eE][+-]?\d+(?:_\d+)*)?j?(?!\w))';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::NUMBER;
    }
}
