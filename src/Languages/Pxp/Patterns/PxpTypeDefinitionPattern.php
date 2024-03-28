<?php

namespace Tempest\Highlight\Languages\Pxp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'type Label = string | Closure | null;', output: 'string | Closure | null')]
final readonly class PxpTypeDefinitionPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return 'type\s+[\w]+\s*=\s*(?<match>.*?);';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}