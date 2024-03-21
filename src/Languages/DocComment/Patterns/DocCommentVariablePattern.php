<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\DocComment\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(input: '@param array|string $concrete', output: '$concrete')]
#[PatternTest(input: '@param $concrete', output: '$concrete')]
#[PatternTest(input: '@var Foo $concrete', output: '$concrete')]
#[PatternTest(input: '@var $concrete', output: '$concrete')]
final readonly class DocCommentVariablePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\\$[\w]+)';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::VARIABLE;
    }
}
