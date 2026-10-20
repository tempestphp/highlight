<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Kotlin\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class KotlinAnnotationPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>@(?:file|get|set|field|property|receiver|param|setparam|delegate):[A-Za-z_]\w*|@[A-Za-z_]\w*(?:\.[A-Za-z_]\w*)*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::ATTRIBUTE;
    }
}
