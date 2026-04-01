<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Terminal\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '$ npm install express', output: 'npm')]
#[PatternTest(input: '# docker ps -a', output: 'docker')]
#[PatternTest(input: '$ ./configure', output: './configure')]
final readonly class TerminalCommandNamePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '/^[\$#%>]\s+(?<match>[\w.\/-][\w.\/-]*)(?=\s|$)/m';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
