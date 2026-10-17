<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Ruby\RubyLexer;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'a <=> b', output: '<=>')]
#[PatternTest(input: 'count ||= 0', output: '||=')]
#[PatternTest(input: '{ id => 1 }', output: '=>')]
#[PatternTest(input: 'user&.name', output: '&.')]
#[PatternTest(input: 'a & b | ~c', output: ['&', '|', '~'])]
#[PatternTest(input: 'valid ? !enabled : save!', output: ['?', '!', ':'])]
final readonly class RubyOperatorPattern implements Pattern
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
        return '(?<match><=>|===?|=~|!~|!=|=>|->|\*\*=?|&&=?|\|\|=?|<<=?|>>=?|<=|>=|&\.|[-+*\/%&|^]=|\.\.\.?|[-+*\/%<>=&|^~]|(?<![\w?!])!|(?<=\s)\?(?=\s)|(?<=\s):(?!:))';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::OPERATOR;
    }
}
