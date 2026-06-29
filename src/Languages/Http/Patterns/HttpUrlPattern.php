<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Http\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'POST /task?id=1 HTTP/1.1', output: '/task?id=1')]
#[PatternTest(input: 'POST https://api.example.com/users HTTP/2', output: 'https://api.example.com/users')]
final class HttpUrlPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<=\s)(?<match>\/[^\s]*|\w+:\/\/[^\s]*)(?=\sHTTP)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
