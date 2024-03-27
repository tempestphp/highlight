<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Xml\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(
    input: 'test
            <!-- 
            foo
            -->
            test',
    output: '<!-- 
            foo
            -->'
)]
#[PatternTest(input: '<!-- foo --><div class="wrapper"><!-- foo2 -->', output: ['<!-- foo -->','<!-- foo2 -->'])]
final readonly class XmlCommentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/(?<match>\<!--(.|\n)*-->)/mU';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::COMMENT;
    }
}
