<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Toml\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final class TomlCommentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>#[^\r\n]*)/';
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::COMMENT;
    }
}
