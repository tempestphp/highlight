<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Cpp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class CppNumberPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<![\w.])(?<match>(?:0[xX][\dA-Fa-f](?:\'?[\dA-Fa-f])*(?:\.[\dA-Fa-f](?:\'?[\dA-Fa-f])*)?(?:[pP][+-]?\d(?:\'?\d)*)?|0[bB][01](?:\'?[01])*|(?:\d(?:\'?\d)*(?:\.\d(?:\'?\d)*)?|\.\d(?:\'?\d)*)(?:[eE][+-]?\d(?:\'?\d)*)?)(?:[uU](?:ll|LL|l|L)?|(?:ll|LL|l|L)[uU]?|[fFlLzZ])?)(?![\w.])/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::NUMBER;
    }
}
