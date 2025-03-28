<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Json\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '"age": 30', output: '30')]
final readonly class JsonNumberPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '-?\b(?<match>\d+(?:\.\d+)?(?:e[+-]?\d+)?)\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::NUMBER;
    }
}
