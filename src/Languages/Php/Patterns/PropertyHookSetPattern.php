<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(
    '     public string $name {
         set {',
    'set'
)]
#[PatternTest('set;', 'set')]
#[PatternTest('set =>', 'set')]
#[PatternTest('set (string $value', 'set')]
#[PatternTest('set(string $value', 'set')]
final readonly class PropertyHookSetPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>set)\s*({|;|=>|\()';
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::KEYWORD;
    }
}
