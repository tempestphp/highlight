<?php

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(input: 'catch (Foo) {}', output: 'Foo')]
#[PatternTest(input: 'catch (Foo|Bar) {}', output: 'Foo|Bar')]
#[PatternTest(input: 'catch (Foo|Bar $bar) {}', output: null)]
final readonly class CatchTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return 'catch \((?<match>[\w\||]+)\)';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::TYPE;
    }
}