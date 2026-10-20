<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\CLike\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '#include <stdio.h>', output: '<stdio.h>')]
#[PatternTest(input: '#include "local.h"', output: '"local.h"')]
final readonly class CLikeIncludePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/^[\t ]*#\s*(?:include_next|include)\s*(?<match><[^>\r\n]++>|"(?:\\\\.|[^"\\\\\r\n]++)*")/m';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
