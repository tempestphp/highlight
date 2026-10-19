<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Toml\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final class TomlOperatorPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>\[\[|\]\]|\[|\]|\{|\}|=|,)/';
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::OPERATOR;
    }
}
