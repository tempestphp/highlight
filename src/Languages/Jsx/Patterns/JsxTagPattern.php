<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Jsx\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '<div></div>', output: ['div', 'div'])]
#[PatternTest(input: '<Button />', output: 'Button')]
#[PatternTest(input: '<UI.Icon />', output: 'UI.Icon')]
#[PatternTest(input: '<svg:path />', output: 'svg:path')]
final readonly class JsxTagPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?:(?<=<)|(?<=<\/))(?<match>[A-Za-z][\w]*(?:[.:-][\w-]+)*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
