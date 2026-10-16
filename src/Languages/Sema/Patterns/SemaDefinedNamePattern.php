<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sema\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Sema\SemaSyntax;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '(defagent guide {})', output: 'guide')]
#[PatternTest(input: '(define (greet name) name)', output: 'greet')]
#[PatternTest(input: '(define x 1)', output: null)]
final readonly class SemaDefinedNamePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/\((?:(?:' . SemaSyntax::alternatives(SemaSyntax::FUNCTION_DEFINITION_FORMS) . ')\s+\(?|(?:define|def)\s+\()(?<match>' . SemaSyntax::SYMBOL . '++)/u';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
