<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Rust\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '"hello"', output: '"hello"')]
#[PatternTest(input: 'r#"hello"#', output: 'r#"hello"#')]
#[PatternTest(input: 'c"hello"', output: 'c"hello"')]
final readonly class RustStringPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>[bc]?r(?<hashes>#{0,255})".*?"\k<hashes>|[bc]?"(?:\\\\.|[^"\\\\])*")/s';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
