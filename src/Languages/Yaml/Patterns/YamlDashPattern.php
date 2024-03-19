<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Yaml\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(input: '- name: Setup problem matchers |', output: '-')]
final readonly class YamlDashPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/^[\s]*(?<match>-)/m';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::PROPERTY;
    }
}
