<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\Languages\Ruby\RubyLexer;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'name = "Jane"', output: '"Jane"')]
#[PatternTest(input: "name = 'Jane'", output: "'Jane'")]
#[PatternTest(input: 'path = "C:\\\\"; x = "y"', output: ['"C:\\\\"', '"y"'])]
#[PatternTest(input: 'text = "a
b"', output: '"a
b"')]
#[PatternTest(input: 'greeting = "Hi #{user["name"]}"', output: '"Hi #{user["name"]}"')]
#[PatternTest(input: "# don't
x = 'a'", output: "'a'")]
#[PatternTest(input: "words = %w[it's]", output: null)]
final readonly class RubyStringPattern implements Pattern
{
    public function match(string $content): array
    {
        return ['match' => new RubyLexer()->lex($content)['string']];
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
