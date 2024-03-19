<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\JavaScript\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(input: 'Object.foo()', output: 'foo')]
final readonly class JsPropertyPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\.(?<match>[\w]+)';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::PROPERTY;
    }
}
