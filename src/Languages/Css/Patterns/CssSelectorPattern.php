<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Css\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(
    input: 'code, .asd, #id,
.hl-blur, @font-face,
kbd, samp,
pre {
    font-family: ui-monospace, monospace;
}',
    output: 'code, .asd, #id,
.hl-blur, @font-face,
kbd, samp,
pre ',
)]
#[PatternTest(input: "[data-x='asd'] .light {", output: "[data-x='asd'] .light ")]
#[PatternTest(input: "foo + bar {", output: "foo + bar ")]
#[PatternTest(input: "foo:hover {", output: "foo:hover ")]
final readonly class CssSelectorPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>[\[\]\'\"\=\@\-\#\.\w\s,\n\+\:]+)\{';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
