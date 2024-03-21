<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest('use Illuminate\Contracts\Container\Container as ContainerContract', 'ContainerContract')]
final class UseAsPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return 'use [\w\\\\]+ as (?<match>[\w]+)';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::TYPE;
    }
}
