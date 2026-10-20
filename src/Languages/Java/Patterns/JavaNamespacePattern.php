<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Java\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class JavaNamespacePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\b(?:package|import)\s+(?:static\s+)?(?<match>[A-Za-z_$][\w$]*(?:\.[A-Za-z_$*][\w$*]*)*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
