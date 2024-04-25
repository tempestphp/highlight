<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest('use function Tempest\redirect;', 'redirect')]
final readonly class UseFunctionNamePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return 'use function [\w\\\\]+\\\\(?<match>[\w]+);';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
