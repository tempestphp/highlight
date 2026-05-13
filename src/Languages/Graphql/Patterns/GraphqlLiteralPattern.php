<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Graphql\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'isActive: Boolean!', output: 'Boolean')]
final class GraphqlLiteralPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\b(true|false|null|ID|ID!|String|Float|Int|Boolean)\b)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
