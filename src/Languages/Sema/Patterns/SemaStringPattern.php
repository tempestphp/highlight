<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sema\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Sema\SemaSyntax;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '(display "Oslo")', output: '"Oslo"')]
#[PatternTest(input: '#"^[a-z]+$"', output: '#"^[a-z]+$"')]
#[PatternTest(input: 'f"hi ${name}"', output: 'f"hi ${name}"')]
#[PatternTest(input: '; say "hi"', output: null)]
#[PatternTest(input: '(str/f"x")', output: '"x"')]
#[PatternTest(input: '(f "unterminated', output: '"unterminated')]
final readonly class SemaStringPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?:;.*|' . SemaSyntax::CHARACTER . ')(*SKIP)(*FAIL)|(?<match>' . SemaSyntax::STRING . ')/u';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
