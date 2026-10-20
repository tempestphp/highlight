<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Ruby\RubyLexer;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'def initialize', output: 'def')]
#[PatternTest(input: 'defined?(foo)', output: 'defined?')]
#[PatternTest(input: 'attr_reader :name', output: 'attr_reader')]
#[PatternTest(input: 'roles.include?(:admin)', output: null)]
#[PatternTest(input: '@class = 1', output: null)]
final readonly class RubyKeywordPattern implements Pattern
{
    use IsPattern {
        match as matchContent;
    }

    public function match(string $content): array
    {
        return $this->matchContent(new RubyLexer()->code($content));
    }

    public function __construct(private array $keywords = [
        '__ENCODING__', '__FILE__', '__LINE__', 'BEGIN', 'END', 'alias', 'and',
        'begin', 'break', 'case', 'class', 'def', 'defined\?', 'do', 'else', 'elsif',
        'end', 'ensure', 'for', 'if', 'in', 'module', 'next', 'not', 'or', 'redo',
        'rescue', 'retry', 'return', 'self', 'super', 'then', 'undef', 'unless',
        'until', 'when', 'while', 'yield',
        'attr_accessor', 'attr_reader', 'attr_writer', 'extend', 'include',
        'module_function', 'prepend', 'private', 'private_constant', 'protected',
        'public', 'raise', 'require', 'require_relative',
    ])
    {
    }

    public function getPattern(): string
    {
        $keywords = implode('|', $this->keywords);

        return "(?<![.@$:])\b(?<match>(?:{$keywords}))(?![\w?!])";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
