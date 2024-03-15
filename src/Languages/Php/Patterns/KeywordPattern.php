<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenType;

final readonly class KeywordPattern implements Pattern
{
    use IsPattern;

    public function __construct(private string $keyword)
    {
    }

    public function getPattern(): string
    {
        return "\b(?<match>{$this->keyword})\s";
    }

    public function getTokenType(): TokenType
    {
        return TokenType::KEYWORD;
    }
}
