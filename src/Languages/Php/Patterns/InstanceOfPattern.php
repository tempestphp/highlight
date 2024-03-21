<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(input: 'instanceof Closure', output: 'Closure')]
#[PatternTest(input: 'instanceof \\Foo\\Bar', output: '\\Foo\\Bar')]
final class InstanceOfPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return 'instanceof\s(?<match>[\w\\\\]+)';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::TYPE;
    }
}
