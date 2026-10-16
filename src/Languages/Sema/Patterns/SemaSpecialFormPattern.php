<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sema\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Sema\SemaSyntax;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '(lambda (x) x)', output: 'lambda')]
#[PatternTest(input: '(llm/with-budget b)', output: 'llm/with-budget')]
#[PatternTest(input: "(list 'if)", output: null)]
final readonly class SemaSpecialFormPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<![^\s(\[{])(?<match>(?:' . SemaSyntax::alternatives(SemaSyntax::SPECIAL_FORMS) . '))' . SemaSyntax::ATOM_END . '/u';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
