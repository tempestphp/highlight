<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '@param array|string $concrete', output: '$concrete')]
#[PatternTest(input: '@param $concrete', output: '$concrete')]
#[PatternTest(input: '@var Foo $concrete', output: '$concrete')]
#[PatternTest(input: '@var $concrete', output: '$concrete')]
final readonly class PhpDocCommentVariablePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\\$[\w]+)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VARIABLE;
    }
}
