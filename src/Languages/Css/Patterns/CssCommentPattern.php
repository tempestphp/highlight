<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Css\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(
    input: '    /* 1 */
    font-feature-settings: normal;
    /* 2 */
    font-variation-settings: normal;',
    output: ['/* 1 */', '/* 2 */'],
)]
final readonly class CssCommentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>\/\*(.|\n)*?\*\/)/m';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::COMMENT;
    }
}
