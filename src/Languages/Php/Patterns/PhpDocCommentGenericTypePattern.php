<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '@param class-string<T> $className', output: 'T')]
final readonly class PhpDocCommentGenericTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\<(?<match>[\w]+)\>';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::GENERIC;
    }
}
