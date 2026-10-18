<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Kotlin\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class KotlinCallablePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<!\bclass )(?<!\binterface )(?<!\bobject )(?<match>(?<=::)[A-Za-z_]\w*|\b(?!(?:catch|for|if|when|while)\b)[A-Za-z_]\w*(?=\s*\())';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
