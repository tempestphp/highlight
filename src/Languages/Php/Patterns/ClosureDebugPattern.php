<?php

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest('Tempest\Http\{closure}()', 'Tempest\Http\{closure}')]
#[PatternTest('{closure}()', '{closure}')]
final class ClosureDebugPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>[\w\\\\]*\{closure\})\(';
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::PROPERTY;
    }
}