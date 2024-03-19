<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Xml\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(
    input: 'test
            <!-- 
            foo
            -->
            test',
    output: '<!-- 
            foo
            -->'
)]
final readonly class XmlCommentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\<!--(.|\n)*-->)';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::COMMENT;
    }
}
