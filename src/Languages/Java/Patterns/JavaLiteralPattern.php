<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Java\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class JavaLiteralPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\b(?<match>true|false|null)\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::LITERAL;
    }
}
