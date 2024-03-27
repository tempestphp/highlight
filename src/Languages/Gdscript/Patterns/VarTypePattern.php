<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Gdscript\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'var foo:int=', output: 'int')]
#[PatternTest(input: 'var foo : int =', output: 'int')]
#[PatternTest(input: 'foo : int', output: 'int')]
final readonly class VarTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\:[^\S\n]*(?<match>\w+)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
