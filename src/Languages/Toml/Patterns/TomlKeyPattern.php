<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Toml\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final class TomlKeyPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return <<<'REGEX'
/(?:^[\t ]*|(?<=[{,])[\t ]*)(?<match>(?:"(?:\\(?:["\\bfnrt]|u[0-9A-Fa-f]{4}|U[0-9A-Fa-f]{8})|[^"\\\r\n])*"|'[^'\r\n]*'|[A-Za-z0-9_-]+)(?:[\t ]*\.[\t ]*(?:"(?:\\(?:["\\bfnrt]|u[0-9A-Fa-f]{4}|U[0-9A-Fa-f]{8})|[^"\\\r\n])*"|'[^'\r\n]*'|[A-Za-z0-9_-]+))*)(?=[\t ]*=)/m
REGEX;
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::PROPERTY;
    }
}
