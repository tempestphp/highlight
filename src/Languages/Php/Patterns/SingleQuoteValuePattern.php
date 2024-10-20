<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(
    input: "return 'hello';",
    output: "'hello'",
)]
#[PatternTest(
    input: "echo 'Yo\\';",
    output: "'Yo\\'",
)]
#[PatternTest(
    input: "echo 'Very \'long\'\\\'annoying\' string';",
    output: "'Very \'long\'\\\'annoying\' string'",
)]
final readonly class SingleQuoteValuePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return "(?<match>'(\\\'|.)*?')";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
