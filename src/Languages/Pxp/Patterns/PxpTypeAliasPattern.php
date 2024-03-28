<?php

namespace Tempest\Highlight\Languages\Pxp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'type Label =', output: 'Label')]
final readonly class PxpTypeAliasPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return 'type\s+(?<match>[\w]+)\s*=';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}