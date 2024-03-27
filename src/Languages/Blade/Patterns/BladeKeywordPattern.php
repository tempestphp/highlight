<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Blade\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(
    input: '@if()
        @endif()',
    output: ['@if', '@endif'],
)]
final readonly class BladeKeywordPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\@[\w]+)\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
