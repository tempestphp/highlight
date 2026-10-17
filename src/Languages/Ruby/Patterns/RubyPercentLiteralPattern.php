<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\Languages\Ruby\RubyLexer;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'names = %w[alice bob]', output: '%w[alice bob]')]
#[PatternTest(input: 'types = %i(admin user)', output: '%i(admin user)')]
#[PatternTest(input: 'quote = %q{it\'s {nested}}', output: '%q{it\'s {nested}}')]
#[PatternTest(input: 'path = %r|/users/\|admins|', output: '%r|/users/\|admins|')]
#[PatternTest(input: 'x % y', output: null)]
#[PatternTest(input: 'x = 10 %q[0]', output: null)]
final readonly class RubyPercentLiteralPattern implements Pattern
{
    public function match(string $content): array
    {
        return ['match' => new RubyLexer()->lex($content)['percent']];
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
