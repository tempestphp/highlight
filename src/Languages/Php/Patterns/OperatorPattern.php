<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final class OperatorPattern implements Pattern
{
    use IsPattern;

    public function __construct(private string $operator)
    {
    }

    public function getPattern(): string
    {
        return "/\s(?<!\\$)(?<match>{$this->operator})(\s|\()/";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::OPERATOR;
    }
}
