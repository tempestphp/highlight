<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Ruby\RubyLexer;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'total = 1_000', output: '1_000')]
#[PatternTest(input: 'ratio = 2.5e3', output: '2.5e3')]
#[PatternTest(input: 'mask = 0x1F', output: '0x1F')]
#[PatternTest(input: '(1..10)', output: ['1', '10'])]
#[PatternTest(input: '1e1_0; 0d10; 1r; 2i', output: ['1e1_0', '0d10', '1r', '2i'])]
#[PatternTest(input: 'user_1', output: null)]
final readonly class RubyNumberPattern implements Pattern
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
        return '\b(?<match>(?:0[xX][\da-fA-F](?:_?[\da-fA-F])*|0[bB][01](?:_?[01])*|0[oO]?[0-7](?:_?[0-7])*|0[dD]\d(?:_?\d)*|\d(?:_?\d)*(?:\.\d(?:_?\d)*)?(?:[eE][+-]?\d(?:_?\d)*)?)(?:ri|r|i)?)\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::NUMBER;
    }
}
