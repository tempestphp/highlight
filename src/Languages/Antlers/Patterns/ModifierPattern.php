<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Antlers\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'variable | modifier', output: null)]
#[PatternTest(input: 'variable | modifier(parameters)', output: null)]
#[PatternTest(input: '{{ loop }} variable | modifier {{ /loop }}.', output: null)]
#[PatternTest(input: '{{ a }} text | dont_match {{ /a }}', output: null)]
#[PatternTest(
    input: '{{ hey | modifier }} text | dont_match {{ hey | matches_too }}',
    output: [
        'modifier',
        'matches_too',
    ]
)]
// #[PatternTest(
//     input: '{{ summary | replace("a", "b") | trans("c", "d") }}',
//     output: [
//         'replace', 'trans',
//     ]
// )] // TODO : This test is not working
final readonly class ModifierPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        /** @lang PhpRegExp */

        return '/{{[^{}]*\|\s*(?<match>\w+)(?:\([^)]*\))?[^{}]*}}/';
        // return '/{{[^{}]*\|\s*(\w+)(?:\([^)]*\))?([^{}]*\|\s*(\w+)(?:\([^)]*\))?)*[^{}]*}}/';

        // return '/{{[^{}]*\|\s*(?<match>\w+)(?:\([^)]*\))?([^{}]*\|\s*(?<match>\w+)(?:\([^)]*\))?)*[^{}]*}}/';
        // return '/{{[^{}]*?\|\s*(?<match>\w+)(?:\([^)]*\))?[^{}]*?}}/';
        // return '/{{(?:(?!{{|}}).)*?\s*\|\s*(?<match>\w+)(?:(?!{{|}}).)*?}}/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
