<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Graphql\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'test: ID!', output: 'test')]
final class GraphqlFieldPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>[_A-Za-z][_0-9A-Za-z]*)(?=\s*:)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
