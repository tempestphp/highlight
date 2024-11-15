<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Yaml\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'required: true', output: 'true')]
#[PatternTest(input: 'required: TRUE', output: 'TRUE')]
final readonly class YamlLogicalValuePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?i)\b(?<match>(?:true|false|yes|no|null))\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::LITERAL;
    }
}
