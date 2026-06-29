<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Http\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'GET /index.html HTTP/1.1', output: 'GET')]
#[PatternTest(input: 'DELETE /user/1 HTTP/1.1', output: 'DELETE')]
#[PatternTest(input: 'POSTAL /a HTTP/1.1', output: null)]
final class HttpMethodPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>(?m)^(GET|POST|PUT|DELETE|PATCH|HEAD|OPTIONS|CONNECT|TRACE)\b)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
