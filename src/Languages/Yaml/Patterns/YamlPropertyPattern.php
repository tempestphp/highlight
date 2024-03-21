<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Yaml\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(input: 'name: Fix Styling', output: 'name')]
#[PatternTest(input: 'property-name: value', output: 'property-name')]
final class YamlPropertyPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>[\w-]+)\:';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::KEYWORD;
    }
}
