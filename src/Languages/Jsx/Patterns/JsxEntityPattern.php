<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Jsx\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '<p>&amp; &#169; &#x1F44D;</p>', output: ['&amp;', '&#169;', '&#x1F44D;'])]
final readonly class JsxEntityPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>&(?:#[0-9]++|#x[0-9A-Fa-f]++|[A-Za-z][A-Za-z0-9]++);)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VALUE;
    }
}
