<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Gdscript\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final class KeywordPattern implements Pattern
{
    use IsPattern;

    public function __construct(private readonly string $keyword)
    {
    }

    public function getPattern(): string
    {
        return "/\b(?<match>{$this->keyword})\b/";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
