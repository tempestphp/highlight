<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\TypeScript\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final class TsGenericPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<=\w)(?<match><[A-Z][\w\s,\.\[\]]*>)/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::GENERIC;
    }
}
