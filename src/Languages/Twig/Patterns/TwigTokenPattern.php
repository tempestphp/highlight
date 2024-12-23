<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Twig\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class TwigTokenPattern implements Pattern
{
    use IsPattern;

    public function __construct(
        private string $regex,
        private TokenTypeEnum $type,
    ) {
    }

    public function getPattern(): string
    {
        return "/(?<match>{$this->regex})/";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return $this->type;
    }
}
