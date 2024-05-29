<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Json\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '"is_student": false', output: 'false')]
#[PatternTest(input: '"is_student": true', output: 'true')]
#[PatternTest(input: '"is_student": null', output: 'null')]
final readonly class JsonLiteralPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\b(?<match>(?:false|true|null))\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::LITERAL;
    }
}
