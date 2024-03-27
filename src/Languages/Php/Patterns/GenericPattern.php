<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class GenericPattern implements Pattern
{
    use IsPattern;

    public function __construct(
        private string $pattern,
        private TokenTypeEnum $tokenType,
    ) {
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function getTokenType(): TokenTypeEnum
    {
        return $this->tokenType;
    }
}
