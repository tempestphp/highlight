<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Nginx\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'gzip on;', output: 'on')]
#[PatternTest(input: 'autoindex off;', output: 'off')]
final readonly class NginxBooleanPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\b(?<match>on|off)\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
