<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: "name = 'Ada'", output: "'Ada'")]
#[PatternTest(input: "name = 'O\\'Brien'", output: "'O\\'Brien'")]
final readonly class RubySingleQuoteStringPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return "(?<match>'(?:\\\\'|.)*?')";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
