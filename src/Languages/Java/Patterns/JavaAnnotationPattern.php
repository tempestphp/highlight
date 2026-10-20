<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Java\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '@Override', output: '@Override')]
#[PatternTest(input: '@org.example.Marker', output: '@org.example.Marker')]
final readonly class JavaAnnotationPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>@[A-Za-z_$][\w$]*(?:\.[A-Za-z_$][\w$]*)*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::ATTRIBUTE;
    }
}
