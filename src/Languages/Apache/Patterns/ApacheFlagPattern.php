<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Apache\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'SSLEngine on', output: 'on')]
#[PatternTest(input: 'SSLEngine off', output: 'off')]
#[PatternTest(input: 'Options All', output: 'All')]
#[PatternTest(input: 'Options None', output: 'None')]
#[PatternTest(input: 'Require all granted', output: 'granted')]
#[PatternTest(input: 'Require all denied', output: 'denied')]
final readonly class ApacheFlagPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/\b(?<match>on|off|All|None|granted|denied)\b/';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
