<?php

namespace Tempest\Highlight\Languages\Dockerfile\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: "RUN ['php']", output: "'php'")]
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