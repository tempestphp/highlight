<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Gdscript\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(input: 'foo as int', output: 'int')]
#[PatternTest(input: '(foo as int)', output: 'int')]
#[PatternTest(input: '%Agent as NavigationAgent2D)', output: 'NavigationAgent2D')]
final readonly class AsTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(as)\s+(?<match>\w+)[\n\)]+';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::TYPE;
    }
}
