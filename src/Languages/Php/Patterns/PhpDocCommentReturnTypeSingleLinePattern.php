<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '/** @return array|string */', output: 'array|string')]
#[PatternTest(input: '/** @return \\Foo */', output: '\\Foo')]
final readonly class PhpDocCommentReturnTypeSingleLinePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\@return\s*(?<match>.*?)(\s*\*\/|$)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
