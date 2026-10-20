<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sema\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Sema\SemaSyntax;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '(lambda (x) x)', output: 'lambda')]
#[PatternTest(input: '(term/with-mouse (draw))', output: 'term/with-mouse')]
#[PatternTest(input: '(llm/with-budget {} thunk)', output: null)]
#[PatternTest(input: "(list 'if)", output: null)]
#[PatternTest(input: '(llm/complete prompt message)', output: null)]
#[PatternTest(input: '(step "fetch" (fetch url))', output: 'step')]
#[PatternTest(input: '(+ step 1)', output: null)]
final readonly class SemaSpecialFormPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return SemaSyntax::head(SemaSyntax::alternatives([...SemaSyntax::SPECIAL_FORMS, ...SemaSyntax::PRELUDE_MACROS]));
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
