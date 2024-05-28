<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Antlers\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final class KeywordPattern implements Pattern
{
    use IsPattern;

    public function __construct(
        private string $keyword,
        private readonly TokenTypeEnum $type = TokenTypeEnum::KEYWORD
    ) {
    }

    public function getPattern(): string
    {
        return "/(?<!\\$)(?<!\-\>)(?<match>({$this->keyword}))((\$|\,|\)|\;|\:|\s|\())/i";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return $this->type;
    }
}
