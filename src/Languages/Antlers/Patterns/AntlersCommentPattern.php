<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Antlers\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(
    input: '{{# test #}} content',
    output: '{{# test #}}',
)]
final readonly class AntlersCommentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        // return '/\{{#(?<match>(.|\n)*?)#\}}/m';
        return '(?<match>\{\{\#(.|\n)*?\#\}\})';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::COMMENT;
    }
}
