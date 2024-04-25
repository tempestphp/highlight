<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '@var array|string $concrete', output: 'array|string')]
#[PatternTest(input: '@var \\Foo $concrete', output: '\\Foo')]
#[PatternTest(input: '@var \DateTimeImmutable|null', output: '\DateTimeImmutable|null')]
#[PatternTest(input: '/** @var Foo[] */', output: 'Foo[] ')]
final readonly class PhpDocCommentVarTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\@var(\s)+(?<match>.*?)( \$|\*|$)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
