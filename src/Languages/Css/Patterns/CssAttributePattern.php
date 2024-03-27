<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Css\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(
    input: '.hl-comment {
        color: #888888;
        font-style: italic;
        font-family: "Radon", serif;
    }',
    output: ['color', 'font-style', 'font-family'],
)]
final readonly class CssAttributePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>[\w\-]+):';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
