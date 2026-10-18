<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\C\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class CTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>(?<=\bstruct\s)[A-Za-z_]\w*|(?<=\bunion\s)[A-Za-z_]\w*|(?<=\benum\s)[A-Za-z_]\w*|\b(?:_Bool|_Complex|_Decimal32|_Decimal64|_Decimal128|char|double|float|int|long|short|signed|unsigned|void)\b)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
