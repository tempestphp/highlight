<?php

namespace Tempest\Highlight\Languages\Blade\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final class BladeKeywordPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>@[\w]+)/';
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::KEYWORD;
    }
}