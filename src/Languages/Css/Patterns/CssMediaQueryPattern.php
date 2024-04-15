<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Css\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '@media only screen and (max-width: 500px) {', output: '@media only screen and (max-width: 500px) ')]
#[PatternTest(input: '@media (min-width: 30em) and (max-width: 50em) {', output: '@media (min-width: 30em) and (max-width: 50em) ')]
final readonly class CssMediaQueryPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\@media(.*)?){';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
