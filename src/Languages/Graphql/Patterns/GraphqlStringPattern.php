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
        // An unclosed string would be rescanned from each escaped quote inside it, so skip past it
        return '"(?<match>(?:[^"\\\\]++|\\\\.)*+)(?:"|(*SKIP)(*FAIL))';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
