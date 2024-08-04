<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Dockerfile\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'FROM php', output: 'php')]
#[PatternTest(input: ' FROM php', output: 'php')]
#[PatternTest(input: 'FROM php:8.1', output: 'php')]
#[PatternTest(input: 'FROM php/cli:8.1', output: 'php/cli')]
#[PatternTest(input: 'FROM php:8.1 AS stage-one', output: 'php')]

final readonly class ImageNamePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return "/^[\s]*FROM[\s](?<match>[\w\/]+)/m";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
