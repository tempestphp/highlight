<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Ruby\RubyLexer;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'def initialize(name)', output: 'initialize')]
#[PatternTest(input: 'def self.find(id)', output: 'find')]
#[PatternTest(input: 'def admin?', output: 'admin?')]
#[PatternTest(input: 'def name=(value)', output: 'name=')]
#[PatternTest(input: 'def User.find(id)', output: 'find')]
#[PatternTest(input: 'def <=>(other)', output: '<=>')]
final readonly class RubyMethodNamePattern implements Pattern
{
    use IsPattern {
        match as matchContent;
    }

    public function match(string $content): array
    {
        return $this->matchContent(new RubyLexer()->code($content));
    }

    public function getPattern(): string
    {
        return '\bdef\s+(?:[A-Za-z_][\w:]*\.)?(?<match>[A-Za-z_]\w*[?!=]?|\[\]=?|<=>|===?|=~|!=|!~|\*\*|[-+!~]@|<<|>>|<=|>=|[-+*\/%<>!~^&|])';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
