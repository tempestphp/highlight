<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

#[PatternTest(
    input: "return 'hello';",
    output: 'hello',
)]
final readonly class SingleQuoteValuePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return "'(?<match>.*?)'";
    }

    public function getTokenType(): TokenType
    {
        return TokenType::VALUE;
    }
}
