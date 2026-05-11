<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Graphql\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'isActive: "Test string"', output: 'Test string')]
final class GraphqlStringPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '"(?<match>([^"\\\\]|\\\\.)*)"';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
