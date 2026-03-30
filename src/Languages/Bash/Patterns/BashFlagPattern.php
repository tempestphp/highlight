<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Bash\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'ls -la', output: '-la')]
#[PatternTest(input: 'grep --color=auto', output: '--color')]
final readonly class BashFlagPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>--?[a-zA-Z][\w-]*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::GENERIC;
    }
}