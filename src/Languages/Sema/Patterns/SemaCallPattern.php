<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sema\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Sema\SemaSyntax;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '(println "hi")', output: 'println')]
#[PatternTest(input: '(string/append a b)', output: 'string/append')]
#[PatternTest(input: '(1 2)', output: null)]
#[PatternTest(input: '[a b]', output: null)]
#[PatternTest(input: "'(a b)", output: null)]
#[PatternTest(input: '(foo:bar x)', output: 'foo')]
#[PatternTest(input: '(defmacro m (. body) body)', output: 'defmacro')]
final readonly class SemaCallPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<=\()(?<![\'`]\()(?!\.' . SemaSyntax::SYMBOL_END . ')(?<match>' . SemaSyntax::SYMBOL_START . SemaSyntax::SYMBOL . '*+)/u';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
