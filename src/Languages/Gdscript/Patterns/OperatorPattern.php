<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Gdscript\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final class OperatorPattern implements Pattern
{
    use IsPattern;

    public function __construct(private readonly string $operator)
    {
    }

    public function getPattern(): string
    {
        $quoted = preg_quote($this->operator, '/');

        return "/(?<match>{$quoted})/";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::OPERATOR;
    }
}
