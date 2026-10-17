<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '$stdout', output: '$stdout')]
final readonly class RubyGlobalVariablePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\$[A-Za-z_]\w*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VARIABLE;
    }
}
