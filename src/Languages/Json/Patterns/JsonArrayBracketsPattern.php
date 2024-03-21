<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Json\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(input: '"foo": ["bar"]', output: ['[', ']'])]
final class JsonArrayBracketsPattern implements Pattern
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
