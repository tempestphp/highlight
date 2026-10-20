<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Toml\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final class TomlDateTimePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<![A-Za-z0-9_-])(?<match>(?:\d{4}-\d{2}-\d{2}(?:[Tt ]\d{2}:\d{2}:\d{2}(?:\.\d+)?(?:[Zz]|[+-]\d{2}:\d{2})?)?|\d{2}:\d{2}:\d{2}(?:\.\d+)?))(?![A-Za-z0-9_-])/';
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::VALUE;
    }
}
