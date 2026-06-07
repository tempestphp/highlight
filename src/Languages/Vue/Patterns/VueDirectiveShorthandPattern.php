<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Vue\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class VueDirectiveShorthandPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<=\s)(?<match>[:@#])[\w-]+';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
