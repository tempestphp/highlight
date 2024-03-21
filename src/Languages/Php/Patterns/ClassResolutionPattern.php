<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(input: '$foo::class', output: 'class')]
final class ClassResolutionPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\:\:(?<match>class)';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::KEYWORD;
    }
}
