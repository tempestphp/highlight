<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sema\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Sema\SemaSyntax;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '(define cities (list))', output: 'cities')]
#[PatternTest(input: '(set! count 1)', output: 'count')]
#[PatternTest(input: '(define (greet name) name)', output: null)]
final readonly class SemaDefinedVariablePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/\((?:' . SemaSyntax::alternatives(SemaSyntax::VARIABLE_DEFINITION_FORMS) . ')\s+(?<match>' . SemaSyntax::SYMBOL . '++)/u';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VARIABLE;
    }
}
