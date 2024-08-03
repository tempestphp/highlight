<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Dockerfile\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class KeywordPattern implements Pattern
{
    use IsPattern;

    public function __construct(private string $keyword)
    {
    }

    public function getPattern(): string
    {
        return "/^[\s]*(?<match>{$this->keyword})[\s].*/m";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
