<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Ruby\RubyLexer;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'User.new(name: "Jane")', output: 'name')]
#[PatternTest(input: '{ admin?: true }', output: 'admin?')]
#[PatternTest(input: 'Foo::Bar', output: null)]
#[PatternTest(input: 'a ? b: c', output: null)]
#[PatternTest(input: 'a ?  b: c', output: null)]
#[PatternTest(input: 'a ? call(b: c) : d', output: 'b')]
#[PatternTest(input: 'user.allowed? role: :admin', output: 'role')]
final readonly class RubyHashKeyPattern implements Pattern
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
        return '/(?<=\s)\?\s*[A-Za-z_]\w*[?!]?:(?!:)(*SKIP)(*FAIL)|(?<![\w:])(?<match>[A-Za-z_]\w*[?!]?):(?!:)/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
