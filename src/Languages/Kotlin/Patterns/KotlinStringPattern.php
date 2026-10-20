<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Kotlin\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class KotlinStringPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>"""(?:[^"]++|"(?!"")|""(?!"))*+"""|"(?:\\\\.|[^"\\\\\r\n]++)*"|\'(?:\\\\.|[^\'\\\\\r\n])\')/s';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
