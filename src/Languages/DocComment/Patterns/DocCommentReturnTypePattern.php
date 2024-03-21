<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\DocComment\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(input: '@return array|string', output: 'array|string')]
#[PatternTest(input: '@return \\Foo', output: '\\Foo')]
final class DocCommentReturnTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\@return(\s)+(?<match>.*)';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::TYPE;
    }
}
