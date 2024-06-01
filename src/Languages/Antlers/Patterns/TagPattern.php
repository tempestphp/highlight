<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Antlers\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final class TagPattern implements Pattern
{
    use IsPattern;

    public function __construct(private readonly string $keyword)
    {
    }

    public function getPattern(): string
    {
        /** @lang PhpRegExp */
        return "/^.*\/?(?<match>({$this->keyword}))/i";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
