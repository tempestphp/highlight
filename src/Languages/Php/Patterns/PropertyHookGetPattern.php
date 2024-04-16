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
         get {',
    'get'
)]
#[PatternTest(
    '     public string $name {
         get =>',
    'get'
)]
#[PatternTest('get;', 'get')]
final readonly class PropertyHookGetPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>get)\s*({|=>|;)';
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::KEYWORD;
    }
}
