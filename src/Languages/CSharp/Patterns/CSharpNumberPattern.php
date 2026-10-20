<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\CSharp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class CSharpNumberPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<![\w.])(?<match>(?:0[xX][\dA-Fa-f](?:_?[\dA-Fa-f])*|0[bB][01](?:_?[01])*|(?:\d(?:_?\d)*(?:\.\d(?:_?\d)*)?|\.\d(?:_?\d)*)(?:[eE][+-]?\d(?:_?\d)*)?)(?:[uUlLfFdDmM]{1,2})?)(?![\w.])/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::NUMBER;
    }
}
