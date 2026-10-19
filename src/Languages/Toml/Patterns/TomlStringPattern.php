<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Toml\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final class TomlStringPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return <<<'REGEX'
/(?<match>"""(?:\\[\s\S]|"{1,2}(?!")|[^"\\])*"""|'''(?:'{1,2}(?!')|[^'])*'''|"(?:\\(?:["\\bfnrt]|u[0-9A-Fa-f]{4}|U[0-9A-Fa-f]{8})|[^"\\\r\n])*"|'[^'\r\n]*')/
REGEX;
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::VALUE;
    }
}
