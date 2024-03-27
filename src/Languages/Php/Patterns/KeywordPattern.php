<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final class KeywordPattern implements Pattern
{
    use IsPattern;

    private bool $caseInsensitive = false;

    public function __construct(private string $keyword)
    {
    }

    public function caseInsensitive(): self
    {
        $this->caseInsensitive = true;

        return $this;
    }

    public function getPattern(): string
    {
        $pattern = "/\b(?<!\\$)(?<!\-\>)(?<match>{$this->keyword})(\$|\,|\)|\;|\:|\s|\()/";

        if ($this->caseInsensitive) {
            $pattern .= 'i';
        }

        return $pattern;
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
