<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sema\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Sema\SemaSyntax;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '; budgets', output: '; budgets')]
#[PatternTest(input: '#!/usr/bin/env sema', output: '#!/usr/bin/env sema')]
#[PatternTest(input: '(display "a;b")', output: null)]
final readonly class SemaCommentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?:' . SemaSyntax::STRING . '|' . SemaSyntax::CHARACTER . ')(*SKIP)(*FAIL)|(?<match>;.*|\A#!.*)/u';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::COMMENT;
    }
}
