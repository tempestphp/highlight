<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sema\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Sema\SemaSyntax;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '(f #t)', output: '#t')]
#[PatternTest(input: '(nil? x)', output: null)]
final readonly class SemaLiteralPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return SemaSyntax::atom('#true|#false|#t|#f|true|false|nil');
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::LITERAL;
    }
}
