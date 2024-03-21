<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\DocComment\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(input: '@template T', output: 'T')]
final readonly class DocCommentTemplateTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\@template(\s)+(?<match>[\w]+)';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::GENERIC;
    }
}
