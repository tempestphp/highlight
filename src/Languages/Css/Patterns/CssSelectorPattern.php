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
pre,
[data-foo="bar"] {
    font-family: ui-monospace, monospace;
}',
    output: 'code, .asd, #id,
.hl-blur, @font-face,
kbd, samp,
pre,
[data-foo="bar"] '
)]
final readonly class CssSelectorPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>[\@\-\#\.\w\s,\n\[\]+=\'"]+)\{';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
