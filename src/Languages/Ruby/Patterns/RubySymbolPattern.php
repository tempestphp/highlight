<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Ruby\RubyLexer;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'attr_reader :name', output: ':name')]
#[PatternTest(input: 'before_action :admin?', output: ':admin?')]
#[PatternTest(input: '{ :id => 1 }', output: ':id')]
#[PatternTest(input: 'Admin::User', output: null)]
#[PatternTest(input: 'instance_variable_get(:@name)', output: ':@name')]
#[PatternTest(input: 'alias_method :name=, :set_name', output: [':name=', ':set_name'])]
#[PatternTest(input: 'send(:==, :[])', output: [':==', ':[]'])]
#[PatternTest(input: 'key = :"#{user["name"]}"', output: ':"#{user["name"]}"')]
final readonly class RubySymbolPattern implements Pattern
{
    use IsPattern {
        match as matchBareSymbols;
    }

    public function match(string $content): array
    {
        return [
            'match' => [
                ...$this->matchBareSymbols(new RubyLexer()->code($content))['match'] ?? [],
                ...new RubyLexer()->lex($content)['symbol'],
            ],
        ];
    }

    public function getPattern(): string
    {
        return '(?<![\w:])(?<match>:(?:(?:@@?|\$)[A-Za-z_]\w*|[A-Za-z_]\w*(?:[?!]|=(?![=>~]))?))';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::LITERAL;
    }
}
