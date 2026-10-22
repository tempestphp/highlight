<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\CSharp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '$"Hello {name}"', output: '$"Hello {name}"')]
#[PatternTest(input: '"""hello"""', output: '"""hello"""')]
#[PatternTest(input: '\'x\'', output: '\'x\'')]
final readonly class CSharpStringPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>\$*+(?<delimiter>"{3,})(?:(?!\k<delimiter>)[\s\S])*+\k<delimiter>|(?:\$@|@\$|@)"(?:[^"]++|"")*+"|\$?"(?:\\\\.|[^"\\\\\r\n]++)*+"|\'(?:\\\\.|[^\'\\\\\r\n])\')/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
