<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sema\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Sema\SemaSyntax;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '#\space', output: '#\space')]
#[PatternTest(input: '#\a', output: '#\a')]
#[PatternTest(input: '#\alarm', output: null)]
#[PatternTest(input: '#\;x', output: '#\;')]
final readonly class SemaCharacterPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/' . SemaSyntax::ATOM_START . '(?<match>#\\\\(?:(?:space|newline|tab|return|nul|\p{L})' . SemaSyntax::SYMBOL_END . '|[^\p{L}]))/u';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
