<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\C\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class CNumberPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<![\w.])(?<match>(?:0[xX][\dA-Fa-f]+(?:\.[\dA-Fa-f]*)?(?:[pP][+-]?\d+)?|0[bB][01]+|(?:\d+\.\d*|\.\d+|\d+)(?:[eE][+-]?\d+)?)(?:[uU](?:ll|LL|l|L)?|(?:ll|LL|l|L)[uU]?|[fFlL])?)(?![\w.])/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::NUMBER;
    }
}
