<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\TypeScript\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final class TsBuiltInTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/\b(?<!\.)(?<match>string|number|boolean|any|unknown|never|bigint|symbol|object|undefined)\b/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
