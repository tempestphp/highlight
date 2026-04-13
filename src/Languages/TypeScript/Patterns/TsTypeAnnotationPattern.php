<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\TypeScript\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final class TsTypeAnnotationPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<=[\w\)\]])\s*:\s*(?<match>[A-Z][\w]*(?:\.[A-Z][\w]*)*(?:\[\])?)/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
