<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Rust\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '\'\\u{41}\'', output: '\'\\u{41}\'')]
#[PatternTest(input: '\'é\'', output: '\'é\'')]
#[PatternTest(input: '\'x\'', output: '\'x\'')]
#[PatternTest(input: '\'\\n\'', output: '\'\\n\'')]
#[PatternTest(input: 'b\'x\'', output: 'b\'x\'')]
final readonly class RustCharacterPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return "(?<match>b?'(?:\\\\u\\{[0-9A-Fa-f_]{1,6}\\}|\\\\x[0-9A-Fa-f]{2}|\\\\.|[^'\\\\]|[\\xC2-\\xDF][\\x80-\\xBF]|[\\xE0-\\xEF][\\x80-\\xBF]{2}|[\\xF0-\\xF4][\\x80-\\xBF]{3})')";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
