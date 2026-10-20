<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Jsx\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '<><div /></>', output: ['<>', '</>'])]
final readonly class JsxFragmentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match><\/?>)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
