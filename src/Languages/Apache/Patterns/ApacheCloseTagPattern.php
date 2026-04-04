<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Apache\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '</VirtualHost>', output: 'VirtualHost')]
#[PatternTest(input: '</Directory>', output: 'Directory')]
#[PatternTest(input: '</IfModule>', output: 'IfModule')]
final readonly class ApacheCloseTagPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '<\/(?<match>[A-Za-z]\w*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
