<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: ':name', output: ':name')]
#[PatternTest(input: 'case x when :a then 1 end', output: ':a')]
final readonly class RubySymbolPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<!:)(?<match>:(?!:)(?:[A-Za-z_]\w*[?!=]?|"[^"\r\n]*"))';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::LITERAL;
    }
}
