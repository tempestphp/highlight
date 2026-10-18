<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Java\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class JavaTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\b(?<match>boolean|byte|char|double|float|int|long|short|void|var|(?<!@)[A-Z][A-Za-z0-9_$]*)\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
