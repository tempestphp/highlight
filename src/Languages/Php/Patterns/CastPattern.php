<?php

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '(string) $bar', output: 'string')]
#[PatternTest(input: '(int) $bar', output: 'int')]
#[PatternTest(input: '(integer) $bar', output: 'integer')]
#[PatternTest(input: '(void) $bar', output: 'void')]
#[PatternTest(input: '(bool) $bar', output: 'bool')]
#[PatternTest(input: '(boolean) $bar', output: 'boolean')]
#[PatternTest(input: '(float) $bar', output: 'float')]
#[PatternTest(input: '(double) $bar', output: 'double')]
#[PatternTest(input: '(real) $bar', output: 'real')]
#[PatternTest(input: '(binary) $bar', output: 'binary')]
#[PatternTest(input: '(array) $bar', output: 'array')]
#[PatternTest(input: '(object) $bar', output: 'object')]
#[PatternTest(input: '(unset) $bar', output: 'unset')]
final class CastPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\((?<match>(string|int|integer|void|bool|boolean|float|double|real|binary|array|object|unset))\)';
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::TYPE;
    }
}