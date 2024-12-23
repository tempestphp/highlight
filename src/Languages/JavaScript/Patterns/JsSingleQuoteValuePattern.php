<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\JavaScript\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(
    input: "return 'hello';",
    output: "'hello'",
)]
final readonly class JsSingleQuoteValuePattern implements Pattern
{
    use IsPattern;

    #[\Override]
    public function getPattern(): string
    {
        return "(?<match>'(\\\'|.)*?')";
    }

    #[\Override]
    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
