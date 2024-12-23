<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest('set (string $value', 'string')]
#[PatternTest('set(string $value', 'string')]
#[PatternTest('set(Author $value', 'Author')]
final readonly class PropertyHookSetParameterTypePattern implements Pattern
{
    use IsPattern;

    #[\Override]
    public function getPattern(): string
    {
        return 'set\s*\((?<match>[\w]+)';
    }

    #[\Override]
    public function getTokenType(): TokenType
    {
        return TokenTypeEnum::TYPE;
    }
}
