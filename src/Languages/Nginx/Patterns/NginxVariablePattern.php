<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Nginx\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'proxy_set_header Host $host;', output: '$host')]
#[PatternTest(input: 'return 301 $scheme://example.com;', output: '$scheme')]
final readonly class NginxVariablePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>\$[a-zA-Z_]\w*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VARIABLE;
    }
}
