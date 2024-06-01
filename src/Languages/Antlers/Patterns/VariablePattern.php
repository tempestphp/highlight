<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Antlers\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'a', output: null)]
#[PatternTest(input: 'foo', output: 'foo')]
#[PatternTest(input: '{{foo}}', output: 'foo')]
#[PatternTest(input: '{{ foo }}', output: 'foo')]
#[PatternTest(input: '{{ this_iS-RiDicuL-ou5_ }}', output: 'this_iS-RiDicuL-ou5_')]
final readonly class VariablePattern implements Pattern
{
    use IsPattern;

    /*
     * From the Antlers documentation:
     *
     * Variables must start with an alpha character or underscore,
     * followed by any number of additional uppercase or lowercase
     * alphanumeric characters, hyphens, or underscores,
     * but must not end with a hyphen.
     *
     * Spaces or other special characters are not allowed.
     */
    public function getPattern(): string
    {
        /** @lang RegExp */
        return '/(?<match>\$?[_A-Za-z][-_0-9A-Za-z]*[_A-Za-z0-9])/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VARIABLE;
    }
}
