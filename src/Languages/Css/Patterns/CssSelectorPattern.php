<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Css\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenType;

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
final class CssSelectorPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>[\@\-\#\.\w\s,\n]+)\{';
    }

    public function getTokenType(): TokenType
    {
        return TokenType::KEYWORD;
    }
}
