<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'public public(set) Foo $foo', output: 'set')]
#[PatternTest(input: 'public public(get) Foo $foo', output: 'get')]
#[PatternTest(input: 'public private(get) Foo $foo', output: 'get')]
#[PatternTest(input: 'public protected(get) Foo $foo', output: 'get')]
final readonly class PhpAsymmetricPropertyPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(public|private|protected)\((?<match>set|get)\)/';
    }

    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::KEYWORD;
    }
}
