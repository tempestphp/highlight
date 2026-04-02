<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\BBCode\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '[/b]', output: 'b')]
#[PatternTest(input: '[/url]', output: 'url')]
#[PatternTest(input: '[/code]', output: 'code')]
#[PatternTest(input: '[/quote]', output: 'quote')]
final readonly class BBCodeCloseTagPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\[\/(?<match>[a-zA-Z]+)\]';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
