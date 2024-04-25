<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Css\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(
    input: 'src: url("fonts/MonaspaceArgon-Bold.woff") format("woff");',
    output: ['url', 'format'],
)]

#[PatternTest(
    input: 'background: linear-gradient(white 30%)',
    output: ['linear-gradient'],
)]
final readonly class CssFunctionPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>[\w\-]+)\(';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
