<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '$foo::class', output: 'class')]
final readonly class ClassResolutionPattern implements Pattern
{
    use IsPattern;

    #[\Override]
    public function getPattern(): string
    {
        return '\:\:(?<match>class)';
    }

    #[\Override]
    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
