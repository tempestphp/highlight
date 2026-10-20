<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\Languages\Ruby\RubyLexer;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(
    input: 'sql = <<~SQL
  SELECT 1
SQL',
    output: ['<<~SQL', '  SELECT 1
SQL'],
)]
#[PatternTest(
    input: "text = <<-'EOS'
  raw
  EOS",
    output: ["<<-'EOS'", '  raw
  EOS'],
)]
#[PatternTest(input: 'items << item', output: null)]
final readonly class RubyHeredocPattern implements Pattern
{
    public function match(string $content): array
    {
        return ['match' => new RubyLexer()->lex($content)['heredoc']];
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
