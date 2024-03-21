<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Yaml\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(input: 'branches: [main]', output: ['[', ']'])]
final class YamlArrayBracketsPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>(\[|\]))';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::PROPERTY;
    }
}
