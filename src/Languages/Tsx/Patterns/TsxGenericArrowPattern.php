<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Tsx\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'const identity = <T,>(value: T) => value;', output: '<T,>')]
#[PatternTest(input: 'const item = <T extends { id: string },>(value: T) => value;', output: '<T extends { id: string },>')]
final readonly class TsxGenericArrowPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match><[A-Z][A-Za-z0-9_$]*(?:\s++extends\s++(?:[A-Za-z_$][\w$]*(?:\.[A-Za-z_$][\w$]*)*+|\{[^{}]*+\}))?\s*,?\s*>)(?=\s*\()';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::GENERIC;
    }
}
