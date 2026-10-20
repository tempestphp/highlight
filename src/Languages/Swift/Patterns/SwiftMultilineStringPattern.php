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
#[PatternTest(
    input: 'let text = """
say \""" if
"""',
    output: '"""
say \""" if
"""',
)]
final readonly class SwiftMultilineStringPattern implements Pattern
{
    use IsPattern;

    /**
     * Escapes are consumed first, so an escaped `\"""` doesn't close the string.
     */
    public function getPattern(): string
    {
        return '/(?<match>"""(?:\\\\[\s\S]|(?!""")[^\\\\])*""")/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
