<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Dockerfile\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'FROM php', output: null)]
#[PatternTest(input: 'FROM php', output: null)]
#[PatternTest(input: 'FROM php:8.1', output: '8.1')]
#[PatternTest(input: 'FROM php/cli:8.1', output: '8.1')]
#[PatternTest(input: 'FROM php:8.1 AS stage-one', output: '8.1')]

final readonly class ImageTagPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return "/^[\s]*FROM[\s][\w\/]+:(?<match>\S+)[\s]?/m";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
