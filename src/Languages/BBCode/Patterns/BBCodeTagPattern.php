<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\BBCode\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '[b]bold text[/b]', output: 'b')]
#[PatternTest(input: '[url=http://example.com]link[/url]', output: 'url')]
#[PatternTest(input: '[img]image.png[/img]', output: 'img')]
#[PatternTest(input: '[*]list item', output: '*')]
#[PatternTest(input: '[color=#ff0000]red[/color]', output: 'color')]
#[PatternTest(input: '[list]', output: 'list')]
final readonly class BBCodeTagPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\[(?<match>[a-zA-Z\*]+)[\]=]';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
