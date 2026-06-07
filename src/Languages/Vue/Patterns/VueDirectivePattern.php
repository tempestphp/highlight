<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Vue\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class VueDirectivePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<=\s)(?<match>v-(?:if|else-if|else|for|show|model|bind|on|html|text|pre|cloak|once|slot|memo))\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
