<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Swift\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(
    input: 'let text = """
Hello, "world"
"""',
    output: '"""
Hello, "world"
"""',
)]
final readonly class SwiftMultilineStringPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>"""(.|\n)*?""")/m';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
