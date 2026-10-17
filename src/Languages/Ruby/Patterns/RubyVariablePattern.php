<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Languages\Ruby\RubyLexer;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '@name = name', output: '@name')]
#[PatternTest(input: '@@count += 1', output: '@@count')]
#[PatternTest(input: '$stdout.puts', output: '$stdout')]
#[PatternTest(input: 'puts $1, $~, $!', output: ['$1', '$~', '$!'])]
final readonly class RubyVariablePattern implements Pattern
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
        return '(?<match>(?:@@?|\$)[A-Za-z_]\w*|\$(?:\d+|-\w|[!@&`\'+~=\/\\\\,;.<>*$?:"]))';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VARIABLE;
    }
}
