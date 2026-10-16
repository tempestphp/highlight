<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sema\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Sema\SemaSyntax;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '(llm/complete prompt)', output: 'llm/complete')]
#[PatternTest(input: '(define (gen/int lo) lo)', output: null)]
final readonly class SemaNamespacedCallPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<=\()(?<!define \()(?<!def \()(?<match>[\p{L}\p{N}_-]+\/' . SemaSyntax::SYMBOL . '+)/u';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VARIABLE;
    }
}
