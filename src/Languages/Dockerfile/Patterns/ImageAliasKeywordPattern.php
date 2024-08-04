<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Dockerfile\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'FROM php', output: null)]
#[PatternTest(input: 'FROM php:8.1', output: null)]
#[PatternTest(input: 'FROM php:8.1 AS stage-one', output: 'AS')]
#[PatternTest(input: ' FROM php:8.1 AS stage-one ', output: 'AS')]
final readonly class ImageAliasKeywordPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return "/^[\s]*FROM[\s][\S]+[\s](?<match>AS)[\s][\S]+/m";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
