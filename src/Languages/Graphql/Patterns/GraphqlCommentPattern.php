<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Graphql\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '# Comment', output: '# Comment')]
#[PatternTest(input: '"""Comment"""', output: '"""Comment"""')]
#[PatternTest(
    input: '"""
    Comment
    """',
    output: '"""
    Comment
    """'
)]
final class GraphqlCommentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>#.*|"""[\s\S]*?""")';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::COMMENT;
    }
}
