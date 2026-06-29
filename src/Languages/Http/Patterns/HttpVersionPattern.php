<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Http\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'GET /index.html HTTP/1.1', output: 'HTTP/1.1')]
#[PatternTest(input: 'HTTP/2 301', output: 'HTTP/2')]
#[PatternTest(input: 'HTTP/3 200', output: 'HTTP/3')]
final class HttpVersionPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>HTTP\/([32]|1\.[01]))';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
