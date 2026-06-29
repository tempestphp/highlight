<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Http\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'HTTP/2 301', output: '301')]
#[PatternTest(input: 'HTTP/1.1 200 OK', output: '200')]
#[PatternTest(input: 'content-length: 220', output: null)]
final class HttpStatusPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        // Only match the status code on a response start line (e.g. `HTTP/2 301`),
        // never a three-digit value within a header (e.g. `content-length: 220`).
        return '/(?m)(?<=^HTTP\/[32] |^HTTP\/1\.[01] )(?<match>\d{3})/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::NUMBER;
    }
}
