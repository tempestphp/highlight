<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Apache\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '# This is a comment', output: '# This is a comment')]
#[PatternTest(input: 'ServerName example.com # inline', output: '# inline')]
final readonly class ApacheCommentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>#.*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::COMMENT;
    }
}
