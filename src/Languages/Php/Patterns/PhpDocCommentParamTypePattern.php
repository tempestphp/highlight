<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '@param array|string $concrete', output: 'array|string')]
#[PatternTest(input: '@param \\Foo $concrete', output: '\\Foo')]
final readonly class PhpDocCommentParamTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\@param(\s)+(?<match>.*?) \\$';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
