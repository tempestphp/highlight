<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Graphql\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '... on User', output: '...')]
#[PatternTest(input: 'id: ID!', output: [':', '!'])]
final class GraphqlPunctuationPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\.{3}|[!():=\[\]{|}]|(?<!\.)\.(?!\.))';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::OPERATOR;
    }
}
