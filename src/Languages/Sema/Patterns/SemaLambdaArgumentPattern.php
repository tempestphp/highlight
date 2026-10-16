<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sema\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Sema\SemaSyntax;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '#(* % 2)', output: '%')]
#[PatternTest(input: '#(f %2 %&)', output: ['%2', '%&'])]
final readonly class SemaLambdaArgumentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return SemaSyntax::atom('%&|%\d*');
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VARIABLE;
    }
}
