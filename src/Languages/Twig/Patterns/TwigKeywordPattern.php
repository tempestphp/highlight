<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Twig\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final class TwigKeywordPattern implements Pattern
{
    use IsPattern;

    public function __construct(private string $keyword)
    {
    }

    #[\Override]
    public function getPattern(): string
    {
        return "\b(?<match>{$this->keyword})\b";
    }

    #[\Override]
    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
