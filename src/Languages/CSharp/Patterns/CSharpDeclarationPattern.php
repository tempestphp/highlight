<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\CSharp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'class User {}', output: 'User')]
#[PatternTest(input: 'record Point(int X);', output: 'Point')]
final readonly class CSharpDeclarationPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\b(?:class|interface|struct|record|enum)\h+(?<match>@?[A-Za-z_]\w*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
