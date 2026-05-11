<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Graphql\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'type Test {}', output: 'type')]
final class GraphqlKeywordPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\b(query|mutation|subscription|input|schema|implements|type|interface|union|scalar|fragment|enum|on)\b)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
