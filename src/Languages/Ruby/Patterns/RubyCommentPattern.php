<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\Languages\Ruby\RubyLexer;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'x = 1 # set x', output: '# set x')]
#[PatternTest(
    input: '=begin
=end?
=end',
    output: '=begin
=end?
=end',
)]
#[PatternTest(input: 'x = "# not a comment"', output: null)]
#[PatternTest(input: 'x =begin', output: null)]
#[PatternTest(
    input: 'text = <<TEXT
=begin
TEXT',
    output: null,
)]
final readonly class RubyCommentPattern implements Pattern
{
    public function match(string $content): array
    {
        return ['match' => new RubyLexer()->lex($content)['comment']];
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::COMMENT;
    }
}
