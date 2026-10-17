<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\Languages\Ruby\RubyLexer;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'email.match?(/@/)', output: '/@/')]
#[PatternTest(input: 'name =~ /^a[\/"]b/i', output: '/^a[\/"]b/i')]
#[PatternTest(input: 'x = a / b / c', output: null)]
#[PatternTest(input: 'ratio = total/count', output: null)]
final readonly class RubyRegexPattern implements Pattern
{
    public function match(string $content): array
    {
        return ['match' => new RubyLexer()->lex($content)['regex']];
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
