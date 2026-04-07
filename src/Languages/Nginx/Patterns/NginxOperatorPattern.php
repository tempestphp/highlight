<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Nginx\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'listen 80;', output: ';')]
#[PatternTest(input: 'location = /health {', output: '=')]
final readonly class NginxOperatorPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>~\*|[;{}~=^])';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::OPERATOR;
    }
}
