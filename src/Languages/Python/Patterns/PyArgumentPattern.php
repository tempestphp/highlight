<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Python\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class PyArgumentPattern implements Pattern
{
    use IsPattern;

    #[\Override]
    public function getPattern(): string
    {
        return '(?<=,|\()\s*(?<match>\w+)s*=';
    }

    #[\Override]
    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VARIABLE;
    }
}
