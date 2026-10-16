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
final readonly class SemaCharacterPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return SemaSyntax::atom('#\\\\(?:space|newline|tab|return|nul|.)');
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
