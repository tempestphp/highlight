<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Http\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'Content-Type: application/json', output: 'Content-Type')]
#[PatternTest(input: 'x-frame-options: SAMEORIGIN', output: 'x-frame-options')]
final class HttpAttributePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>(?m)^[A-Za-z][A-Za-z0-9-]*(?=\:))';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::ATTRIBUTE;
    }
}
