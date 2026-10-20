<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sema\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Sema\SemaSyntax;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '(+ 1 2)', output: '+')]
#[PatternTest(input: '(>= a b)', output: '>=')]
#[PatternTest(input: '(map + xs)', output: null)]
final readonly class SemaOperatorPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return SemaSyntax::head(SemaSyntax::alternatives(SemaSyntax::OPERATORS));
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::OPERATOR;
    }
}
