<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Toml\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final class TomlNumberPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return <<<'REGEX'
/(?<![A-Za-z0-9_.-])(?<match>[+-]?(?:inf|nan)|0x[0-9A-Fa-f](?:_?[0-9A-Fa-f])*|0o[0-7](?:_?[0-7])*|0b[01](?:_?[01])*|[+-]?(?:\d(?:_?\d)*\.\d(?:_?\d)*(?:[eE][+-]?\d(?:_?\d)*)?|\d(?:_?\d)*[eE][+-]?\d(?:_?\d)*|\d(?:_?\d)*))(?![A-Za-z0-9_.-])/
REGEX;
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::NUMBER;
    }
}
