<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\BBCode\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '[url=http://example.com]link[/url]', output: 'http://example.com')]
#[PatternTest(input: '[color=#ff0000]red[/color]', output: '#ff0000')]
#[PatternTest(input: '[size=14]text[/size]', output: '14')]
#[PatternTest(input: '[quote=John]hello[/quote]', output: 'John')]
#[PatternTest(input: '[b]no attribute[/b]', output: null)]
final readonly class BBCodeAttributePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\[\w+=(?<match>[^\]]+)\]';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::ATTRIBUTE;
    }
}
