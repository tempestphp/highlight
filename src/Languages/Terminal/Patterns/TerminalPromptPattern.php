<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Terminal\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '$ npm install', output: '$')]
#[PatternTest(input: '# apt update', output: '#')]
#[PatternTest(input: '% brew install', output: '%')]
#[PatternTest(input: '> command', output: '>')]
final readonly class TerminalPromptPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/^(?<match>[\$#%>])(?=\s)/m';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::COMMENT;
    }
}
