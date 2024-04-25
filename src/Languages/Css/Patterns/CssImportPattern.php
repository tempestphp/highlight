<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Css\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: "@import main.css", output: '@import')]
final readonly class CssImportPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\@import)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
